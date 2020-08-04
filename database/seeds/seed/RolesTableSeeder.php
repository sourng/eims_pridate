<?php

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::insert([
            [
                'id'          => 1,
                'name'        => 'administrator',
                'en'          => 'Administrator',
                'km'          => 'អ្នកគ្រប់គ្រងជាន់ខ្ពស់',
                'description' => 'Administrator',
                'view_path'   => 'Administrator',

            ],
            [
                'id'          => 2,
                'name'        => 'manager',
                'en'          => 'Manager',
                'km'          => 'អ្នកគ្រប់គ្រង',
                'description' => 'Manager',
                'view_path'   => 'Manager',

            ],
            [
                'id'          => 3,
                'name'        => 'account',
                'en'          => 'Accountant',
                'km'          => 'គណនេយ្យករ',
                'description' => 'Accountant',
                'view_path'   => 'Accountant',

            ],
            [
                'id'          => 4,
                'name'        => 'library',
                'en'          => 'Librarian',
                'km'          => 'បណ្ណារក្ស',
                'description' => 'Librarian',
                'view_path'   => 'Librarian',

            ],
            [
                'id'          => 5,
                'name'        => 'staff',
                'en'          => 'Staff',
                'km'          => 'បុគ្គលិក',
                'description' => 'Staff',
                'view_path'   => 'Staff',

            ],
            [
                'id'          => 6,
                'name'        => 'student',
                'en'          => 'Student',
                'km'          => 'និស្សិត',
                'description' => 'Student',
                'view_path'   => 'Student',

            ],
            [
                'id'          => 7,
                'name'        => 'guardian',
                'en'          => 'Guardian',
                'km'          => 'អាណាព្យាបាល',
                'description' => 'Guardian',
                'view_path'   => 'Guardian',

            ],
            [
                'id'          => 8,
                'name'        => 'teacher',
                'en'          => 'Teacher',
                'km'          => 'គ្រូ',
                'description' => 'Teacher',
                'view_path'   => 'Teacher',

            ],
            [
                'id'          => 9,
                'name'        => 'user',
                'en'          => 'User',
                'km'          => 'អ្នកប្រើប្រាស់',
                'description' => 'User',
                'view_path'   => 'Users',

            ],

            [
                'id'          => 10,
                'name'        => 'department',
                'en'          => 'Department',
                'km'          => 'ដេប៉ាតឺម៉ង់',
                'description' => 'Department',
                'view_path'   => 'Department',

            ],

        ]);
    }
}
