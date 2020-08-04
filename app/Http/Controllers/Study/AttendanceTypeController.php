<?php

namespace App\Http\Controllers\Study;

use App\Models\App;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Models\AttendancesType;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormAttendancesType;


class AttendanceTypeController extends Controller
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
        $data['formName'] =  'study/' . AttendancesType::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return AttendancesType::getData(null, null, 10, request('search'));
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return AttendancesType::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return AttendancesType::addToTable();
            }

            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return AttendancesType::updateToTable($id);
                }
            }

            $data = $this->edit($data, $id);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);

            $data = $this->view($data, $id);
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
            'parent'     => AttendancesType::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormAttendancesType::rulesField(),
            'attributes'  =>  FormAttendancesType::attributeField(),
            'messages'    =>  FormAttendancesType::customMessages(),
            'questions'   =>  FormAttendancesType::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = AttendancesType::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Attendance_Type');
        return $data;
    }

    public function add($data)
    {
        $data['view']      = AttendancesType::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.Attendance_Type');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function edit($data, $id)
    {
        $response = AttendancesType::getData($id, true);
        $data['view']       = AttendancesType::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit.Attendance_Type');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/edit/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/edit/' . $response['data'][0]['id'];
        return $data;
    }

    public function view($data, $id)
    {
        $response = AttendancesType::getData($id, true);
        $data['view']       = AttendancesType::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .view.Attendance_Type');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/view/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/view/' . $response['data'][0]['id'];
        return $data;
    }
}
