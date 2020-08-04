<?php

use App\Models\AttendancesType;
use Illuminate\Database\Seeder;

class AttendancesTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttendancesType::insert([
            [
                'institute_id'  => 1,
                'name'          => 'Present',
                'en'            => 'Present',
                'km'            => 'វត្តមាន',
                'credit_absent' => '0'
            ],
            [
                'institute_id'  => 1,
                'name'          => 'Absent',
                'en'            => 'Absent',
                'km'            => 'អវត្តមាន',
                'credit_absent' => '1'
            ],
            [
                'institute_id'  => 1,
                'name'          => 'Permission',
                'en'            => 'Permission',
                'km'            => 'លិខិតអវត្តមាន',
                'credit_absent' => '0.5'
            ],
            [
                'institute_id'  => 1,
                'name'          => 'Late',
                'en'            => 'Late',
                'km'            => 'មកយឺត',
                'credit_absent' => '0.5'
            ],
            [
                'institute_id'  => 1,
                'name'          => 'Leave',
                'en'            => 'Leave',
                'km'            => 'ចាកចេញមុនម៉ោង',
                'credit_absent' => '0.5'
            ],
            [
                'institute_id'  => 1,
                'name'          => 'Holidays',
                'en'            => 'Holidays',
                'km'            => 'ថ្ងៃសម្រាក',
                'credit_absent' => '0'
            ]
        ]);
    }
}
