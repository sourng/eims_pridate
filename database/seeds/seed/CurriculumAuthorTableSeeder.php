<?php

use App\Models\CurriculumAuthor;
use Illuminate\Database\Seeder;

class CurriculumAuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurriculumAuthor::insert([
            [
                'name'  => 'Institution own curriculum',
                'en'    => 'Institution own curriculum',
                'km'    => 'គ្រឹះស្ថានបង្កើតកម្មវិធីសិក្សាដោយខ្លួនឯង',
            ],
            [
                'name'  => 'NTTI based on NCS',
                'en'    => 'NTTI based on NCS',
                'km'    => 'NTTI ស្របតាមស្តង់ដារជាតិសមត្ថភាព',
            ],

        ]);
    }
}
