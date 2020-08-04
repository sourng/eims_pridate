<?php

namespace App\Http\Controllers\General;

use App\Models\App;
use App\Models\Users;
use App\Models\Communes;
use App\Models\Villages;
use App\Models\Districts;
use App\Models\Languages;
use App\Models\Provinces;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;;
use App\Models\SocailsMedia;
use App\Http\Requests\FormVillage;
use App\Http\Controllers\Controller;

class VillageController extends Controller
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

        // $g = Villages::orderBy('id', 'ASC')->get()->toArray();

        // foreach ($g as $value) {
        //     echo "[<br>
        //             'id' => '" . $value['id'] . "',<br>
        //             'name' => '" . str_replace("'","\'",$value['name']) . "',<br>
        //             'en' => '" . str_replace("'","\'",$value['en']) . "',<br>
        //             'km' => '" . str_replace("'","\'",$value['km']) . "',<br>
        //             'commune_id' => '" . $value['commune_id'] . "'
        //         <br>]," . "<br>";
        // }
        // dd();

        $data['provinces']   = Provinces::getData();
        $data['districts']   = Districts::getData('null','null');
        $data['communes']    = Communes::getData('null','null');

        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );

        $data['formAction']      = '/add';
        $data['formName']        = 'general/'.Villages::$path['url'];
        $data['title']           = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']       = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']        = url(Users::role() . '/' . $param1);
        $data['listData']       = array();

        request()->merge([
            'id' => $param2 ? $param2 : request('id'),
        ]);


        if ($param1 == 'list' || $param1 == null) {
            if(strtolower(request()->server('CONTENT_TYPE')) == 'application/json'){
                return  Villages::getData(request('communeId'), request('id'),null,10,request('search'));
            }else{
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return Villages::getDataTable();
            } else {
                $data = $this->list($data);
            }

        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return Villages::addToTable();
            }
            $data = $this->add($data );
        } elseif ($param1 == 'edit') {
            if (request()->method() === 'POST') {
                return Villages::updateToTable($param2);
            }
            $data = $this->show($data,$param2 ,$param1 );
        } elseif ($param1 == 'view') {
            $data = $this->show($data,$param2,$param1  );
        } elseif ($param1 == 'delete') {
            return Villages::deleteFromTable($param2);
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
            'rules'       =>  FormVillage::rulesField(),
            'attributes'  =>  FormVillage::attributeField(),
            'messages'    =>  FormVillage::customMessages(),
            'questions'   =>  FormVillage::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view('Cambodia.index', $data);
    }

    public function list($data)
    {
        $data['view']     = 'Cambodia.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.village');
        return $data;
    }

    public function add($data)
    {
        $data['view']      = 'Cambodia.includes.form.village.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.village');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function edit($data, $id)
    {
        $response           = Villages::getData(request('communeId'),$id, true);
        $data['view']       = 'Cambodia.includes.form.village.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit.village');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/edit/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/edit/' . $response['data'][0]['id'];
        return $data;
    }

    public function show($data, $id,$type)
    {
        $response           = Villages::getData(request('communeId'),$id, true);
        $data['view']       = 'Cambodia.includes.form.village.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .'.$type.'.village');
        $data['metaImage']  = asset('assets/img/icons/'.$type.'.png');
        $data['metaLink']   = url(Users::role() . '/'.$type.'/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/'.$type.'/' . $response['data'][0]['id'];

        $data['districts']      = Districts::getData($data['formData']['province']['id']);
        $data['communes']       = Communes::getData($data['formData']['district']['id']);
        return $data;
    }


}
