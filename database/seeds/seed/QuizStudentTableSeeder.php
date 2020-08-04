<?php

use App\Models\QuizStudent;
use Illuminate\Database\Seeder;

class QuizStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuizStudent::insert([
            [
                'quiz_id'                => 1,
                'student_study_course_id' => 1,
            ],
            [
                'quiz_id'                => 1,
                'student_study_course_id' => 3,
            ]
        ]);
    }
}
