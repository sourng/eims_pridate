<?php

namespace App\Http\Controllers\Photo;

use App\Models\App;
use App\Models\Users;
use App\Models\Students;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = 'make', $param2 = null, $param3 = null)
    {
        $data['formData'] = array(
            'photo' => asset('/assets/img/user/male.jpg'),
        );
        $data['formName']     = Students::$path['url'] .'/'.StudentsStudyCourse::$path['url'];
        $data['formAction']   = '/photo';
        $data['listData']     = array();
        $data['metaImage']       = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']        = url(Users::role() . '/' . $param1);
        if ($param1 == null || $param1 == 'make') {
            $data = $this->make($data, $param3);
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
            'parent'     => 'Photo',
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view('Photo.index', $data);
    }

    public function make($data, $user)
    {
        $data['view']       = 'Photo.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .make.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/edit/' . $user['data'][0]['id']);
        $data['formData']   = $user['data'][0];
        $data['listData']   = $user['pages']['listData'];
        $data['formAction'] = '/photo/make/' . $user['data'][0]['id'];
        return $data;
    }
}
