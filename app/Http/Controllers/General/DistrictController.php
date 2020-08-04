<?php

namespace App\Http\Controllers\General;

use App\Models\App;
use App\Models\Users;
use App\Models\Districts;
use App\Models\Languages;
use App\Models\Provinces;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;;
use App\Models\SocailsMedia;
use App\Http\Requests\FormDistrict;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
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
        $data['provinces']   = Provinces::getData();
        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );

        $data['formAction']      = '/add';
        $data['formName']        = 'general/'.Districts::$path['url'];
        $data['title']           = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']       = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']        = url(Users::role() . '/' . $param1);
        $data['listData']       = array();

        request()->merge([
            'id' => $param2 ? $param2 : request('id'),
        ]);


        if ($param1 == 'list' || $param1 == null) {
            if(strtolower(request()->server('CONTENT_TYPE')) == 'application/json'){
                return  Districts::getData(request('provinceId'),request('id'),null,10,request('search'));
            }else{
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return Districts::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return Districts::addToTable();
            }
            $data = $this->add($data );
        } elseif ($param1 == 'edit') {
            if (request()->method() === 'POST') {
                return Districts::updateToTable($param2);
            }
            $data = $this->edit($data,$param2 );
        } elseif ($param1 == 'view') {
            $data = $this->view($data,$param2 );
        } elseif ($param1 == 'delete') {
            return Districts::deleteFromTable($param2);
        }else{
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
            'parent'     => 'Cambodia',
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormDistrict::rulesField(),
            'attributes'  =>  FormDistrict::attributeField(),
            'messages'    =>  FormDistrict::customMessages(),
            'questions'   =>  FormDistrict::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view('Cambodia.index', $data);
    }

    public function list($data)
    {
        $data['view']     = 'Cambodia.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.district');
        return $data;
    }

    public function add($data)
    {
        $data['view']      = 'Cambodia.includes.form.district.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.district');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function edit($data, $id)
    {
        $response           = Districts::getData(request('provinceId'),$id, true);
        $data['view']       = 'Cambodia.includes.form.district.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit.district');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/edit/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/edit/' . $response['data'][0]['id'];
        return $data;
    }

    public function view($data, $id)
    {
        $response           = Districts::getData(request('provinceId'),$id, true);
        $data['view']       = 'Cambodia.includes.form.district.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .view.district');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/view/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/view/' . $response['data'][0]['id'];
        return $data;
    }


}
