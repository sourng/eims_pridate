<?php

namespace App\Http\Controllers\ActivityFeed;

use Embed\Embed;
use App\Models\App;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Models\ThemesColor;
use App\Helpers\ImageHelper;
use App\Helpers\Translator;
use App\Models\ActivityFeed;
use App\Models\SocailsMedia;
use App\Models\ActivityFeedMedia;
use App\Models\ActivityFeedComment;
use App\Http\Controllers\Controller;
use App\Models\ActivityFeedReaction;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityFeedCommentsReply;
use App\Models\ActivityFeedShare;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;


class ActivityFeedController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }


    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        ini_set('post_max_size ', '6G');
        ini_set('upload_max_filesize', '4G');
        ini_set('max_file_uploads', '20');
        ini_set('max_execution_time', 30000);
        ini_set('max_input_time', 60000);
        ini_set('memory_limit', '8G');
        if (Auth::user()) {
            JavaScriptFacade::put([
                'User'  => [
                    'id'  => Auth::user()->id,
                    'name'  => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'profile'   => Auth::user()->profile(),
                ]
            ]);
        }

        $data['theme_color'] = ThemesColor::getData();
        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName'] = ActivityFeed::$path['url'];
        $data['formAction'] = '/post';
        $data['title'] = 'Feed';
        $data['listData']       = array();
        if ($param1 == null) {
            $data['response'] =  ActivityFeed::getData(null, true);
            $data['view']      = ActivityFeed::$path['view'] . '.includes.feed.index';
        } elseif (strtolower($param1) == 'post') {
            if (request()->method() == "POST") {
                return ActivityFeed::addToTable();
            } else {
                if ($param2) {
                    $id = $param2;
                } else {
                    $id = request('id');
                }
                if ($id) {
                    $data['response'] =  ActivityFeed::getData($id);
                    $data['view']      = ActivityFeed::$path['view'] . '.includes.view.post.index';
                } else {
                    abort(404);
                }
            }
        } elseif (strtolower($param1) == 'link') {
            if (request()->method() == "POST") {
                $linkEmbed  = Embed::create(request('link'));
                if ($linkEmbed) {
                    $response = [
                        'success' => true,
                        'data'    => [
                            'title'       => $linkEmbed->getTitle(),
                            'image'       => $linkEmbed->getImage() ? $linkEmbed->getImage() : $linkEmbed->getProviderIcon(),
                            'description' => $linkEmbed->getDescription(),
                            'url'         => $linkEmbed->getUrl(),
                            'type'        => $linkEmbed->getType(),
                            'code'        => $linkEmbed->getCode(),
                        ],
                    ];
                } else {
                    $response = [
                        'success' => false,
                        'data'    => null
                    ];
                }
                return $response;
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == 'upload') {
            if (request()->method() == "POST") {

                return ActivityFeedMedia::addToTable();
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == 'comment') {
            if (request()->method() == "POST") {
                return ActivityFeedComment::addToTable();
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == 'replied') {
            if (request()->method() == "POST") {
                return ActivityFeedCommentsReply::addToTable();
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == 'reaction') {
            if (request()->method() == "POST") {
                return ActivityFeedReaction::addToTable();
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == Users::$path['url']) {
            if (request()->method() == "GET") {
                $search = request('search');

                $get =  Users::orderBy('name', 'ASC');
                if ($search) {
                    $get = $get->where('name', 'LIKE', '%' . $search . '%');
                }
                $get = $get->get()->toArray();
                $data = [];
                if ($get) {
                    foreach ($get as $row) {
                        $data[] = [
                            'id'        => $row['id'],
                            'name'      => $row['name'],
                            'profile'   => $row['profile'] ? (ImageHelper::site(Users::$path['image'], $row['profile'])) : null,
                        ];
                    }

                    $response = [
                        'success'   => true,
                        'data'      => $data,
                    ];
                } else {
                    $response = [
                        'success'   => false,
                        'data'      => $data,
                        'message'   => Translator::phrase('no_data'),
                    ];
                }
                return $response;
            }
        } elseif (strtolower($param1) == 'share') {
            if (request()->method() == "POST") {
                return ActivityFeed::addShareToTable();
            }
        } else {
            abort(404);
        }

        MetaHelper::setConfig([
            'title'       => $data['title'],
            'author'      => config('app.name'),
            'keywords'    => '',
            'description' => '',
            'link'        => null,
            'image'       => null
        ]);
        $pages = array(
            'host'       => url('/'),
            'path'       => '/' . Users::role(),
            'pathview'   => '/' . $data['formName'] . '/',
            'parameters' => array(
                'param1' => $param1,
                'param2' => $param2,
                'param3' => $param3,
            ),
            'search'     => parse_url(request()->getUri(), PHP_URL_QUERY) ? '?' . parse_url(request()->getUri(), PHP_URL_QUERY) : '',
            'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction']),
            'parent'     => ActivityFeed::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  [],
            'attributes'  =>  [],
            'messages'    =>  [],
            'questions'   =>  [],
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }
}
