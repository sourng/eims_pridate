<?php

use App\Models\FeatureSlider;
use Illuminate\Database\Seeder;

class FeatureSliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeatureSlider::insert([
            [
                'institute_id' => '1',
                'title'        => 'បុគ្គលិក & គ្រូបង្រៀន',
                'description'  => '',
                'image'        => '54181541_481532071103519_1101713416216254132_n.jpg'
            ],
            [
                'institute_id' => '1',
                'title'        => 'វិទ្យាសាស្ត្រកុំព្យូទ័រ',
                'description'  => '',
                'image'        => '27720116_111483131821611_4518591155221611671_n.jpg'
            ],
            [
                'institute_id' => '1',
                'title'        => 'អគ្គិសនី',
                'description'  => '',
                'image'        => '03501476_751111133978861_9102412169151741216_n.jpg'
            ],
            [
                'institute_id' => '1',
                'title'        => 'អេឡិចត្រូនិច',
                'description'  => '',
                'image'        => '21111622_205971999191514_1421081160012191313_n.jpg'
            ],
            [
                'institute_id' => '1',
                'title'        => 'វិស្វកម្មសំណង់',
                'description'  => '',
                'image'        => '53013514_291119116501404_4112028292819116161_n.jpg'
            ],
        ]);
    }
}
