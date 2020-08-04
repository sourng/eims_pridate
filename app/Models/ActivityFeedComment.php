<?php

namespace App\Models;

use App\Events\NewsFeed;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Helpers\MentionHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ActivityFeedComment extends Model
{

    public static function getData($activity_feed_id, $id = null, $paginate = null)
    {
        $pages = [];
        $get = ActivityFeedComment::orderBy('id', 'ASC')->orderBy('created_at', 'DESC');
        if ($activity_feed_id) {
            $get = $get->where('activity_feed_id', $activity_feed_id);
        }
        if ($id) {
            $get = $get->where('id', $id);
        }

        if ($paginate) {
            $get = $get->paginate($paginate)->toArray();
            foreach ($get as $key => $value) {
                if ($key == 'data') {
                } else {
                    $pages[$key] = $value;
                }
            }
            $get = $get['data'];
        } else {
            $get = $get->get()->toArray();
        }

        if ($get) {
            foreach ($get as $key => $row) {
                $data[$key]         = array(
                    'feed_id'       => $row['activity_feed_id'],
                    'id'            => $row['id'],
                    'user'          => Users::getData($row['user_id'])['data'][0],
                    'type'          => $row['type'],
                    'comment'       => $row['comment'],
                    'mention'       => MentionHelper::mention($row['comment']),
                    'created_at'    => $row['created_at'],
                    'updated_at'    => $row['updated_at'],
                    'replied'       => ActivityFeedCommentsReply::getData($row['id'])['data'],
                );
            }

            $response       = array(
                'success'   => true,
                'data'      => $data,
                'pages'     => $pages
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

    public static function addToTable()
    {
        $activity_feed_id = request('feed_id');
        if ($activity_feed_id && request('comment')) {
            $add = ActivityFeedComment::insertGetId([
                'activity_feed_id'  => $activity_feed_id,
                'user_id'           => Auth::user()->id,
                'comment'           => trim(request('comment')),
                'type'              => request('type')  ? trim(request('type')) : 'text',
            ]);
            if ($add) {
                $comment = ActivityFeedComment::getData($activity_feed_id, $add);
                ActivityFeedNotifacation::addToTable('comment', $add);
                event(new NewsFeed($comment, 'comment-event'));
                return [
                    'success'   => true,
                    'data'      => $comment['data'],
                    'message'   => Translator::phrase('comment.successfully'),
                ];
            }
        }
    }
}
