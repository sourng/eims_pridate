<?php

use App\Models\StudyAcademicYears;
use Illuminate\Database\Seeder;

class StudyAcademicYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyAcademicYears::insert([
            [
                'institute_id'  => 1,
                'name' => 'Year I',
                'en'   => 'Year I',
                'km'   => 'ឆ្នាំទី ១',
            ],
            [
                'institute_id'  => 1,
                'name' => 'Year II',
                'en'   => 'Year II',
                'km'   => 'ឆ្នាំទី ២',
            ],
            [
                'institute_id'  => 1,
                'name' => 'Year III',
                'en'   => 'Year III',
                'km'   => 'ឆ្នាំទី ៣',
            ],
            [
                'institute_id'  => 1,
                'name' => 'Year IV',
                'en'   => 'Year IV',
                'km'   => 'ឆ្នាំទី ៤',
            ]
        ]);
    }
}
