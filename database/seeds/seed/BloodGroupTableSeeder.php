<?php

use App\Models\BloodGroup;
use Illuminate\Database\Seeder;

class BloodGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BloodGroup::insert([
            [
                'name'          => 'A+',
                'en'            => 'A+',
                'km'            => 'ប្រភេទ A+',
            ],
            [
                'name'          => 'A-',
                'en'            => 'A-',
                'km'            => 'ប្រភេទ A-',
            ],
            [
                'name'          => 'AB+',
                'en'            => 'AB+',
                'km'            => 'ប្រភេទ AB+',
            ],
            [
                'name'          => 'AB-',
                'en'            => 'AB-',
                'km'            => 'ប្រភេទ AB-',
            ],
            [
                'name'          => 'B+',
                'en'            => 'B+',
                'km'            => 'ប្រភេទ B+',
            ],
            [
                'name'          => 'B-',
                'en'            => 'B-',
                'km'            => 'ប្រភេទ B-',
            ],
            [
                'name'          => 'O+',
                'en'            => 'O+',
                'km'            => 'ប្រភេទ O+',
            ],
            [
                'name'          => 'O-',
                'en'            => 'O-',
                'km'            => 'ប្រភេទ O-',
            ],

        ]);
    }
}
