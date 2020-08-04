<?php

use App\Models\StudySession;
use Illuminate\Database\Seeder;

class StudySessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudySession::insert([
            [
                'institute_id'  => 1,
                'name'  => 'Morning',
                'en'    => 'Morning',
                'km'    => 'ពេលព្រឹក',
            ],
            [
                'institute_id'  => 1,
                'name'  => 'Evening',
                'en'    => 'Evening',
                'km'    => 'ពេលល្ងាច',
            ],

            [
                'institute_id'  => 1,
                'name'  => 'Night',
                'en'    => 'Night',
                'km'    => 'ពេលយប់',
            ],
        ]);
    }
}
