<?php

use App\Models\StudentsRequest;
use Illuminate\Database\Seeder;

class StudentsRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentsRequest::insert([
            [
                'id'                      => 1,
                'student_id'              => 1,
                'institute_id'            => 1,
                'study_program_id'        => 4,
                'study_course_id'         => 28,
                'study_generation_id'     => 1,
                'study_academic_year_id'  => 1,
                'study_semester_id'       => 1,
                'study_session_id'        => 1,
                'description'             => null,
                'photo'                   => '15115197_611400610022211_5111216161111725102_n.png',
                'status'                  => 1,
            ],
            [
                'id'                      => 2,
                'student_id'              => 2,
                'institute_id'            => 1,
                'study_program_id'        => 4,
                'study_course_id'         => 28,
                'study_generation_id'     => 1,
                'study_academic_year_id'  => 1,
                'study_semester_id'       => 1,
                'study_session_id'        => 1,
                'description'             => null,
                'photo'                   => '19925125_115631197118501_0546610706807711321_n.png',
                'status'                  => 1,
            ],
            [
                'id'                      => 3,
                'student_id'              => 3,
                'institute_id'            => 1,
                'study_program_id'        => 4,
                'study_course_id'         => 28,
                'study_generation_id'     => 1,
                'study_academic_year_id'  => 1,
                'study_semester_id'       => 1,
                'study_session_id'        => 1,
                'description'             => null,
                'photo'                   => '69017443_107811111114051_3131011192811241311_n.png',
                'status'                  => 1,
            ],
            [
                'id'                      => 4,
                'student_id'              => 4,
                'institute_id'            => 1,
                'study_program_id'        => 4,
                'study_course_id'         => 28,
                'study_generation_id'     => 1,
                'study_academic_year_id'  => 1,
                'study_semester_id'       => 1,
                'study_session_id'        => 1,
                'description'             => null,
                'photo'                   => '13111929_412101081409719_1070221890108213877_n.png',
                'status'                  => 1,
            ]
        ]);
    }
}
