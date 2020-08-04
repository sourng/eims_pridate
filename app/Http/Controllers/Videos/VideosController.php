<?php

namespace App\Http\Controllers\Videos;

use App\Helpers\ImageHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Models\ActivityFeed;

class VideosController extends Controller
{

    protected $response;
    public function __construct()
    {
        $this->response = response()->json(
            array(
                'success' => false,
                'message'  => 'Bad URL timestamp'
            )
        );
    }

    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        ini_set('memory_limit', '128G');
        $_SERVER['HTTP_PRAGMA'] = 'no-cache';
        if (request()->header('sec-fetch-dest') == 'document') {
            if (request()->header('sec-fetch-site') == 'none' || request()->header('sec-fetch-site') == 'cross-site') {
                $data['response']  = VideoHelper::site($param1, $param2);
                return view('video.index', $data);

                if (request()->server('HTTP_PRAGMA')) {

                } else {
                    return $this->response;
                }
            }
        } elseif (request()->header('sec-fetch-dest') == 'video') {
            if (request()->header('sec-fetch-site') == 'same-origin') {
                if (strtolower($param1) == ActivityFeed::$path['video']) {
                    $this->response = VideoHelper::getVideo($param2, $param1, null, request('type'), request('w'), request('h'), request('q'));
                } else {
                    $this->response = ImageHelper::getImage($param2, $param1, null, request('type'), request('w'), request('h'), request('q'));
                }
                return $this->response;
            }
        } elseif (request()->header('sec-fetch-site') == 'same-origin' && request()->header('sec-fetch-dest') == 'video') {
        } else {
            return $this->response;
        }
    }
}
