<?php

use App\Models\CourseTypes;
use Illuminate\Database\Seeder;

class CourseTyesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseTypes::insert([
            [
                'name'   => 'Short Course',
                'en'     => 'Short Course',
                'km'     => 'វគ្គខ្លី',

            ],
            [
                'name'   => 'Long Course',
                'en'     => 'Long Course',
                'km'     => 'វគ្គវែង',

            ],
        ]);
    }
}
