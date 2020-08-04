<?php

namespace App\Http\Controllers\General;

use App\Models\App;
use App\Models\Users;
use App\Models\Holidays;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Http\Requests\FormHoliday;
use App\Http\Controllers\Controller;


class HolidayController extends Controller
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

        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName'] = 'general/' . Holidays::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return Holidays::getData(null, null, 10);
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return Holidays::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'calendar') {

            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return Holidays::getData(null, 'calendar');
            } else {
                $data = $this->calendar($data);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return Holidays::addToTable();
            }

            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return Holidays::updateToTable($id);
                }
            }

            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);

            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
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
            'parent'     => Holidays::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormHoliday::rulesField(),
            'attributes'  =>  FormHoliday::attributeField(),
            'messages'    =>  FormHoliday::customMessages(),
            'questions'   =>  FormHoliday::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = Holidays::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.holiday');
        return $data;
    }

    public function calendar($data)
    {
        $data['response'] = Holidays::getData(null, null, 10);
        $data['view']     = Holidays::$path['view'] . '.includes.calendar.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .calendar.holiday');
        return $data;
    }

    public function add($data)
    {
        $data['view']      = Holidays::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.holiday');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function show($data, $id, $type)
    {
        $response = Holidays::getData($id, true);
        $data['view']       = Holidays::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.holiday');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        return $data;
    }
}
