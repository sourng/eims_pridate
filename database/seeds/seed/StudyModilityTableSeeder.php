<?php

use App\Models\StudyModality;
use Illuminate\Database\Seeder;

class StudyModilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyModality::insert([
            [
                'name'  => 'Center Base',
                'en'    => 'Center Base',
                'km'    => 'តាមសហគ្រាស',
            ],
            [
                'name'  => 'Interprise Base',
                'en'    => 'Interprise Base',
                'km'    => 'តាមសហគមន៍',
            ],
            [
                'name'  => 'Institute',
                'en'    => 'Institute',
                'km'    => 'វិទ្យាស្ថាន',
            ],
        ]);
    }
}
