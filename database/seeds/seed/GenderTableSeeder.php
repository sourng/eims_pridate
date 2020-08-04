<?php

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::insert([
            [
                'name'          => 'male',
                'en'            => 'Male',
                'km'            => 'ប្រុស',
            ],
            [
                'name'          => 'female',
                'en'            => 'Female',
                'km'            => 'ស្រី',
            ],

        ]);
    }
}
