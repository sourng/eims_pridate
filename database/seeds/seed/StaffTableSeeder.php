<?php

use App\Models\Staff;
use App\Models\StaffExperience;
use App\Models\StaffGuardians;
use App\Models\StaffInstitutes;
use App\Models\StaffQualifications;
use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::insert([
            [
                'id'                => 1,
                'first_name_km'     => 'ផង់',
                'last_name_km'      => 'ពុទ្ធី',
                'first_name_en'     => 'Phang',
                'last_name_en'      => 'Puthy',
                'gender_id'         => 2,
                'staff_status_id'   => 3,
                'date_of_birth'     => '1960-06-08',
                'phone'             => '012778899',
                'email'             => 'phangputhy@info.edu',
                'photo'             => '22114111_015214419441801_7021515114051515609_n.jpg',
            ],
            [
                'id'                => 2,
                'first_name_km'     => 'សេង',
                'last_name_km'      => 'ស៊ុង',
                'first_name_en'     => 'Seng',
                'last_name_en'      => 'Sourng',
                'gender_id'         => 1,
                'staff_status_id'   => 3,
                'date_of_birth'     => '1983-05-12',
                'phone'             => '093771244',
                'email'             => 'sengsourng@gmail.com',
                'photo'             => '61255100_019136138241567_1191536111161011714_n.jpg',
            ],

            [
                'id'                => 3,
                'first_name_km'     => 'គុល',
                'last_name_km'      => 'សេរីរិទ្ធ',
                'first_name_en'     => 'Kol',
                'last_name_en'      => 'Seryrith',
                'gender_id'         => 1,
                'staff_status_id'   => 3,
                'date_of_birth'     => '1983-05-12',
                'phone'             => '081262672',
                'email'             => 'kolseryrith@gmail.com',
                'photo'             => 'male.jpg',
            ],

            [
                'id'                => 4,
                'first_name_km'     => 'ពុធ',
                'last_name_km'      => 'សុភារិទ្ធ',
                'first_name_en'     => 'Put',
                'last_name_en'      => 'Sophearith',
                'gender_id'         => 1,
                'staff_status_id'   => 3,
                'date_of_birth'     => '1983-05-12',
                'phone'             => '',
                'email'             => 'putsophearith@gmail.com',
                'photo'             => 'male.jpg',
            ],

            [
                'id'                => 5,
                'first_name_km'     => 'អ៊ីន',
                'last_name_km'      => 'សូឌិន',
                'first_name_en'     => 'Inn',
                'last_name_en'      => 'Sodin',
                'gender_id'         => 1,
                'staff_status_id'   => 3,
                'date_of_birth'     => '1983-05-12',
                'phone'             => '',
                'email'             => 'innsodin@gmail.com',
                'photo'             => 'male.jpg',
            ],
            [
                'id'                => 6,
                'first_name_km'     => 'អាន',
                'last_name_km'      => 'បញ្ញា',
                'first_name_en'     => 'Ann',
                'last_name_en'      => 'phanha',
                'gender_id'         => 2,
                'staff_status_id'   => 3,
                'date_of_birth'     => '1983-05-12',
                'phone'             => '',
                'email'             => 'annphanha@gmail.com',
                'photo'             => 'female.jpg',
            ],


        ]);
        StaffGuardians::insert([
            [
                'staff_id'          => 1,
            ],

            [
                'staff_id'          => 2,

            ],

            [
                'staff_id'          => 3,

            ],
            [
                'staff_id'          => 4,

            ],
            [
                'staff_id'          => 5,

            ],
            [
                'staff_id'          => 6,

            ],

        ]);
        StaffQualifications::insert([
            [
                'staff_id'          => 1,
            ],

            [
                'staff_id'          => 2,

            ],

            [
                'staff_id'          => 3,

            ],
            [
                'staff_id'          => 4,

            ],
            [
                'staff_id'          => 5,

            ],
            [
                'staff_id'          => 6,

            ],

        ]);
        StaffExperience::insert([
            [
                'staff_id'          => 1,
            ],

            [
                'staff_id'          => 2,

            ],

            [
                'staff_id'          => 3,

            ],
            [
                'staff_id'          => 4,

            ],
            [
                'staff_id'          => 5,

            ],
            [
                'staff_id'          => 6,

            ],

        ]);
        StaffInstitutes::insert([
            [
                'staff_id'          => 1,
                'institute_id'      => 1,
                'designation_id'    => 1
            ],

            [
                'staff_id'          => 2,
                'institute_id'      => 1,
                'designation_id'    => 2
            ],

            [
                'staff_id'          => 3,
                'institute_id'      => 1,
                'designation_id'    => 2
            ],
            [
                'staff_id'          => 4,
                'institute_id'      => 1,
                'designation_id'    => 2
            ],
            [
                'staff_id'          => 5,
                'institute_id'      => 1,
                'designation_id'    => 2
            ],
            [
                'staff_id'          => 6,
                'institute_id'      => 1,
                'designation_id'    => 2
            ],

        ]);
    }
}
