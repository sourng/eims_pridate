<?php

namespace App\Models;

use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Helpers\VideoHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ActivityFeedMedia extends Model
{
    public static function getData($activity_feed_id, $id = null)
    {

        $get = ActivityFeedMedia::orderBy('id', 'ASC');
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
                    'feed_id'       => $row['activity_feed_id'],
                    'id'            => $row['id'],
                    'type'          => $row['type'],
                    'source'        => $row['source'],
                    'title'         => $row['title'],
                    'original_name' => $row['original_name'],
                    'poster'        => $row['poster'],
                );

                if ($row['type'] == 'image') {
                    $data[$key]['source'] = ImageHelper::site(ActivityFeed::$path['image'], $row['source']);
                } elseif ($row['type'] == 'video') {
                    $data[$key]['source'] =  VideoHelper::site(ActivityFeed::$path['video'], $row['source']);
                    // $data[$key]['source'] =  Storage::disk('local')->get(VideoHelper::$path['video'].'/'.ActivityFeed::$path['video'].'/'. $row['source']);

                }
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
            if (request('media_files')) {
                foreach (request('media_files') as $media) {
                    if ($media) {
                        $media =  json_decode($media);
                        $add = ActivityFeedMedia::insertGetId([
                            'activity_feed_id' => $activity_feed_id,
                            'type'             => $media->type,
                            'source'           => $media->rename,
                            'original_name'    => $media->name,
                            'poster'           => $media->poster,
                        ]);

                        if ($add) {
                            $response = [
                                'success'   => true,
                                'message'   => Translator::phrase('upload.successfully'),
                            ];
                        }
                    }
                }
            }
        } else {
            if (request()->hasFile('media')) {
                $data = [];
                foreach (request()->file('media') as $media) {

                    if (preg_match("/image\/*/", strtolower($media->getMimeType()))) {
                        $upload = ImageHelper::uploadImage($media, ActivityFeed::$path['image']);
                        $type   = 'image';
                        $source = ImageHelper::site(ActivityFeed::$path['image'], $upload);
                    } elseif (preg_match("/video\/*/", strtolower($media->getMimeType()))) {
                        $upload = VideoHelper::uploadVideo($media, ActivityFeed::$path['video']);
                        $type   = 'video';
                        $source = VideoHelper::site(ActivityFeed::$path['video'], $upload);
                    }

                    if ($upload) {
                        $data[] = [
                            'name'         => $media->getClientOriginalName(),
                            'extension'    => $media->getClientOriginalExtension(),
                            'rename'       => $upload,
                            'poster'       => null,
                            'type'         => $type,
                            'source'       => $source
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
