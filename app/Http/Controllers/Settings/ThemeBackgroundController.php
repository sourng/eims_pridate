<?php

namespace App\Http\Controllers\Settings;

use App\Models\App;
use App\Models\Users;
use App\Models\Institute;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Models\ThemeBackground;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormThemeBackground;

class ThemeBackgroundController extends Controller
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
        $data['institute'] = Institute::getData();
        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName'] = App::$path['url'] . '/' . ThemeBackground::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return ThemeBackground::getData(null, null, 10);
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return ThemeBackground::getDataTable();
            } else {
                $data = $this->list($data, $param1);
            }
        } elseif ($param1 == 'gallery') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return ThemeBackground::getData(null, null, 10);
            } else {
                $data = $this->gallery($data);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return ThemeBackground::addToTable();
            }
            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->method() === 'POST') {
                return ThemeBackground::updateToTable($id);
            }
            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'set') {
            return ThemeBackground::setToTable($param2);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);

            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'set') {
            return $this->set($param2);
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
            return ThemeBackground::deleteFromTable($id);
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
            'parent'     => ThemeBackground::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormThemeBackground::rulesField(),
            'attributes'  =>  FormThemeBackground::attributeField(),
            'messages'    =>  FormThemeBackground::customMessages(),
            'questions'   =>  FormThemeBackground::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['response'] = ThemeBackground::getData(null, null, 10);
        $data['view']     = ThemeBackground::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.theme_background');
        return $data;
    }

    public function gallery($data)
    {
        $data['response'] = ThemeBackground::getData();
        $data['view']     = ThemeBackground::$path['view'] . '.includes.gallery.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.gallery');
        return $data;
    }

    public function add($data)
    {
        $data['view']      = ThemeBackground::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.theme_background');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/' . $data['formName'] . $data['formAction']);
        return $data;
    }

    public function show($data, $id, $type)
    {
        $response           = ThemeBackground::getData($id, true);
        $data['view']       = ThemeBackground::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.theme_background');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $id;
        $data['metaLink']  = url(Users::role() . '/' . $data['formName'] . $data['formAction']);
        return $data;
    }
}
