<?php

use App\Models\Languages;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Languages::insert([
            [
                'name'          => 'english',
                'country_code'  => 000,
                'code_name'     => 'en',
                'en'            => 'English',
                'km'            => 'អង់គ្លេស',
                'image'         => 'en.png',
             ],
             [
                'name'          => 'khmer',
                'country_code'  => 855,
                'code_name'     => 'km',
                'en'            => 'Khmer',
                'km'            => 'ខ្មែរ',
                'image'         => 'km.png',
             ],
        ]);
    }
}
