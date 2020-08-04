<?php

use App\Models\Nationality;
use Illuminate\Database\Seeder;

class NationalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nationality::insert([
            [
                'name'          => 'khmer',
                'en'            => 'Khmer',
                'km'            => 'ខ្មែរ',
            ],
            [
                'name'          => 'thai',
                'en'            => 'Thai',
                'km'            => 'ថៃ',
            ],
            [
                'name'          => 'vietnam',
                'en'            => 'Vietnam',
                'km'            => 'វៀតណាម',
            ],
            [
                'name'          => 'lao',
                'en'            => 'Lao',
                'km'            => 'ឡាវ',
            ],

        ]);
    }
}
