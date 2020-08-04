<?php

use App\Models\CurriculumEndorsement;
use Illuminate\Database\Seeder;

class CurriculumEndorsementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurriculumEndorsement::insert([
            [
                'name'  => 'Institution using own curriculum',
                'en'    => 'Institution using own curriculum',
                'km'    => 'គ្រឹះស្ថានប្រើប្រាស់កម្មវិធីសិក្សាផ្ទាល់ខ្លួន',
            ],
            [
                'name'  => 'NTB (National Training Board)',
                'en'    => 'NTB (National Training Board)',
                'km'    => 'គណៈកម្មាធិការជាតិបណ្តុះបណ្តាល (NTB)',
            ],
            [
                'name'  => 'ACC (Accreditation Committee of Cambodia)',
                'en'    => 'ACC (Accreditation Committee of Cambodia)',
                'km'    => 'គណៈកម្មាធិការទទួលស្គាល់គុណភាពអប់រំនៃកម្ពុជា (ACC)',
            ],
        ]);
    }
}
