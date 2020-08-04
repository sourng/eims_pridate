<?php

use App\Models\Holidays;
use Illuminate\Database\Seeder;

class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Holidays::insert([
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 1,
                'date'        => 1,
                'description' => 'International New Year\'s Day',
                'en'          => 'International New Year\'s Day',
                'km'          => 'ទិវាចូលឆ្នាំសកល​',
                'name'        => 'ទិវាចូលឆ្នាំសកល​',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 1,
                'date'        => 7,
                'description' => 'Victory over Genocide Day',
                'en'          => 'Victory over Genocide Day',
                'km'          => 'ទិវាជ័យជម្នះលើរបបប្រល័យពូជសាសន៍',
                'name'        => 'ទិវាជ័យជម្នះលើរបបប្រល័យពូជសាសន៍',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 2,
                'date'        => 19,
                'description' => 'Meak Bochea Day',
                'en'          => 'Meak Bochea Day',
                'km'          => 'ពិធីបុណ្យមាឃបូជា',
                'name'        => 'ពិធីបុណ្យមាឃបូជា',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 3,
                'date'        => 8,
                'description' => 'International Women\'s Day',
                'en'          => 'International Women\'s Day',
                'km'          => 'ទិវានារីអន្តរជាតិ​',
                'name'        => 'ទិវានារីអន្តរជាតិ​',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 4,
                'date'        => 13,
                'description' => 'Khmer New Year Day',
                'en'          => 'Khmer New Year Day',
                'km'          => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ​​',
                'name'        => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ​​',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 4,
                'date'        => 14,
                'description' => 'Khmer New Year Day ',
                'en'          => 'Khmer New Year Day',
                'km'          => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ',
                'name'        => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 4,
                'date'        => 15,
                'description' => 'Khmer New Year Day ',
                'en'          => 'Khmer New Year Day',
                'km'          => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ',
                'name'        => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 4,
                'date'        => 16,
                'description' => 'Khmer New Year Day ',
                'en'          => 'Khmer New Year Day',
                'km'          => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ',
                'name'        => 'ពិធីបុណ្យចូលឆ្នាំថ្មី ប្រពៃណីជាតិ',
            ],


            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 5,
                'date'        => 1,
                'description' => 'International Labor Day',
                'en'          => 'International Labor Day',
                'km'          => 'ទិវាពលកម្មអន្តរជាតិ',
                'name'        => 'ទិវាពលកម្មអន្តរជាតិ',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 5,
                'date'        => 6,
                'description' => 'International Labor Day',
                'en'          => 'International Labor Day',
                'km'          => 'ពិធីបុណ្យវិសាខបូជា',
                'name'        => 'ពិធីបុណ្យវិសាខបូជា',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 5,
                'date'        => 10,
                'description' => 'Royal Ploughing Ceremony',
                'en'          => 'Royal Ploughing Ceremony',
                'km'          => 'ព្រះរាជពិធីច្រត់ព្រះនង្គ័ល',
                'name'        => 'ព្រះរាជពិធីច្រត់ព្រះនង្គ័ល',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 5,
                'date'        => 14,
                'description' => 'Birthday of His Majesty King Norodom Sihamoni',
                'en'          => 'Birthday of His Majesty King Norodom Sihamoni',
                'km'          => 'ព្រះរាជពិធីបុណ្យចម្រើនព្រះជន្ម ព្រះករុណា ព្រះបាទសម្តេច​​ព្រះបរមនាថ នរោត្តម សីហមុនី',
                'name'        => 'ព្រះរាជពិធីបុណ្យចម្រើនព្រះជន្ម ព្រះករុណា ព្រះបាទសម្តេច​​ព្រះបរមនាថ នរោត្តម សីហមុនី',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 6,
                'date'        => 18,
                'description' => 'Birthday of Her Majesty the Queen-Mother Norodom Monineath Sihanouk',
                'en'          => 'Birthday of Her Majesty the Queen-Mother Norodom Monineath Sihanouk',
                'km'          => 'ព្រះរាជពិធីបុណ្យចម្រើនព្រះជន្ម ​សម្តេចព្រះមហាក្សត្រី ព្រះវររាជមាតា នរោត្តម មុនិនាថ សីហនុ',
                'name'        => 'ព្រះរាជពិធីបុណ្យចម្រើនព្រះជន្ម ​សម្តេចព្រះមហាក្សត្រី ព្រះវររាជមាតា នរោត្តម មុនិនាថ សីហនុ',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 9,
                'date'        => 16,
                'description' => 'Pchum Ben Day',
                'en'          => 'Pchum Ben Day',
                'km'          => 'ពិធីបុណ្យភ្ជុំបិណ្ឌ​​​',
                'name'        => 'ពិធីបុណ្យភ្ជុំបិណ្ឌ​​​',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 9,
                'date'        => 17,
                'description' => 'Pchum Ben Day',
                'en'          => 'Pchum Ben Day',
                'km'          => 'ពិធីបុណ្យភ្ជុំបិណ្ឌ​​​',
                'name'        => 'ពិធីបុណ្យភ្ជុំបិណ្ឌ​​​',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 9,
                'date'        => 18,
                'description' => 'Pchum Ben Day',
                'en'          => 'Pchum Ben Day',
                'km'          => 'ពិធីបុណ្យភ្ជុំបិណ្ឌ​​​',
                'name'        => 'ពិធីបុណ្យភ្ជុំបិណ្ឌ​​​',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 9,
                'date'        => 24,
                'description' => 'Constitutional Day',
                'en'          => 'Constitutional Day',
                'km'          => 'ទិវាប្រកាសរដ្ឋធម្មនុញ្ញ',
                'name'        => 'ទិវាប្រកាសរដ្ឋធម្មនុញ្ញ',
            ],


            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 10,
                'date'        => 15,
                'description' => 'Commemoration Day of Late King Norodom Sihanouk',
                'en'          => 'Commemoration Day of Late King Norodom Sihanouk',
                'km'          => 'ទិវាប្រារព្ធពិធីគោរពព្រះវិញ្ញាណក្ខន្ធ ព្រះករុណា ព្រះបាទសម្តេចព្រះនរោត្តម សីហនុ​​ ព្រះមហាវីរក្សត្រ \'ព្រះបរមរតនកោដ្ឋ\'',
                'name'        => 'ទិវាប្រារព្ធពិធីគោរពព្រះវិញ្ញាណក្ខន្ធ ព្រះករុណា ព្រះបាទសម្តេចព្រះនរោត្តម សីហនុ​​ ព្រះមហាវីរក្សត្រ \'ព្រះបរមរតនកោដ្ឋ\'',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 10,
                'date'        => 29,
                'description' => 'Coronation Day of His Majesty King Norodom Sihamoni',
                'en'          => 'Coronation Day of His Majesty King Norodom Sihamoni',
                'km'          => 'ព្រះរាជពិធីគ្រងព្រះបរមរាជសម្បតិ្ត​របស់ ព្រះករុណា ព្រះបាទសម្តេច ព្រះបរមនាថ នរោត្តម សីហមុនី',
                'name'        => 'ព្រះរាជពិធីគ្រងព្រះបរមរាជសម្បតិ្ត​របស់ ព្រះករុណា ព្រះបាទសម្តេច ព្រះបរមនាថ នរោត្តម សីហមុនី',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 10,
                'date'        => 30,
                'description' => 'Water Festival',
                'en'          => 'Water Festival',
                'km'          => 'ព្រះរាជពិធីបុណ្យអុំទូក បណ្តែតប្រទីប និងសំពះព្រះខែ អកអំបុក​',
                'name'        => 'ព្រះរាជពិធីបុណ្យអុំទូក បណ្តែតប្រទីប និងសំពះព្រះខែ អកអំបុក​',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 10,
                'date'        => 31,
                'description' => 'Water Festival',
                'en'          => 'Water Festival',
                'km'          => 'ព្រះរាជពិធីបុណ្យអុំទូក បណ្តែតប្រទីប និងសំពះព្រះខែ អកអំបុក​',
                'name'        => 'ព្រះរាជពិធីបុណ្យអុំទូក បណ្តែតប្រទីប និងសំពះព្រះខែ អកអំបុក​',
            ],
            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 11,
                'date'        => 1,
                'description' => 'Water Festival',
                'en'          => 'Water Festival',
                'km'          => 'ព្រះរាជពិធីបុណ្យអុំទូក បណ្តែតប្រទីប និងសំពះព្រះខែ អកអំបុក​',
                'name'        => 'ព្រះរាជពិធីបុណ្យអុំទូក បណ្តែតប្រទីប និងសំពះព្រះខែ អកអំបុក​',
            ],

            [
                'institute_id'  => 1,
                'year'        => 2020,
                'month'       => 11,
                'date'        => 9,
                'description' => 'Independence Day',
                'en'          => 'Independence Day',
                'km'          => 'ពិធីបុណ្យឯករាជ្យជាតិ​',
                'name'        => 'ពិធីបុណ្យឯករាជ្យជាតិ​',
            ],
        ]);
    }
}
