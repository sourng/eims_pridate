<?php

namespace App\Models;

use App\Helpers\Translator;
use App\Helpers\videoHelper;
use Illuminate\Database\Eloquent\Model;

class ActivityFeedVideo extends Model
{
    public static function getData($activity_feed_id, $id = null)
    {

        $get = ActivityFeedVideo::orderBy('id', 'ASC');
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
                    'title'         => $row['title'],
                    'original_name' => $row['original_name'],
                    'poster'        => $row['poster'],
                    'video'         => $row['video'] ? (VideoHelper::site(ActivityFeed::$path['video'], $row['video'])) : null,
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


    public static function addToTable($activity_feed_id = null)
    {
        $response = [
            'success'   => false,
            'message'   => Translator::phrase('upload.unsuccessful'),
        ];
        if ($activity_feed_id) {
            if (request('video_files')) {
                foreach (request('video_files') as $video) {
                    $add = ActivityFeedVideo::insertGetId([
                        'activity_feed_id' => $activity_feed_id,
                        'video'            => $video,
                    ]);

                    if ($add) {
                        $response = [
                            'success'   => true,
                            'message'   => Translator::phrase('upload.successfully'),
                        ];
                    }
                }
            }
        } else {
            if (request()->hasFile('video')) {
                $data = [];
                foreach (request()->file('video') as $video) {
                    $upload = VideoHelper::uploadvideo($video, ActivityFeed::$path['video']);
                    if ($upload) {
                        $data[] = [
                            'name'         => $video->getClientOriginalName(),
                            'rename'       => $upload,
                            'extension'    => $video->getClientOriginalExtension(),
                            'reExtension'  => null,
                            'url'          => VideoHelper::site(ActivityFeed::$path['video'], $upload)
                        ];
                    }
                }
                $response = [
                    'success'   => true,
                    'message'   => Translator::phrase('upload.successfully'),
                    'data'      => $data
                ];
            }
        }
        return $response;
    }
}
