<?php

namespace App\Helpers;

use App\Models\ActivityFeed;
use App\Models\Users;

class MentionHelper
{
    public static function mention($text)
    {

        $pattern = '/@\[([0-9]+)\]/i';
        preg_match_all($pattern, $text, $matches);
        if ($matches) {
            $data = [];
            foreach (array_unique($matches[1]) as $key => $value) {
                $user = Users::where('id', $value)->first()->toArray();

                $data[$value] = [
                    'id'        => $user['id'],
                    'name'      => $user['name'],
                    'profile'   => ImageHelper::site(Users::$path['image'], $user['profile']),
                    'link'      => url(ActivityFeed::$path['url'].'/profile?id='.$user['id']),
                    'bio'       => $user['address'],
                    'website'   => '',
                    'email' => $user['email'],
                ];
            }
            return $data;
        }
    }
}
