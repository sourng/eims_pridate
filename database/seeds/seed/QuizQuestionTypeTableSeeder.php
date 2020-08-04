<?php

use App\Models\QuizQuestionType;
use Illuminate\Database\Seeder;

class QuizQuestionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuizQuestionType::insert([
            [

                'institute_id'  => 1,
                'name'  => 'health',
                'en'    => 'Health',
                'km'    => 'សុខភាព',
            ],
            [
                'institute_id'  => 1,
                'name'  => 'knowlagde',
                'en'    => 'Knowlagde',
                'km'    => 'ចំនេះដឹង',
            ]
        ]);
    }
}
