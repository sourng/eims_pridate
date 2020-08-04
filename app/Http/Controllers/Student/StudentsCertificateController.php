<?php

namespace App\Http\Controllers\Student;


use App\Models\App;
use App\Models\Users;
use App\Models\Students;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\CardFrames;
use App\Helpers\CardHelper;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Http\Requests\FormCard;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class StudentsCertificateController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = 'list', $param2 = null, $param3 = null)
    {
        $data['institutes']      = Institute::getData();
        $data['formData'] = array(
            'front' => asset('/assets/img/card/front.png'),
            'background' => asset('/assets/img/card/background.png'),
        );
        $data['formAction']      = '/add';
        $data['formName']        = CardFrames::$path['url'];
        $data['title']           = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']       = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']        = url(Users::role() . '/' . $param1);
        $data['listData']       = array();
        if ($param1 == 'list' || $param1 == null) {
            $data = $this->list($data);
        } elseif ($param1 == 'add') {
            $data = $this->add($data);
        } elseif ($param1 == 'view') {
            if ($param2) {
                $data = $this->view($data, $param2);
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'edit') {
            if ($param2) {
                $data = $this->edit($data, $param2);
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'delete') {
            return CardFrames::deleteFromTable($param2);
        } elseif ($param1 == 'make') {
            if (request()->method() == 'POST') {
                if (request()->all()) {
                    Session::put('card', json_decode(request()->post("card"), true));
                    if (request()->hasFile('front_card')) {
                        $file = request()->front_card;
                        $file_tmp  = $file->getPathName();
                        $file_type = $file->getMimeType();
                        $file_str  = file_get_contents($file_tmp);
                        $tob64img  = base64_encode($file_str);
                        $card_front = 'data:' . $file_type . ';base64,' . $tob64img;
                        Session::put('card_front',  $card_front);
                    }

                    if (request()->hasFile('back_card')) {
                        $file = request()->back_card;
                        $file_tmp  = $file->getPathName();
                        $file_type = $file->getMimeType();
                        $file_str  = file_get_contents($file_tmp);
                        $tob64img  = base64_encode($file_str);
                        $card_back = 'data:' . $file_type . ';base64,' . $tob64img;
                        Session::put('card_back',  $card_back);
                    }

                    return array(
                        'success' => true,
                        'redirect' => str_replace('make', 'result', request()->getUri())
                    );
                }
            }
            $data = $this->make($data, $param3);

        } elseif ($param1 == 'set') {
            return $this->set($param2);
        } elseif ($param1 == 'result') {
            $d['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .card.');
            MetaHelper::setConfig(
                [
                    'title'       => $d['title'],
                    'author'      => config('app.name'),
                    'keywords'    => null,
                    'description' => null,
                    'link'        => null,
                    'image'       => null
                ]
            );
            config()->set('app.title', $d['title']);
            $d['certificates'] = CardHelper::make($param3);
            return view('Card.includes.result.index', $d);
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
            'parent'     => CardFrames::$path['view'],
            'view'       => $data['view'],
        );

         $pages['form']['validate'] = [
            'rules'       =>  FormCard::rulesField(),
            'attributes'  =>  FormCard::attributeField(),
            'messages'    =>  FormCard::customMessages(),
            'questions'   =>  FormCard::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view('Card.index', $data);
    }

    public function list($data)
    {
        $data['view']     = CardFrames::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . $data['formName']);
        $data['response'] =  CardFrames::getData(null, null, 10);
        return $data;
    }

    public function add($data)
    {
        $data['view']  = CardFrames::$path['view'] . '.includes.form.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . $data['formName']);
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');

        return $data;
    }

    public function view($data, $id)
    {
        $response           = CardFrames::getData($id, true);
        $data['view']       = CardFrames::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .view.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/view/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/view/' . $response['data'][0]['id'];
        return $data;
    }

    public function edit($data, $id)
    {
        $response = CardFrames::getData($id, true);
        $data['view']       = CardFrames::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/edit/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/edit/' . $response['data'][0]['id'];
        return $data;
    }
    public function make($data, $user)
    {

        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .card.');
        $data['view']  = CardFrames::$path['view'] . '.includes.make.index';
        $data['certificates']['frame']  = CardFrames::getData(CardFrames::where('status', 1)->first()->id, 10)['data'][0];
        $data['response']        =  CardFrames::getData();
        $data['formName']   = Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . CardFrames::$path['url'];
        $data['formAction'] = '/make/' . request('id');

        $data['certificates']['all'] = CardFrames::frameData('all');
        $data['certificates']['selected'] = CardFrames::frameData('selected');
        if ($user['success']) {
            $data['certificates']['user'] = $user['data'][0];
        } else {
            $data['certificates']['user'] =  [];
        }

        return $data;
    }

    public function set($id)
    {
        return CardFrames::setToTable($id);
    }
}
