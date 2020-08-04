<?php

use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizQuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuizQuestion::insert([
            [
                'id'                    => 1,
                'quiz_id'               => 1,
                'quiz_answer_type_id'   => 1,
                'quiz_question_type_id' => 1,
                'question'              => '1 + 1 = ?',
                'marks'                 => 10,
            ],
            [
                'id'                    => 2,
                'quiz_id'               => 1,
                'quiz_answer_type_id'   => 2,
                'quiz_question_type_id' => 2,
                'question'              => '1 + 1 = ?',
                'marks'                 => 10,
            ],
            [
                'id'                    => 3,
                'quiz_id'               => 1,
                'quiz_answer_type_id'   => 3,
                'quiz_question_type_id' => 2,
                'question'              => '1 + 5 = ?',
                'marks'                 => 10,
            ]
        ]);

        QuizAnswer::insert([
            [
                'quiz_question_id'      => 1,
                'answer'                => 1,
                'correct_answer'        => 0,
            ],
            [
                'quiz_question_id'      => 1,
                'answer'                => 2,
                'correct_answer'        => 1,
            ],
            [
                'quiz_question_id'      => 1,
                'answer'                => 3,
                'correct_answer'        => 0,
            ],


            [
                'quiz_question_id'      => 2,
                'answer'                => 2,
                'correct_answer'        => 1,
            ],
            [
                'quiz_question_id'      => 2,
                'answer'                => 3,
                'correct_answer'        => 0,
            ],
            [
                'quiz_question_id'      => 2,
                'answer'                => '10 (Binary)',
                'correct_answer'        => 1,
            ],


            [
                'quiz_question_id'      => 3,
                'answer'                => 5,
                'correct_answer'        => 1,
            ],

        ]);
    }
}
