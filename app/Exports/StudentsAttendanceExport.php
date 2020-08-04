<?php

namespace App\Exports;

use App\Models\StudentsAttendances;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsAttendanceExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return StudentsAttendances::all();
    }

    public function headings(): array
    {
        return (new StudentsAttendances)->getConnection()->getSchemaBuilder()->getColumnListing((new StudentsAttendances)->getTable());
    }
}
