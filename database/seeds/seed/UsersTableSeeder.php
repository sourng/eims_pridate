<?php

use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #Administrator
        Users::insert([
            [
                'name'           => 'Administrator',
                'email'          => 'administrator@info.edu',
                'password'       => Hash::make(123456),
                'phone'          => '0123456789',
                'address'        => null,
                'location'       => null,
                'profile'        => 'admin.png',
                'role_id'        => 1,
                'node_id'        => null,
                'institute_id'   => null,
                'status'         => 'active',
            ],

        ]);

        #Manager
        Users::insert([

            [
                'name'           => 'ផង់ ពុទ្ធី',
                'email'          => 'phangputhy@info.edu',
                'password'       => Hash::make(123456),
                'phone'          => '0123456789',
                'address'        => null,
                'location'       => null,
                'profile'        => '22114111_015214419441801_7021515114051515609_n.jpg',
                'role_id'        => 2,
                'node_id'        => 1,
                'institute_id'   => 1,
                'status'         => 'active',
            ],
            [
                'name'           => 'ស្វាយរៀង',
                'email'          => 'svayrieng@info.edu',
                'password'       => Hash::make(123456),
                'phone'          => '0123456789',
                'address'        => null,
                'location'       => null,
                'profile'        => '10411287_283541015159943_7295066710070516799_n.png',
                'role_id'        => 2,
                'node_id'        => null,
                'institute_id'   => 2,
                'status'         => 'active',
            ],

            [
                'name'           => 'តាកែវ',
                'email'          => 'takeo@info.edu',
                'password'       => Hash::make(123456),
                'phone'          => '0969140554',
                'address'        => null,
                'location'       => null,
                'profile'        => '10636241_358302361005068_2131385123936676711_n.png',
                'role_id'        => 2,
                'node_id'        => null,
                'institute_id'   => 3,
                'status'         => 'active',
            ],
            [
                'name'           => 'កំពត',
                'email'          => 'kampot@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0969140554',
                'address'        => null,
                'location'       => null,
                'profile'        => '26804897_1466500576799877_4461500451081780365_n.png',
                'role_id'        => 2,
                'node_id'        => null,
                'institute_id'   => 4,
                'status'         => 'active',
            ],

            [
                'name'           => 'បាត់ដំបង',
                'email'          => 'battambang@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0969140554',
                'address'        => null,
                'location'       => null,
                'profile'        => '53220385_630531597361097_6343929762938880000_n.png',
                'role_id'        => 2,
                'node_id'        => null,
                'institute_id'   => 5,
                'status'         => 'active',
            ],

        ]);

        #Departments
        Users::insert([
            [
                'name'           => 'គុល សេរីរិទ្ធ',
                'email'          => 'kolseryrith@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0123456789',
                'address'        => null,
                'location'       => null,
                'profile'        => '83117194_558111205170220_1206817002021432751_n.png',
                'role_id'        => 10,
                'node_id'        => 3,
                'institute_id'   => 1,
                'status'         => 'active',
            ],

        ]);

         #Teacher
         Users::insert([
            [
                'name'           => 'សេង ស៊ង់',
                'email'          => 'sengsourng@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0123456789',
                'address'        => null,
                'location'       => null,
                'profile'        => '10115193_362078101681913_1321939736321056119_n.jpg',
                'role_id'        => 8,
                'node_id'        => 2,
                'institute_id'   => 1,
                'status'         => 'active',
            ],

        ]);

        # Students
        Users::insert([

            [
                'name'           => 'សែម គឹមសាន',
                'email'          => 'keamsan.sem@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0969140554',
                'address'        => null,
                'location'       => null,
                'profile'        => '11732100_911711176111733_5514110197111168135_n.png',
                'role_id'        => 6,
                'node_id'        => 1,
                'institute_id'   => 1,
                'status'         => 'active',
            ],
            [
                'name'           => 'ផយ កញ្ញា',
                'email'          => 'phoykanha@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0969140554',
                'address'        => null,
                'location'       => null,
                'profile'        => '19925125_115631197118501_0546610706807711321_n.png',
                'role_id'        => 6,
                'node_id'        => 2,
                'institute_id'   => 1,
                'status'         => 'active',
            ],

            [
                'name'           => 'កែវ រតនៈ',
                'email'          => 'rothnak123keo@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0969140554',
                'address'        => null,
                'location'       => null,
                'profile'        => '69017443_107811111114051_3131011192811241311_n.png',
                'role_id'        => 6,
                'node_id'        => 3,
                'institute_id'   => 1,
                'status'         => 'active',
            ],
            [
                'name'           => 'អ៊ាន ស៊ីណា',
                'email'          => 'eansina@gmail.com',
                'password'       => Hash::make(123456),
                'phone'          => '0969140554',
                'address'        => null,
                'location'       => null,
                'profile'        => '13111929_412101081409719_1070221890108213877_n.png',
                'role_id'        => 6,
                'node_id'        => 4,
                'institute_id'   => 1,
                'status'         => 'active',
            ],

        ]);
    }
}
