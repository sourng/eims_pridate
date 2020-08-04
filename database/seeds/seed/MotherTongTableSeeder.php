<?php

use App\Models\MotherTong;
use Illuminate\Database\Seeder;

class MotherTongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MotherTong::insert([
            [
                'name'          => 'khmer language',
                'en'            => 'Khmer Language',
                'km'            => 'ភាសាខ្មែរ',
            ],
            [
                'name'          => 'thai language',
                'en'            => 'Thai Language',
                'km'            => 'ភាសាថៃ',
            ],
            [
                'name'          => 'vietnam language',
                'en'            => 'Vietnam Language',
                'km'            => 'ភាសាវៀតណាម',
            ],
            [
                'name'          => 'lao language',
                'en'            => 'Lao Language',
                'km'            => 'ភាសាឡាវ',
            ],

        ]);
    }
}
