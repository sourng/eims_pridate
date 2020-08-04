<?php

use App\Models\StaffCertificate;
use Illuminate\Database\Seeder;

class StaffCertificateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffCertificate::insert([
            [
                'institute_id'  => 1,
                'name'        => 'Ministry of Labor Medium Education',
                'en'          => 'Ministry of Labor Medium Education',
                'km'          => 'ក្រសួងការងារមធ្យម',
                'description' => 'Ministry of Labor Medium Education',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'Ministry of Labor Higher Education',
                'en'          => 'Ministry of Labor Higher Education',
                'km'          => 'ក្រសួងការងារ ឧត្តម',
                'description' => 'Ministry of Labor Higher Education',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'Ministry of Primary Education',
                'en'          => 'Ministry of Primary Education',
                'km'          => 'ក្រសួងអប់រំ បឋម',
                'description' => 'Ministry of Primary Education',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'Ministry of Secondary Education',
                'en'          => 'Ministry of Secondary Education',
                'km'          => 'ក្រសួងអប់រំ មធ្យម',
                'description' => 'Ministry of Secondary Education',

            ],
            [
                'institute_id'  => 1,
                'name'        => 'Ministry of Higher Education',
                'en'          => 'Ministry of Higher Education',
                'km'          => 'ក្រសួងអប់រំ ឧត្តម',
                'description' => 'Ministry of Higher Education',

            ],

        ]);
    }
}
