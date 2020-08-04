<?php

use App\Models\Provinces;
use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provinces::insert([
            [
                'id'   => '1',
                'name' => 'Banteay Meanchey',
                'en'   => 'Banteay Meanchey',
                'km'   => 'បន្ទាយមានជ័យ',

            ],
            [
                'id'   => '2',
                'name' => 'Battambang',
                'en'   => 'Battambang',
                'km'   => 'បាត់ដំបង',

            ],
            [
                'id'   => '3',
                'name' => 'Kampong Cham',
                'en'   => 'Kampong Cham',
                'km'   => 'កំពង់ចាម',

            ],
            [
                'id'   => '4',
                'name' => 'Kampong Chhnang',
                'en'   => 'Kampong Chhnang',
                'km'   => 'កំពង់ឆ្នាំង',

            ],
            [
                'id'   => '5',
                'name' => 'Kampong Speu',
                'en'   => 'Kampong Speu',
                'km'   => 'កំពង់ស្ពឺ',

            ],
            [
                'id'   => '6',
                'name' => 'Kampong Thom',
                'en'   => 'Kampong Thom',
                'km'   => 'កំពង់ធំ',

            ],
            [
                'id'   => '7',
                'name' => 'Kampot',
                'en'   => 'Kampot',
                'km'   => 'កំពត',

            ],
            [
                'id'   => '8',
                'name' => 'Kandal',
                'en'   => 'Kandal',
                'km'   => 'កណ្តាល',

            ],
            [
                'id'   => '9',
                'name' => 'Koh Kong',
                'en'   => 'Koh Kong',
                'km'   => 'កោះកុង',

            ],
            [
                'id'   => '10',
                'name' => 'Kratie',
                'en'   => 'Kratie',
                'km'   => 'ខេត្តក្រចេះ',

            ],
            [
                'id'   => '11',
                'name' => 'Mondul Kiri',
                'en'   => 'Mondul Kiri',
                'km'   => 'មណ្ឌលគិរី',

            ],
            [
                'id'   => '12',
                'name' => 'Phnom Penh',
                'en'   => 'Phnom Penh',
                'km'   => 'រាជធានីភ្នំពេញ',

            ],
            [
                'id'   => '13',
                'name' => 'Preah Vihear',
                'en'   => 'Preah Vihear',
                'km'   => 'ព្រះវិហារ',

            ],
            [
                'id'   => '14',
                'name' => 'Prey Veng',
                'en'   => 'Prey Veng',
                'km'   => 'ព្រៃវែង',

            ],
            [
                'id'   => '15',
                'name' => 'Pursat',
                'en'   => 'Pursat',
                'km'   => 'ពោធិសាត់',

            ],
            [
                'id'   => '16',
                'name' => 'Ratanak Kiri',
                'en'   => 'Ratanak Kiri',
                'km'   => 'រតនគិរី',

            ],
            [
                'id'   => '17',
                'name' => 'Siemreap',
                'en'   => 'Siemreap',
                'km'   => 'សៀមរាប',

            ],
            [
                'id'   => '18',
                'name' => 'Preah Sihanouk',
                'en'   => 'Preah Sihanouk',
                'km'   => 'ព្រះសីហនុ',

            ],
            [
                'id'   => '19',
                'name' => 'Stung Treng',
                'en'   => 'Stung Treng',
                'km'   => 'ស្ទឹងត្រែង',

            ],
            [
                'id'   => '20',
                'name' => 'Svay Rieng',
                'en'   => 'Svay Rieng',
                'km'   => 'ស្វាយយិង',

            ],
            [
                'id'   => '21',
                'name' => 'Takeo',
                'en'   => 'Takeo',
                'km'   => 'តាកែវ',

            ],
            [
                'id'   => '22',
                'name' => 'Oddar Meanchey',
                'en'   => 'Oddar Meanchey',
                'km'   => 'ឧត្តរមានជ័យ',

            ],
            [
                'id'   => '23',
                'name' => 'Kep',
                'en'   => 'Kep',
                'km'   => 'កែប',

            ],
            [
                'id'   => '24',
                'name' => 'Pailin',
                'en'   => 'Pailin',
                'km'   => 'ប៉ៃលិន',

            ],
            [
                'id'   => '25',
                'name' => 'Tboung Khmum',
                'en'   => 'Tboung Khmum',
                'km'   => 'ត្បូងឃ្មុំ',

            ],
        ]);
    }
}
