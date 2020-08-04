<?php

use App\Models\QuizAnswerType;
use Illuminate\Database\Seeder;

class QuizAnswerTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuizAnswerType::insert([
            [
                'id' => 1,
                'name' => 'Signle Answer',
                'en' => 'Signle Answer (Has Answer)',
                'km' => 'ឆ្លើយចម្លើយបានតែមួយគត់​ (មានចម្លើយស្រាប់)',
                'description' => null,
                'image' => null,
            ],
            [
                'id' => 2,
                'name' => 'Multiple Answer',
                'en' => 'Multiple Answer (Has Answer)',
                'km' => 'ឆ្លើយចម្លើយបានច្រើន (មានចម្លើយស្រាប់)',
                'description' => null,
                'image' => null,
            ],
            [
                'id' => 3,
                'name' => 'Write Answer',
                'en' => 'Write Answer (No Answer)',
                'km' => 'ឆ្លើយចម្លើយដោយការសរសេរ',
                'description' => null,
                'image' => null,
            ]
        ]);
    }
}
