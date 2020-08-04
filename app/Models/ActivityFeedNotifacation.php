<?php

namespace App\Models;

use App\Events\NewsFeed;
use App\Helpers\Translator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class ActivityFeedNotifacation extends Model
{
    public static function getData($id = null, $type = null, $node_id = null)
    {
        $get = ActivityFeedNotifacation::orderBy('id', 'DESC');
        if ($id) {
            $get = $get->where('id', $id);
        }
        if ($type) {
            $get = $get->where('type', $type);
        }
        if ($node_id) {
            $get = $get->where('node_id', $node_id);
        }

        $get = $get->get()->toArray();
        if ($get) {
            $data = [];
            foreach ($get as $key => $row) {

                $activityFeed = null;
                $userId       = null;
                $slug         = null;
                $react        = null;

                if($row['type'] == 'post'){
                    $activityFeed  = ActivityFeed::find($row['node_id']);
                    $userId        = $activityFeed->user_id;
                    $slug          = $row['node_id'];
                }elseif($row['type'] == 'reaction'){
                    $node = ActivityFeedReaction::find($row['node_id']);
                    $userId = $node->user_id;
                    $activityFeed = ActivityFeed::find($node->activity_feed_id);
                    $react        = $node->type;
                    $slug         = $activityFeed->user_id;
                }elseif($row['type'] == 'comment'){
                    $node = ActivityFeedComment::find($row['node_id']);
                    $userId = $node->user_id;
                    $activityFeed  = ActivityFeed::find($node->activity_feed_id);
                    $slug          = $activityFeed->user_id;

                }elseif($row['type'] == 'replied'){
                    $node   = ActivityFeedCommentsReply::find($row['node_id']);
                    $userId = $node->user_id;
                    $comment = ActivityFeedComment::find($node->activity_feed_comment_id);
                    $activityFeed  = ActivityFeed::find($comment->activity_feed_id);
                    $slug          = $activityFeed->user_id;
                }elseif($row['type'] == 'share'){
                    $node = ActivityFeedShare::where("activity_feed_id",$row['node_id'])->first();
                    $activityFeed  = ActivityFeed::find($node->node_id);
                    $userId        = $activityFeed->user_id;
                    $slug          = $row['node_id'];
                }

                $data[] = [
                    'user'        => Users::getData($userId)['data'][0],
                    'react'       => $react,
                    'media'       => ActivityFeedMedia::getData($slug)['data'],
                    'url'         => url(ActivityFeed::$path['url'] . '/post/' . $activityFeed->id),
                ];

            }

            $response       = array(
                'success'   => true,
                'data'      => $data,
            );
        }else{
            $response       = array(
                'success'   => false,
                'data'      => [],
            );
        }

        return $response;
    }
    public static function addToTable($type, $node_id)
    {
        if($type && $node_id){
            $add = ActivityFeedNotifacation::insertGetId([
                'type'      =>$type,
                'node_id'   =>$node_id,
            ]);

            if($add){
                $notification = ActivityFeedNotifacation::getData($add);
                event(new NewsFeed($notification,'notification-event'));
                return $notification;
            }
        }
    }
}
