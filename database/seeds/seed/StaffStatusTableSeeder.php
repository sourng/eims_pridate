<?php

use App\Models\StaffStatus;
use Illuminate\Database\Seeder;

class StaffStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffStatus::insert([
            [
                'institute_id'  => 1,
                'name'    => 'Apply for staff',
                'en'      => 'Apply for staff',
                'km'      => 'ស្នើសុំចូលធ្វើការ',
                'color'   => 'bg-yellow text-black',
            ],
            [
                'institute_id'  => 1,
                'name'    => 'New staff',
                'en'      => 'New staff',
                'km'      => 'បុគ្គលិកថ្មី',
                'color'   => 'bg-blue text-white',

            ],
            [
                'institute_id'  => 1,
                'name'    => 'Old staff',
                'en'      => 'Old staff',
                'km'      => 'បុគ្គលិកចាស់',
                'color'   => 'bg-secondary',

            ],

            [
                'institute_id'  => 1,
                'name'    => 'Resign',
                'en'      => 'Resign',
                'km'      => 'ឈប់ធ្វើការ',
                'color'   => 'bg-red text-white',

            ],
            [
                'institute_id'  => 1,
                'name'    => 'Transfer In',
                'en'      => 'Transfer In',
                'km'      => 'ផ្ទេរចូល',
                'color'   => 'bg-info text-white',

            ],
            [
                'institute_id'  => 1,
                'name'    => 'Transfer Out',
                'en'      => 'Transfer Out',
                'km'      => 'ផ្ទេរចេញ',
                'color'   => 'bg-warning text-white',

            ],
        ]);
    }
}
