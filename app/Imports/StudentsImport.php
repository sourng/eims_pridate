<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Events\Import;
use App\Models\Gender;
use App\Models\Marital;
use App\Models\Students;
use App\Models\Institute;
use App\Helpers\DateHelper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Exports\StudentsRegisterTemplateExport;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;


HeadingRowFormatter::
    default('none');

class StudentsImport implements
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
        $_template = new StudentsRegisterTemplateExport;

        foreach ($rows->toArray() as $row) {
            ++$this->row;
            $row = array_values($row);

            if ($row && count($row) >= count($_template->headings())) {
                $fullname_km = explode(' ', $row[2]);
                $fullname_en = explode(' ', $row[3]);

                if (Institute::where('km', $row[1])->first() && Gender::where('km', $row[4])->first() && Marital::where('km', $row[6])->first()) {
                    request()->merge([
                        'first_name_km' => $fullname_km[0],
                        'last_name_km' => $fullname_km[1],
                        'first_name_en' => $fullname_en[0],
                        'last_name_en' => $fullname_en[1],
                        'gender' => Gender::where('km', $row[4])->first()->id,
                        'date_of_birth' => gettype($row[5]) == 'string' ? DateHelper::convert($row[5]) : Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])),
                        'marital'    => Marital::where('km', $row[6])->first()->id,
                        'permanent_address' =>  $row[7],
                        'temporaray_address' =>  $row[8],
                        'phone' =>  $row[9],
                        'email' =>  $row[10],
                        'nationality'   => 1,
                        'mother_tong'   => 1,
                        'institute'   => Institute::where('km', $row[1])->first()->id,
                    ]);

                    $add = Students::register();
                    $add['data'] = $row;
                    $add['row'] = $this->row;
                    event(new Import($add, request('console', '#console')));
                } else {
                    if (!Institute::where('km', $row[1])->first()) {
                        $errors[] = 'វិទ្យា : ' . $row[1] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
                    }
                    if (!Gender::where('km', $row[4])->first()) {
                        $errors[] = 'ភេទ : ' . $row[4] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
                    }
                    if (!Marital::where('km', $row[6])->first()) {
                        $errors[] = 'ស្ថានភាពគ្រួសារ : ' . $row[6] . 'តម្លៃដែលអ្នកបានបញ្ចូលមិនមាននៅក្នុងបញ្ជីទេ។';
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
