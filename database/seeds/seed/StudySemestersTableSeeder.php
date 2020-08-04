<?php

use App\Models\StudySemesters;
use Illuminate\Database\Seeder;

class StudySemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudySemesters::insert([
            [
                'institute_id'  => 1,
                'name'       => 'Semester I',
                'en'         => 'Semester I',
                'km'         => 'ឆមាសទី ១',

            ],
            [
                'institute_id'  => 1,
                'name'       => 'Semester II',
                'en'         => 'Semester II',
                'km'         => 'ឆមាសទី ២',

            ],
            [
                'institute_id'  => 1,
                'name'       => 'Semester III',
                'en'         => 'Semester III',
                'km'         => 'ឆមាសទី ៣',

            ],
            [
                'institute_id'  => 1,
                'name'       => 'Semester IV',
                'en'         => 'Semester IV',
                'km'         => 'ឆមាសទី ៤',

            ],

        ]);
    }
}
