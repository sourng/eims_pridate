<?php

use App\Models\Years;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Years::insert([
            [
                'name' => '2020',
            ],
        ]);
    }
}
