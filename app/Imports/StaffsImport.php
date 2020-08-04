<?php

namespace App\Imports;

use App\Events\Import;
use App\Exports\StaffsReqisterTemplateExport;
use App\Helpers\DateHelper;
use App\Models\Gender;
use App\Models\Institute;
use App\Models\Marital;
use App\Models\Staff;
use App\Models\StaffDesignations;
use App\Models\StaffStatus;
use App\Models\Students;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Imports\HeadingRowFormatter;


HeadingRowFormatter::
    default('none');

class StaffsImport implements
    ToCollection,
    WithHeadingRow,
    SkipsOnError,
    WithEvents,
    WithChunkReading,
    ShouldQueue
{
    use Importable, SkipsErrors, RegistersEventListeners;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private $row = 0;

    public function collection(Collection $rows)
    {
        event(new Import([
            'success'   => true,
            'data' => [],
            'total' => count($rows),

        ], request('console', '#console')));
        $_template = new StaffsReqisterTemplateExport;
        foreach ($rows->toArray() as $row) {
            ++$this->row;

            $row = array_values($row);
            if ($row && count($row) >= count($_template->headings())) {

                $fullname_km = explode(' ', $row[4]);
                $fullname_en = explode(' ', $row[5]);

                if (Institute::where('km', $row[1])->first() && StaffDesignations::where('km', $row[2])->first() && StaffStatus::where('km', $row[3])->first() && Gender::where('km', $row[6])->first() && Marital::where('km', $row[8])->first()) {
                    request()->merge([
                        'first_name_km' => $fullname_km[0],
                        'last_name_km' => $fullname_km[1],
                        'first_name_en' => $fullname_en[0],
                        'last_name_en' => $fullname_en[1],
                        'gender' => Gender::where('km', $row[6])->first()->id,
                        'date_of_birth' => DateHelper::convert($row[7]),
                        'marital'    => Marital::where('km', $row[8])->first()->id,
                        'permanent_address' =>  $row[9],
                        'temporaray_address' =>  $row[10],
                        'phone' =>  $row[11],
                        'email' =>  $row[12],
                        'nationality'   => 1,
                        'mother_tong'   => 1,
                        //
                        'institute' => Institute::where('km', $row[1])->first()->id,
                        'designation' => StaffDesignations::where('km', $row[2])->first()->id,
                        'status' => StaffStatus::where('km', $row[3])->first()->id,
                        //
                        'father_fullname'     => $row[13],
                        'father_occupation'   => $row[14],
                        'father_phone'        => $row[15],

                        'mother_fullname'     => $row[16],
                        'mother_occupation'   => $row[17],
                        'mother_phone'        => $row[18],
                    ]);

                    $add = Staff::register();
                    $add['data'] = $row;
                    $add['row'] = $this->row;
                    event(new Import($add, request('console', '#console')));
                } else {

                    if (!Institute::where('km', $row[1])->first()) {
                        $errors[] = 'វិទ្យាស្ថាន : ' . $row[1] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
                    }
                    if (!StaffDesignations::where('km', $row[2])->first()) {
                        $errors[] = 'ផ្នែក & តួនាទី : ' . $row[2] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
                    }
                    if (!StaffStatus::where('km', $row[3])->first()) {
                        $errors[] = 'ស្ថានភាព : ' . $row[3] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
                    }
                    if (!Gender::where('km', $row[6])->first()) {
                        $errors[] = 'ភេទ : ' . $row[6] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
                    }

                    if (!Marital::where('km', $row[8])->first()) {
                        $errors[] = 'ស្ថានភាពគ្រួសារ : ' . $row[8] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
                    }

                    event(new Import([
                        'success'   => false,
                        'errors'   => $errors,
                        'data' => $row,
                        'row' => $this->row,

                    ], request('console', '#console')));
                }
            } else {
                event(new Import([
                    'success'   => false,
                    'errors'   => [
                        'ទម្រងដែលអ្នកបញ្ចូលនេះ មិនត្រូវគ្នាជាមួយគំរូខាងលើទេ។'
                    ],
                    'data' => $row,
                    'row' => $this->row,

                ], request('console', '#console')));
            }
        }
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
