<?php

use App\Models\Sponsored;
use Illuminate\Database\Seeder;

class SponsoredSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sponsored::insert([
            [
                'name'  => 'Khemara Angkor',
                'image' => 'Khemara-Angkor.png',
                'link'  => null,
            ],
            [
                'name'  => 'TEM',
                'image' => 'TEM.png',
                'link'  => null,
            ],
            [
                'name'  => 'Ggear',
                'image' => 'Ggear.png',
                'link'  => null,
            ],
            [
                'name'  => 'Tasaki',
                'image' => 'Tasaki.jpg',
                'link'  => null,
            ],
            [
                'name'  => 'NIB',
                'image' => 'NIB-edited.jpg',
                'link'  => null,
            ],
            [
                'name'  => 'Npic',
                'image' => 'Npic.png',
                'link'  => null,
            ],
            [
                'name'  => 'Angkor-University',
                'image' => 'Angkor-University.jpg',
                'link'  => null,
            ],
            [
                'name'  => 'Jica',
                'image' => 'Jica.png',
                'link'  => null,
            ],
            [
                'name'  => 'Caritas Cambodia',
                'image' => 'caritas-cambodia.png',
                'link'  => null,
            ],
            [
                'name'  => 'NTTI',
                'image' => 'NTTI.png',
                'link'  => null,
            ],
            [
                'name'  => 'Koica',
                'image' => 'Koica.png',
                'link'  => null,
            ],
            [
                'name'  => 'Ilo',
                'image' => 'Ilo.png',
                'link'  => null,
            ],
            [
                'name'  => 'ADB',
                'image' => 'ADB.png',
                'link'  => null,
            ],
            [
                'name'  => 'Plan',
                'image' => 'Plan.png',
                'link'  => null,
            ],
            [
                'name'  => 'European Union',
                'image' => 'European-Union.jpg',
                'link'  => null,
            ],
            [
                'name'  => 'CFC',
                'image' => 'CFC.png',
                'link'  => null,
            ],
            [
                'name'  => 'Swisscontact',
                'image' => 'swisscontact.jpg',
                'link'  => null,
            ],
            [
                'name'  => 'Angkor Era',
                'image' => 'Angkor-Era.png',
                'link'  => null,
            ],
        ]);
    }
}
