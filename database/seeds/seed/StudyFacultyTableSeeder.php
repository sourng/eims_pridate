<?php

use App\Models\StudyFaculty;
use Illuminate\Database\Seeder;

class StudyFacultyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyFaculty::insert([
            [
                'name'              => 'Civil Engineering',
                'en'                => 'Civil Engineering',
                'km'                => 'វិស្វករសំណង់',

            ],
            [
                'name'              => 'Architecture',
                'en'                => 'Architecture',
                'km'                => 'ស្ថាបត្យកម្ម',

            ],
            [
                'name'              => 'Electrcity',
                'en'                => 'Electrcity',
                'km'                => 'អគ្គិសនី',

            ],
            [
                'name'              => 'Electronic',
                'en'                => 'Electronic',
                'km'                => 'អេឡិចត្រូនិច',

            ],
            [
                'name'              => 'Information Technology',
                'en'                => 'Information Technology',
                'km'                => 'វិទ្យាសាស្រ្តកុំព្យទ័រ',

            ],
        ]);
    }
}
