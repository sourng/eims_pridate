<?php

use App\Models\ThemeBackground;
use Illuminate\Database\Seeder;

class ThemeBackgroundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThemeBackground::insert([
            [
                'name'  => '',
                'en'    => '',
                'km'    => '',
                'image' => '1.png',
                'status' => 1,
            ],
            [
                'name'  => '',
                'en'    => '',
                'km'    => '',
                'image' => '2.webp',
                'status' => 0,
            ],
            [
                'name'  => '',
                'en'    => '',
                'km'    => '',
                'image' => '3.jpg',
                'status' => 0,
            ],
        ]);
    }
}
