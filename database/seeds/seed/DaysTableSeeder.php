<?php

use App\Models\Days;
use Illuminate\Database\Seeder;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Days::insert([
            [
                'name' => 'Monday',
                'en'   => 'Monday',
                'km'   => 'ច័ន្ទ',
            ],
            [
                'name' => 'Tuesday',
                'en'   => 'Tuesday',
                'km'   => 'អង្គារ៌',
            ],
            [
                'name' => 'Wednesday',
                'en'   => 'Wednesday',
                'km'   => 'ពុធ',
            ],
            [
                'name' => 'Thursday',
                'en'   => 'Thursday',
                'km'   => 'ព្រហស្បតិ៍',
            ],
            [
                'name' => 'Friday',
                'en'   => 'Friday',
                'km'   => 'សុក្រ',
            ],
            [
                'name' => 'Saturday',
                'en'   => 'Saturday',
                'km'   => 'សៅរ៌',
            ],
            [
                'name' => 'Sunday',
                'en'   => 'Sunday',
                'km'   => 'អាទិត្យ',
            ],

        ]);
    }
}
