<?php

use Carbon\Carbon;
use App\Helpers\DateHelper;
use Illuminate\Database\Seeder;
use App\Models\StudyCourseRoutine;
use App\Models\StudyCourseSchedule;
use App\Models\StudyCourseSession;

class StudyCoursesScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        StudyCourseSchedule::insert([
            [
                'id'                     => 1,
                'institute_id'           => 1,
                'study_program_id'       => 4,
                'study_course_id'        => 28,
                'study_generation_id'    => 1,
                'study_academic_year_id' => 1,
                'study_semester_id'      => 1,
            ],
            [
                'id'                     => 2,
                'institute_id'           => 1,
                'study_program_id'       => 4,
                'study_course_id'        => 28,
                'study_generation_id'    => 1,
                'study_academic_year_id' => 1,
                'study_semester_id'      => 2,
            ],
            [
                'id'                     => 3,
                'institute_id'           => 1,
                'study_program_id'       => 4,
                'study_course_id'        => 28,
                'study_generation_id'    => 1,
                'study_academic_year_id' => 1,
                'study_semester_id'      => 3,
            ],
            [
                'id'                     => 4,
                'institute_id'           => 1,
                'study_program_id'       => 4,
                'study_course_id'        => 28,
                'study_generation_id'    => 1,
                'study_academic_year_id' => 1,
                'study_semester_id'      => 4,
            ],
        ]);

        StudyCourseSession::insert([
            [
                'id'    => 1,
                'study_course_schedule_id' => 1,
                'study_session_id'   => 1,
                'study_start'            => DateHelper::convert(Carbon::now()),
                'study_end'              => DateHelper::convert(Carbon::now()->addYears(1)),
            ],
        ]);

        StudyCourseRoutine::insert([
            [
                'study_course_session_id' => 1,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'day_id' => 1,
                'teacher_id' => 2,
                'study_subject_id' => 4,
                'study_class_id' => 1,

            ],

            [
                'study_course_session_id' => 1,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'day_id' => 2,
                'teacher_id' => 3,
                'study_subject_id' => 2,
                'study_class_id' => 1,

            ],

            [
                'study_course_session_id' => 1,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'day_id' => 3,
                'teacher_id' => 2,
                'study_subject_id' => 4,
                'study_class_id' => 1,

            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'day_id' => 4,
                'teacher_id' => 5,
                'study_subject_id' => 1,
                'study_class_id' => 1,

            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'day_id' => 5,
                'teacher_id' => 2,
                'study_subject_id' => 4,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'day_id' => 6,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'day_id' => 7,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
                'day_id' => 1,
                'teacher_id' => 2,
                'study_subject_id' => 4,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
                'day_id' => 2,
                'teacher_id' => 3,
                'study_subject_id' => 2,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
                'day_id' => 3,
                'teacher_id' => 2,
                'study_subject_id' => 4,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
                'day_id' => 4,
                'teacher_id' => 5,
                'study_subject_id' => 1,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
                'day_id' => 5,
                'teacher_id' => 2,
                'study_subject_id' => 4,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
                'day_id' => 6,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:30:00',
                'day_id' => 7,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '09:30:00',
                'end_time' => '10:30:00',
                'day_id' => 1,
                'teacher_id' => 4,
                'study_subject_id' => 3,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '09:30:00',
                'end_time' => '10:30:00',
                'day_id' => 2,
                'teacher_id' => 5,
                'study_subject_id' => 1,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '09:30:00',
                'end_time' => '10:30:00',
                'day_id' => 3,
                'teacher_id' => 4,
                'study_subject_id' => 3,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '09:30:00',
                'end_time' => '10:30:00',
                'day_id' => 4,
                'teacher_id' => 3,
                'study_subject_id' => 2,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '09:30:00',
                'end_time' => '10:30:00',
                'day_id' => 5,
                'teacher_id' => 6,
                'study_subject_id' => 5,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '09:30:00',
                'end_time' => '10:30:00',
                'day_id' => 6,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '09:30:00',
                'end_time' => '10:30:00',
                'day_id' => 7,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '10:30:00',
                'end_time' => '11:30:00',
                'day_id' => 1,
                'teacher_id' => 4,
                'study_subject_id' => 3,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '10:30:00',
                'end_time' => '11:30:00',
                'day_id' => 2,
                'teacher_id' => 5,
                'study_subject_id' => 1,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '10:30:00',
                'end_time' => '11:30:00',
                'day_id' => 3,
                'teacher_id' => 4,
                'study_subject_id' => 3,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '10:30:00',
                'end_time' => '11:30:00',
                'day_id' => 4,
                'teacher_id' => 3,
                'study_subject_id' => 2,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '10:30:00',
                'end_time' => '11:30:00',
                'day_id' => 5,
                'teacher_id' => 6,
                'study_subject_id' => 5,
                'study_class_id' => 1,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '10:30:00',
                'end_time' => '11:30:00',
                'day_id' => 6,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ],
            [
                'study_course_session_id' => 1,
                'start_time' => '10:30:00',
                'end_time' => '11:30:00',
                'day_id' => 7,
                'teacher_id' => null,
                'study_subject_id' => null,
                'study_class_id' => null,
            ]
        ]);
    }
}
