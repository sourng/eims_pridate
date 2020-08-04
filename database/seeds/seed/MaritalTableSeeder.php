<?php

use App\Models\Marital;
use Illuminate\Database\Seeder;

class MaritalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marital::insert([
            [
                'name'          => 'single',
                'en'            => 'Single',
                'km'            => 'លីវ',
            ],
            [
                'name'          => 'married',
                'en'            => 'Married',
                'km'            => 'រៀបការ',
            ],
            [
                'name'          => 'divorced',
                'en'            => 'Divorced',
                'km'            => 'លែងលះ',
            ],
            [
                'name'          => 'widow',
                'en'            => 'Widow',
                'km'            => 'មេម៉ាយ',
            ],

        ]);
    }
}
