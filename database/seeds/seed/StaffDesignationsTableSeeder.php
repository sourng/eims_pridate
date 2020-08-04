<?php

use App\Models\StaffDesignations;
use Illuminate\Database\Seeder;

class StaffDesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffDesignations::insert([
            [
                'institute_id'  => 1,
                'name'        => 'principal',
                'en'          => 'Principal',
                'km'          => 'នាយក',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'teacher',
                'en'          => 'Teacher',
                'km'          => 'គ្រូបច្ចេកទេស',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'teacher_learning_support',
                'en'          => 'Teacher Learning Support',
                'km'          => 'គ្រូបង្រៀនស្មគ្រចិត្ត',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'security_guard',
                'en'          => 'Security Guard',
                'km'          => 'អ្នកយាម',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'accountant',
                'en'          => 'Accountant',
                'km'          => 'គណនេយ្យករ',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'driver',
                'en'          => 'Driver',
                'km'          => 'អ្នកបើកបរ',

            ],
        ]);
    }
}
