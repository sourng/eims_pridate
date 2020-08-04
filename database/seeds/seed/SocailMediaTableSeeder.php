<?php

use App\Models\SocailsMedia;
use Illuminate\Database\Seeder;

class SocailMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocailsMedia::insert([
            [
                'app_id' => 1,
                'name'       => 'facebook',
                'link'       => 'https://www.facebook.com',
                'icon'       => 'fab fa-facebook-square',
            ],
            [
                'app_id' => 1,
                'name'       => 'linkedin',
                'link'       => 'https://www.linkedin.com',
                'icon'       => 'fab fa-linkedin',
            ],
            [
                'app_id' => 1,
                'name'       => 'google-plus',
                'link'       => 'https://www.google-plus.com',
                'icon'       => 'fab fa-google-plus-square',
            ],
            [
                'app_id' => 1,
                'name'       => 'whatsapp',
                'link'       => 'https://www.whatsapp.com',
                'icon'       => 'fab fa-whatsapp-square',
            ],
            [
                'app_id' => 1,
                'name'       => 'pinterest',
                'link'       => 'https://www.pinterest.com',
                'icon'       => 'fab fa-pinterest',
            ],
            [
                'app_id' => 1,
                'name'       => 'twitter',
                'link'       => 'https://www.twitter.com',
                'icon'       => 'fab fa-twitter',
            ],
            [
                'app_id' => 1,
                'name'       => 'youtube',
                'link'       => 'https://www.youtube.com',
                'icon'       => 'fab fa-youtube',
            ],
            [
                'app_id' => 1,
                'name'       => 'instagram',
                'link'       => 'https://www.instagram.com',
                'icon'       => 'fab fa-instagram',
            ],
            [
                'app_id' => 1,
                'name'       => 'skype',
                'link'       => 'https://www.skype.com',
                'icon'       => 'fab fa-skype',
            ],
            [
                'app_id' => 1,
                'name'       => 'wordpress',
                'link'       => 'https://www.wordpress.com',
                'icon'       => 'fab fa-wordpress',
            ],
            [
                'app_id' => 1,
                'name'       => 'tripadvisor',
                'link'       => 'https://www.tripadvisor.com',
                'icon'       => 'fab fa-tripadvisor',
            ],
            [
                'app_id' => 1,
                'name'       => 'rss',
                'link'       => 'https://www.rss.com',
                'icon'       => 'fa fa-rss',
            ],
            // [
            //     'app_id' => 1,
            //     'name'       => 'like-cambodia',
            //     'link'       => 'https://www.like-cambodia.com',
            //     'icon'       => 'fab fa-like-cambodia',
            // ],
            // [
            //     'app_id' => 1,
            //     'name'       => 'github',
            //     'link'       => 'https://www.github.com',
            //     'icon'       => 'fab fa-github',
            // ],
        ]);
    }
}
