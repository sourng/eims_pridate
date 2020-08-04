<?php

use App\Models\ThemesColor;
use Illuminate\Database\Seeder;

class ThemesColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThemesColor::insert([
            [
                'name'  => 'blue',
                'en'    => 'blue',
                'km'    => 'ខៀវ',
                'color' => '#5e72e4',
            ],
            [
                'name'  => 'indigo',
                'en'    => 'indigo',
                'km'    => 'indigo',
                'color' => '#5603ad',
            ],
            [
                'name'  => 'purple',
                'en'    => 'purple',
                'km'    => 'ពណ៌ស្វាយ',
                'color' => '#8965e0',
            ],
            [
                'name'  => 'pink',
                'en'    => 'pink',
                'km'    => 'ពណ៌ផ្កាឈូក',
                'color' => '#f3a4b5',
            ],
            [
                'name'  => 'red',
                'en'    => 'red',
                'km'    => 'ក្រហម',
                'color' => '#f5365c',
            ],
            [
                'name'  => 'orange',
                'en'    => 'orange',
                'km'    => 'ពណ៌ទឹកក្រូច',
                'color' => '#fb6340',
            ],
            [
                'name'  => 'yellow',
                'en'    => 'yellow',
                'km'    => 'លឿង',
                'color' => '#ffd600',
            ],
            [
                'name'  => 'green',
                'en'    => 'green',
                'km'    => 'បៃតង',
                'color' => '#2dce89',
            ],
            [
                'name'  => 'teal',
                'en'    => 'teal',
                'km'    => 'ទឹកភ្នែក',
                'color' => '#11cdef',
            ],
            [
                'name'  => 'cyan',
                'en'    => 'cyan',
                'km'    => 'ផ្ទៃមេឃ',
                'color' => '#2bffc6',
            ],
            [
                'name'  => 'gray',
                'en'    => 'gray',
                'km'    => 'ប្រផេះ',
                'color' => '#8898aa',
            ],
            [
                'name'  => 'gray-dark',
                'en'    => 'gray-dark',
                'km'    => 'ពណ៌ប្រផេះ - ងងឹត',
                'color' => '#32325d',
            ],
            [
                'name'  => 'light',
                'en'    => 'light',
                'km'    => 'ពន្លឺ',
                'color' => '#ced4da',
            ],
            [
                'name'  => 'primary',
                'en'    => 'primary',
                'km'    => 'បឋម',
                'color' => '#5e72e4',
            ],
            [
                'name'  => 'success',
                'en'    => 'success',
                'km'    => 'ជោគជ័យ',
                'color' => '#2dce89',
            ],
            [
                'name'  => 'info',
                'en'    => 'info',
                'km'    => 'ព័ត៌មាន',
                'color' => '#11cdef',
            ],
            [
                'name'  => 'warning',
                'en'    => 'warning',
                'km'    => 'ការព្រមាន',
                'color' => '#fb6340',
            ],
            [
                'name'  => 'danger',
                'en'    => 'danger',
                'km'    => 'គ្រោះថ្នាក់',
                'color' => '#f5365c',
            ],
            [
                'name'  => 'darker',
                'en'    => 'darker',
                'km'    => 'ងងឹត',
                'color' => '#212529',
            ],
        ]);
    }
}
