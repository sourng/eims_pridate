<?php

use App\Models\ActivityFeed;
use App\Models\ActivityFeedMedia;
use Illuminate\Database\Seeder;

class ActivityFeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActivityFeed::insert([
            [
                'id'            => 1,
                'user_id'       => 1,
                'type'          => 'media',
                'post_message'  => '#កម្មវិធីការពារសារណាបញ្ចប់ការសិក្សា ថ្នាក់បរិញ្ញាបត្របច្ចេកវិទ្យា ជំនាញអគ្គិសនី និងអេឡិចត្រូនិក ជំនាន់ទី១ នៅវិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែនសៀមរាប៕',
            ]

        ]);

        ActivityFeedMedia::insert([
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83340330_2521132328215027_2024032213305131008_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '84123521_2521133004881626_2332212605172580352_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83360591_2521132514881675_4752892190793924608_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83735423_2521132798214980_388694566057803776_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '84646656_2521133291548264_4418986267673362432_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '84486003_2521133428214917_6607638190817804288_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83907808_2521133531548240_5295513561492094976_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83497654_2521133614881565_695141135462432768_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83067583_2521133874881539_5278542045466591232_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '84476631_2521134034881523_570920124232499200_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83445757_2521134184881508_1556144411723694080_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '82960586_2521134311548162_3065607360778076160_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '84350290_2521134504881476_1057884207742713856_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '84189349_2521134614881465_7323878460496019456_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '84327256_2521135211548072_8643146543852945408_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83085466_2521135351548058_4996221690343063552_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83242389_2521135471548046_4059723682270937088_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83328721_2521135584881368_6543034740155351040_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83230163_2521135698214690_5160286194054987776_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83439381_2521135878214672_7576663626900045824_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83228905_2521136038214656_6772558226245287936_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83251684_2521136164881310_3910087292261236736_o.jpg',
            ],
            [
                'activity_feed_id'  => 1,
                'type'              => 'image',
                'source'            => '83335306_2521136278214632_5204457355713970176_o.jpg',
            ],
        ]);
    }
}
