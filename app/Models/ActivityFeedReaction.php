<?php

namespace App\Models;

use App\Events\NewsFeed;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityFeedReaction extends Model
{

    public static function getData($activity_feed_id, $id = null)
    {
        $get = ActivityFeedReaction::orderBy('id', 'DESC');
        if ($activity_feed_id) {
            $get = $get->where('activity_feed_id', $activity_feed_id);
        }
        if ($id) {
            //$get = $get->where('id', $id);
        } else {
            $get = $get->where('type', '<>', '');
        }
        $get = $get->get()->toArray();
        $reaction  = [];
        $other_react = '';
        $you_react = '';

        if ($get) {
            foreach ($get as $key => $row) {
                $reaction[] = $row['type'];
                $user = Users::getData($row['user_id'])['data'][0];
                if (Auth::user()) {
                    if ($row['user_id'] == Auth::user()->id) {
                        $you_react = $row['type'];
                    } else {
                        $other_react .= $user['name'] . ',';
                    }
                } else {
                    $other_react .= $user['name'] . ',';
                }
                if (count($get) == ($key + 1)) {
                    $data[] = [
                        'feed_id'     =>  $row['activity_feed_id'],
                        'you_react'   =>  $you_react,
                        'other_react_name' => rtrim($other_react ,','),
                        'reaction'    =>  array_unique($reaction),
                        'like'  => ActivityFeedReaction::where('id', $row['activity_feed_id'])->where('type','like')->count()
                    ];
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

    public static function addToTable()
    {
        $activity_feed_id = request('feed_id');
        if ($activity_feed_id) {
            $exists = ActivityFeedReaction::existsToTable();
            if ($exists) {
                return ActivityFeedReaction::updateToTable($exists->id, trim(request('type')));
            } else {
                $add = ActivityFeedReaction::insertGetId([
                    'activity_feed_id'  => $activity_feed_id,
                    'user_id'           => Auth::user()->id,
                    'type'              => trim(request('type')),
                ]);
                if ($add) {
                    $reaction = ActivityFeedReaction::getData($activity_feed_id);
                    ActivityFeedNotifacation::addToTable('reaction', $add);
                    event(new NewsFeed($reaction, 'reaction-event'));
                    return [
                        'success'   => true,
                        'data'      => $reaction['data'],
                        'message'   => Translator::phrase('reaction.successfully'),
                    ];
                }
            }
        }
    }
    public static function updateToTable($id, $type)
    {
        $update =  ActivityFeedReaction::where('id', $id)->update([
            'type'  => $type
        ]);
        if ($update) {

            $reaction = ActivityFeedReaction::getData(request('feed_id'), $id);
            ActivityFeedNotifacation::addToTable('reaction', $id);
            event(new NewsFeed($reaction, 'reaction-event'));
            return array(
                'success'   => true,
                'data'      => $reaction['data'],
                'message'   => Translator::phrase('update.successfully'),
            );
        }
    }
    public static function existsToTable()
    {
        return ActivityFeedReaction::where('activity_feed_id', request('feed_id'))->where('user_id', Auth::user()->id)->first();
    }
}
