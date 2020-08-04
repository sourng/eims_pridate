<?php

use App\Models\StudySubjects;
use Illuminate\Database\Seeder;

class StudySubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudySubjects::insert([
            [
                'institute_id'  => 1,
                'course_type_id'  => 1,
                'name'                     => 'English',
                'en'                       => 'English',
                'km'                       => 'ភាសាអង់គ្លេស',
                'full_mark_theory'         => 50,
                'pass_mark_theory'         => 50,
                'full_mark_practical'      => 60,
                'pass_mark_practical'      => 60,
                'credit_hour'              => 60,
                'description'              => 'English for ICT',
                'image'                    => null,

            ],
            [
                'institute_id'  => 1,
                'course_type_id'  => 1,
                'name'                     => 'C++ PROGRAMMING UPDATE 2018',
                'en'                       => 'C++ PROGRAMMING UPDATE 2018',
                'km'                       => 'កម្មវិធី C ++ ឆ្នាំ២០១៨',
                'full_mark_theory'         => 50,
                'pass_mark_theory'         => 50,
                'full_mark_practical'      => 60,
                'pass_mark_practical'      => 60,
                'credit_hour'              => 60,
                'description'              => 'C++ PROGRAMMING UPDATE 2018',
                'image'                    => null,

            ],
            [
                'institute_id'  => 1,
                'course_type_id'  => 1,
                'name'                    => 'VB.NET PROGRAMMING',
                'en'                       => 'VB.NET PROGRAMMING',
                'km'                       => 'កម្មវិធី VB.NET',
                'full_mark_theory'         => 50,
                'pass_mark_theory'         => 50,
                'full_mark_practical'      => 60,
                'pass_mark_practical'      => 60,
                'credit_hour'              => 60,
                'description'              => 'VB.NET PROGRAMMING',
                'image'                    => null,

            ],
            [
                'institute_id'  => 1,
                'course_type_id'  => 1,
                'name'                    => 'DATA STRUCTURE AND ALGORITHM',
                'en'                       => 'DATA STRUCTURE AND ALGORITHM',
                'km'                       => 'រចនាសម្ព័ន្ធទិន្នន័យនិងក្បួនដោះស្រាយ',
                'full_mark_theory'         => 50,
                'pass_mark_theory'         => 50,
                'full_mark_practical'      => 60,
                'pass_mark_practical'      => 60,
                'credit_hour'              => 60,
                'description'              => 'DATA STRUCTURE AND ALGORITHM',
                'image'                    => null,

            ],
            [
                'institute_id'  => 1,
                'course_type_id'  => 1,
                'name'                    => 'JAVA PROGRAMMING',
                'en'                       => 'JAVA PROGRAMMING',
                'km'                       => 'កម្មវិធី JAVA',
                'full_mark_theory'         => 50,
                'pass_mark_theory'         => 50,
                'full_mark_practical'      => 60,
                'pass_mark_practical'      => 60,
                'credit_hour'              => 60,
                'description'              => 'JAVA PROGRAMMING',
                'image'                    => null,

            ],
        ]);
    }
}
