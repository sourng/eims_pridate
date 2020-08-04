<?php

use App\Models\CertificateFrames;
use Illuminate\Database\Seeder;

class CertificateFramesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CertificateFrames::insert([
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Certificate blue vertical',
                'front'        => 'blue.png',
                'layout'       => 'vertical',
                'status'       => 1,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Certificate green vertical',
                'front'        => 'green.png',
                'layout'       => 'vertical',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Certificate red vertical',
                'front'        => 'red.png',
                'layout'       => 'vertical',
                'status'       => 0,
            ],

        ]);
    }
}
