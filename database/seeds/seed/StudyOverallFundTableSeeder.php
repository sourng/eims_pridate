<?php

use App\Models\StudyOverallFund;
use Illuminate\Database\Seeder;

class StudyOverallFundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudyOverallFund::insert([
            [
                'name'  => 'National Training Fund',
                'en'    => 'National Training Fund',
                'km'    => 'មូល​និធិ​ជាតិ​បណ្ដុះ​បណ្ដាល (NTF)',
            ],

            [
                'name'  => 'Institution Supporting Fund',
                'en'    => 'Institution Supporting Fund',
                'km'    => 'ថវិកា​ទ្រទ្រង់​គ្រឹះស្ថាន',
            ],
            [
                'name'  => 'Special Fund',
                'en'    => 'Special Fund',
                'km'    => 'មូល​និធិ​ពិសេស​របស់​សម្តេច​តេជោ​នាយក​រដ្ឋមន្រ្តី (SF)',
            ],

            [
                'name'  => 'Voucher Skill Training Program',
                'en'    => 'Voucher Skill Training Program',
                'km'    => 'កម្មវិធី​បណ្ដុះ​បណ្ដាល​ជំនាញ​តាម​លិខិត​បញ្ជាក់ (VSTP)',
            ],
            [
                'name'  => 'Japenes Fund Poverty Reduce',
                'en'    => 'Japenes Fund Poverty Reduce',
                'km'    => 'គម្រោង​សាក​ល្បង​លើ​បច្ចេក​ទេស​ក្រោមមូលនិធិជប៉ុន',
            ],
            [
                'name'  => 'Tuition Fee',
                'en'    => 'Tuition Fee',
                'km'    => 'សិក្សា​បង់ថ្លៃ',
            ],
        ]);
    }
}
