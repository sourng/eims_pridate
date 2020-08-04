<?php

use App\Models\CardFrames;
use Illuminate\Database\Seeder;

class CardFramesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CardFrames::insert([
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card blue vertical',
                'front'        => 'blue-01.jpg',
                'background'   => 'blue-02.jpg',
                'layout'       => 'vertical',
                'status'       => 1,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card blue horizontal',
                'front'        => 'blue-03.jpg',
                'background'   => 'blue-04.jpg',
                'layout'       => 'horizontal',
                'status'       => 0,
            ],

            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card red vertical',
                'front'        => 'red-01.jpg',
                'background'   => 'red-02.jpg',
                'layout'       => 'vertical',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card red horizontal',
                'front'        => 'red-03.jpg',
                'background'   => 'red-04.jpg',
                'layout'       => 'horizontal',
                'status'       => 0,
            ],

            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card green vertical',
                'front'        => 'green-01.jpg',
                'background'   => 'green-02.jpg',
                'layout'       => 'vertical',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card green horizontal',
                'front'        => 'green-03.jpg',
                'background'   => 'green-04.jpg',
                'layout'       => 'horizontal',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card orange vertical',
                'front'        => 'orange-01.jpg',
                'background'   => 'orange-02.jpg',
                'layout'       => 'vertical',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card orange horizontal',
                'front'        => 'orange-03.jpg',
                'background'   => 'orange-04.jpg',
                'layout'       => 'horizontal',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card indigo vertical',
                'front'        => 'indigo-01.jpg',
                'background'   => 'indigo-02.jpg',
                'layout'       => 'vertical',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card indigo horizontal',
                'front'        => 'indigo-03.jpg',
                'background'   => 'indigo-04.jpg',
                'layout'       => 'horizontal',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card gray-dark vertical',
                'front'        => 'gray-dark-01.jpg',
                'background'   => 'gray-dark-02.jpg',
                'layout'       => 'vertical',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card gray-dark horizontal',
                'front'        => 'gray-dark-03.jpg',
                'background'   => 'gray-dark-04.jpg',
                'layout'       => 'horizontal',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card pink vertical',
                'front'        => 'pink-01.jpg',
                'background'   => 'pink-02.jpg',
                'layout'       => 'vertical',
                'status'       => 0,
            ],
            [
                'institute_id' => 1,
                'type'         => 'student',
                'name'         => 'Rpitssr Students card pink horizontal',
                'front'        => 'pink-03.jpg',
                'background'   => 'pink-04.jpg',
                'layout'       => 'horizontal',
                'status'       => 0,
            ],

        ]);
    }
}
