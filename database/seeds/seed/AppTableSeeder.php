<?php

use App\Models\App;
use Illuminate\Database\Seeder;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       App::insert([
            [
                'id'               => 1,
                'status'           => 1,
                'name'             => 'School Management System',
                'en'               => 'School Management System',
                'km'               => 'ប្រព័ន្ធគ្រប់គ្រងសាលារៀន',
                'phone'            => '(+855) 969 140 554',
                'email'            => 'info@rpitssr.edu.kh',
                'address'          => 'បន្ទាយចាស់, ស្លក្រាម, ក្រុងសៀមរាប, សៀមរាប',
                'location'         => '',
                'website'          => 'https://www.rpitssr.edu.kh',
                'logo'             => 'logo.png',
                'favicon'          => 'favicon.png',
                'theme_color_id'   => 12,
            ],
        ]);
    }
}
