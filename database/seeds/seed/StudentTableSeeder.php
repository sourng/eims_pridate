<?php

use App\Models\Students;
use App\Models\StudentsGuardians;
use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Students::insert([
            [
                'institute_id'          => 1,
                'id'                    => 1,
                'first_name_km'         => 'សែម',
                'last_name_km'          => 'គឹមសាន',
                'first_name_en'         => 'Sem',
                'last_name_en'          => 'Keamsan',
                'gender_id'             => 1,
                'nationality_id'        => 1,
                'national_id'           => 000000000000,
                'mother_tong_id'        => 1,
                'marital_id'            => 1,
                'blood_group_id'        => 7,
                'date_of_birth'         => '1998-10-16',
                'place_of_birth'        => json_encode([
                    'province' => 17,
                    'district' => 1709,
                    'commune'  => 170906,
                    'village'  => 17090602,
                ]),
                'current_resident'      => json_encode([
                    'province' => 17,
                    'district' => 1709,
                    'commune'  => 170906,
                    'village'  => 17090602,
                ]),
                'permanent_address'     => 'ត្រពាំងទឹម កណ្តែក ប្រាសាទបាគង ខេត្តសៀមរាប',
                'temporaray_address'    => 'ត្រពាំងទឹម កណ្តែក ប្រាសាទបាគង ខេត្តសៀមរាប',
                'phone'                 => '0969140554',
                'email'                 => 'keamsan.sem@gmail.com',
                'photo'                 => '05094196_901224124172117_6147539311321071191_n.jpg',
                'extra_info'            => null
            ],
            [
                'institute_id'          => 1,
                'id'                    => 2,
                'first_name_km'         => 'ផយ',
                'last_name_km'          => 'កញ្ញា',
                'first_name_en'         => 'Phoy',
                'last_name_en'          => 'Kanha',
                'gender_id'             => 1,
                'nationality_id'        => 1,
                'national_id'           => 000000000000,
                'mother_tong_id'        => 1,
                'marital_id'            => 1,
                'blood_group_id'        => 7,
                'date_of_birth'         => '1998-10-16',
                'place_of_birth'        => json_encode([
                    'province' => 17,
                    'district' => 1709,
                    'commune'  => 170906,
                    'village'  => 17090602,
                ]),
                'current_resident'      => json_encode([
                    'province' => 17,
                    'district' => 1709,
                    'commune'  => 170906,
                    'village'  => 17090602,
                ]),
                'permanent_address'     => 'ត្រពាំងទឹម កណ្តែក ប្រាសាទបាគង ខេត្តសៀមរាប',
                'temporaray_address'    => 'ត្រពាំងទឹម កណ្តែក ប្រាសាទបាគង ខេត្តសៀមរាប',
                'phone'                 => '0969140554',
                'email'                 => 'phoykanha@gmail.com',
                'photo'                 => '19925125_115631197118501_0546610706807711321_n.png',
                'extra_info'            => null
            ],

            [
                'institute_id'          => 1,
                'id'                    => 3,
                'first_name_km'         => 'កែវ',
                'last_name_km'          => 'រតនៈ',
                'first_name_en'         => 'Keo',
                'last_name_en'          => 'Rothnak',
                'gender_id'             => 1,
                'nationality_id'        => 1,
                'national_id'           => 000000000000,
                'mother_tong_id'        => 1,
                'marital_id'            => 1,
                'blood_group_id'        => 7,
                'date_of_birth'         => '1997-06-26',
                'place_of_birth'        => json_encode([
                    'province' => 22,
                    'district' => 2204,
                    'commune'  => 220404,
                    'village'  => 22040413,
                ]),
                'current_resident'      => json_encode([
                    'province' => 17,
                    'district' => 1710,
                    'commune'  => 171003,
                    'village'  => 17100302,
                ]),
                'permanent_address'     => 'វាល គោកចក សៀមរាប ខេត្តសៀមរាប',
                'temporaray_address'    => 'វាល គោកចក សៀមរាប ខេត្តសៀមរាប',
                'phone'                 => '093210060',
                'email'                 => 'rothnak123keo@gmail.com',
                'photo'                 => '69017443_107811111114051_3131011192811241311_n.png',
                'extra_info'            => null
            ],

            [
                'institute_id'          => 1,
                'id'                    => 4,
                'first_name_km'         => 'អ៊ាន',
                'last_name_km'          => 'ស៊ីណា',
                'first_name_en'         => 'Ean',
                'last_name_en'          => 'Sina',
                'gender_id'             => 1,
                'nationality_id'        => 1,
                'national_id'           => 000000000000,
                'mother_tong_id'        => 1,
                'marital_id'            => 1,
                'blood_group_id'        => 7,
                'date_of_birth'         => '1998-10-16',
                'place_of_birth'        => json_encode([
                    'province' => 17,
                    'district' => 1709,
                    'commune'  => 170906,
                    'village'  => 17090602,
                ]),
                'current_resident'      => json_encode([
                    'province' => 17,
                    'district' => 1709,
                    'commune'  => 170906,
                    'village'  => 17090602,
                ]),
                'permanent_address'     => 'ត្រពាំងទឹម កណ្តែក ប្រាសាទបាគង ខេត្តសៀមរាប',
                'temporaray_address'    => 'ត្រពាំងទឹម កណ្តែក ប្រាសាទបាគង ខេត្តសៀមរាប',
                'phone'                 => '0969140554',
                'email'                 => 'eansina@gmail.com',
                'photo'                 => '13111929_412101081409719_1070221890108213877_n.png',
                'extra_info'            => null
            ]


        ]);
        StudentsGuardians::insert([
            [
                'student_id'            => 1,

                'father_fullname'       => 'សួង សែម',
                'father_occupation'     => 'ធ្វើស្រែ',
                'father_phone'          => '092608805',
                'father_email'          => 'soungsem@gmail.com',
                'father_extra_info'     => 'ធ្វើស្រែ',

                'mother_fullname'       => 'ជុន រី',
                'mother_occupation'     => 'ធ្វើស្រែ',
                'mother_phone'          => '086608805',
                'mother_email'          => 'chunry@gmail.com',
                'mother_extra_info'     => 'ធ្វើស្រែ',

                //'guardian_is'         => 'father',

                'guardian_is'           => null,
                'guardian_fullname'     => 'ជុន រី',
                'guardian_occupation'   => 'ធ្វើស្រែ',
                'guardian_phone'        => '086608805',
                'guardian_email'        => 'chunry@gmail.com',
                'guardian_extra_info'   => 'ធ្វើស្រែ',

            ],

            [
                'student_id'            => 2,
                'father_fullname'       => 'សួង សែម',
                'father_occupation'     => 'ធ្វើស្រែ',
                'father_phone'          => '092608805',
                'father_email'          => 'soungsem@gmail.com',
                'father_extra_info'     => 'ធ្វើស្រែ',

                'mother_fullname'       => 'ជុន រី',
                'mother_occupation'     => 'ធ្វើស្រែ',
                'mother_phone'          => '086608805',
                'mother_email'          => 'chunry@gmail.com',
                'mother_extra_info'     => 'ធ្វើស្រែ',

                //'guardian_is'         => 'father',

                'guardian_is'           => null,
                'guardian_fullname'     => 'ជុន រី',
                'guardian_occupation'   => 'ធ្វើស្រែ',
                'guardian_phone'        => '086608805',
                'guardian_email'        => 'chunry@gmail.com',
                'guardian_extra_info'   => 'ធ្វើស្រែ',

            ],

            [
                'student_id'            => 3,
                'father_fullname'       => 'សួង សែម',
                'father_occupation'     => 'ធ្វើស្រែ',
                'father_phone'          => '092608805',
                'father_email'          => 'soungsem@gmail.com',
                'father_extra_info'     => 'ធ្វើស្រែ',

                'mother_fullname'       => 'ជុន រី',
                'mother_occupation'     => 'ធ្វើស្រែ',
                'mother_phone'          => '086608805',
                'mother_email'          => 'chunry@gmail.com',
                'mother_extra_info'     => 'ធ្វើស្រែ',

                //'guardian_is'         => 'father',

                'guardian_is'           => null,
                'guardian_fullname'     => 'ជុន រី',
                'guardian_occupation'   => 'ធ្វើស្រែ',
                'guardian_phone'        => '086608805',
                'guardian_email'        => 'chunry@gmail.com',
                'guardian_extra_info'   => 'ធ្វើស្រែ',

            ],
            [
                'student_id'            => 4,
                'father_fullname'       => 'សួង សែម',
                'father_occupation'     => 'ធ្វើស្រែ',
                'father_phone'          => '092608805',
                'father_email'          => 'soungsem@gmail.com',
                'father_extra_info'     => 'ធ្វើស្រែ',

                'mother_fullname'       => 'ជុន រី',
                'mother_occupation'     => 'ធ្វើស្រែ',
                'mother_phone'          => '086608805',
                'mother_email'          => 'chunry@gmail.com',
                'mother_extra_info'     => 'ធ្វើស្រែ',

                //'guardian_is'         => 'father',

                'guardian_is'           => null,
                'guardian_fullname'     => 'ជុន រី',
                'guardian_occupation'   => 'ធ្វើស្រែ',
                'guardian_phone'        => '086608805',
                'guardian_email'        => 'chunry@gmail.com',
                'guardian_extra_info'   => 'ធ្វើស្រែ',

            ],
        ]);
    }
}
