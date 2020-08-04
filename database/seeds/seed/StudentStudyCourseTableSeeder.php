<?php

use App\Models\StudentsStudyCourse;
use Illuminate\Database\Seeder;

class StudentStudyCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentsStudyCourse::insert([
            [
                'student_request_id'      => 1,
                'study_course_session_id' => 1,
                'study_status_id'         => 1,
                'photo'                   => '15115197_611400610022211_5111216161111725102_n.png',
            ],
            [
                'student_request_id'      => 2,
                'study_course_session_id' => 1,
                'study_status_id'         => 1,
                'photo'                   => '19925125_115631197118501_0546610706807711321_n.png',
            ],
            [
                'student_request_id'      => 3,
                'study_course_session_id' => 1,
                'study_status_id'         => 1,
                'photo'                   => '69017443_107811111114051_3131011192811241311_n.png',
            ],
            [
                'student_request_id'      => 4,
                'study_course_session_id' => 1,
                'study_status_id'         => 1,
                'photo'                   => '13111929_412101081409719_1070221890108213877_n.png',
            ],

        ]);
    }
}
