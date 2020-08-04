<?php

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quiz::insert([
            [
                'institute_id'        => 1,
                'name'        => 'ICT-B1',
                'en'          => 'ICT-B1',
                'km'          => 'ICT-ជំនាន់១',
            ]
        ]);
    }
}
