<?php

namespace App\Models;

use Embed\Embed;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;

class ActivityFeedLink extends Model
{

    public static function getData($activity_feed_id, $id = null)
    {

        $get = ActivityFeedLink::orderBy('id', 'ASC');
        if ($activity_feed_id) {
            $get = $get->where('activity_feed_id', $activity_feed_id);
        }

        if ($id) {
            $get = $get->where('id', $id);
        }

        $get = $get->get()->toArray();
        if ($get) {
            foreach ($get as $key => $row) {
                $data[$key]         = array(
                    'id'            => $row['id'],
                    'view'          => $row['view'],
                    'type'          => $row['type'],
                    'title'         => $row['title'],
                    'link'          => $row['link'],
                    'description'   => $row['description'],
                    'image'         => $row['image'],
                    'code'          => $row['code'],
                );
            }

            $response       = array(
                'success'   => true,
                'data'      => $data,
            );
        } else {
            $response = array(
                'success'   => false,
                'data'      => [],
                'message'   => Translator::phrase('no_data'),
            );
        }

        return $response;
    }

    public static function addToTable($activity_feed_id)
    {
        $linkEmbed  = Embed::create(request('link'));
        if ($activity_feed_id && $linkEmbed) {
            if (request('link')) {
                $values = [
                    'activity_feed_id' => $activity_feed_id,
                    'link'             => trim(request('link')),
                    'view'             => trim(request('link_view')),
                    'type'             => $linkEmbed->getType(),
                    'title'            => $linkEmbed->getTitle(),
                    'image'            => $linkEmbed->getImage() ? $linkEmbed->getImage() : $linkEmbed->getProviderIcon(),
                    'description'      => $linkEmbed->getDescription(),
                    'code'             => $linkEmbed->getCode(),
                ];
                $add = ActivityFeedLink::insertGetId($values);

                if ($add) {
                    return [
                        'success'   => true,
                        'message'   => Translator::phrase('post.successfully'),
                    ];
                }
            }
        }
    }
}
