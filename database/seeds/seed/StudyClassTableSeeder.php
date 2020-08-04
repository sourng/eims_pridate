<?php

use App\Models\StudyClass;
use Illuminate\Database\Seeder;

class StudyClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyClass::insert([
            [
                'institute_id'  => 1,
                'name' => 'A1',
                'en'   => 'A1',
                'km'   => 'ថ្នាក់ ក១',
            ],
            [
                'institute_id'  => 1,
                'name' => 'A2',
                'en'   => 'A2',
                'km'   => 'ថ្នាក់ ក២',
            ],
            [
                'institute_id'  => 1,
                'name' => 'A3',
                'en'   => 'A3',
                'km'   => 'ថ្នាក់ ក៣',
            ],
            [
                'institute_id'  => 1,
                'name' => 'A4',
                'en'   => 'A4',
                'km'   => 'ថ្នាក់ ក៤',
            ],
            [
                'institute_id'  => 1,
                'name' => 'A5',
                'en'   => 'A5',
                'km'   => 'ថ្នាក់ ក៥',
            ],
        ]);
    }
}
