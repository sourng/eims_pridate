<?php

use App\Models\StudyGeneration;
use Illuminate\Database\Seeder;

class StudyGenerationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyGeneration::insert([
            [
                'institute_id'  => 1,
                'name' => 'I',
                'en'   => 'First Generation',
                'km'   => 'ជំនាន់ ១',
            ],
        ]);
    }
}
