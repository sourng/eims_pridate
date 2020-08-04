<?php

use App\Models\Months;
use Illuminate\Database\Seeder;

class MonthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Months::insert([
            [
                'name' => 'January',
                'en'   => 'January',
                'km'   => 'មករា',
            ],
            [
                'name' => 'February',
                'en'   => 'February',
                'km'   => 'កុម្ភៈ',
            ],
            [
                'name' => 'March',
                'en'   => 'March',
                'km'   => 'មីនា',
            ],
            [
                'name' => 'April',
                'en'   => 'April',
                'km'   => 'មេសា',
            ],
            [
                'name' => 'May',
                'en'   => 'May',
                'km'   => 'ឧសភា',
            ],
            [
                'name' => 'June',
                'en'   => 'June',
                'km'   => 'មិថុនា',
            ],
            [
                'name' => 'July',
                'en'   => 'July',
                'km'   => 'កក្កដា',
            ],
            [
                'name' => 'August',
                'en'   => 'August',
                'km'   => 'សីហា',
            ],
            [
                'name' => 'September',
                'en'   => 'September',
                'km'   => 'កញ្ញា',
            ],
            [
                'name' => 'October',
                'en'   => 'October',
                'km'   => 'តុលា',
            ],
            [
                'name' => 'November',
                'en'   => 'November',
                'km'   => 'វិច្ឆិកា',
            ],
            [
                'name' => 'December',
                'en'   => 'December',
                'km'   => 'ធ្នូ',
            ],


        ]);
    }
}
