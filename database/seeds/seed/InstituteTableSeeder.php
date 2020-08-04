<?php

use App\Models\Institute;
use Illuminate\Database\Seeder;

class InstituteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Institute::insert([
            [
                'name'       => 'Regional Polytechnic Institute Techo Sen Siem Reap',
                'en'         => 'Regional Polytechnic Institute Techo Sen Siem Reap',
                'km'         => 'វិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែនសៀមរាប',
                'short_name' => 'R.P.I.T.S.S.R',
                'website'    => 'http://www.rpitssr.edu.kh',
                'phone'      => null,
                'address'    => 'បន្ទាយចាស់, ស្លក្រាម, ក្រុងសៀមរាប, សៀមរាប',
                'location'   => 'បន្ទាយចាស់, ស្លក្រាម, ក្រុងសៀមរាប, សៀមរាប',
                'logo'       => '13128122_144017123552111_0316171712511511131_n.png',
            ],
            [
                'name'       => 'Regional Polytechnic Institute TechoSen Svay Rieng',
                'en'         => 'Regional Polytechnic Institute TechoSen Svay Rieng',
                'km'         => 'វិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែនស្វាយរៀង',
                'short_name' => 'R.P.I.S.V.R',
                'website'    => 'http://www.rpisvr.edu.kh',
                'phone'      => null,
                'address'    => 'ស្វាយរៀង',
                'location'   => 'ស្វាយរៀង',
                'logo'       => '10411287_283541015159943_7295066710070516799_n.png',
            ],
            [
                'name'       => 'Regional Polytechnic Institute TechoSen Takeo',
                'en'         => 'Regional Polytechnic Institute TechoSen Takeo',
                'km'         => 'វិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែនតាកែវ',
                'short_name' => 'R.P.I.S.T.K',
                'website'    => 'http://www.rpitk.edu.kh',
                'phone'      => null,
                'address'    => 'តាកែវ',
                'location'   => 'តាកែវ',
                'logo'       => '10636241_358302361005068_2131385123936676711_n.png',
            ],
            [
                'name'       => 'Regional Polytechnic Institute TechoSen Kampot',
                'en'         => 'Regional Polytechnic Institute TechoSen Kampot',
                'km'         => 'វិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែនកំពត',
                'short_name' => 'R.P.I.S.K.P',
                'website'    => 'http://www.rpikp.edu.kh',
                'phone'      => null,
                'address'    => 'កំពត',
                'location'   => 'កំពត',
                'logo'       => '26804897_1466500576799877_4461500451081780365_n.png',
            ],
            [
                'name'       => 'Regional Polytechnic Institute TechoSen Battambang',
                'en'         => 'Regional Polytechnic Institute TechoSen Battambang',
                'km'         => 'វិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែនបាត់ដំបង',
                'short_name' => 'R.P.I.T.S.B',
                'website'    => 'http://www.rpitsb.edu.kh',
                'phone'      => null,
                'address'    => 'បាត់ដំបង',
                'location'   => 'បាត់ដំបង',
                'logo'       => '53220385_630531597361097_6343929762938880000_n.png',
            ],


        ]);
    }
}
