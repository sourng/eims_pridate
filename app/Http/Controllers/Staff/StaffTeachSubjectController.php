<?php

namespace App\Http\Controllers\Staff;

use App\Models\App;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Years;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\ImageHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Models\StudySubjects;
use App\Models\StaffTeachSubject;
use App\Models\StudySubjectLesson;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormStaffTeachSubject;

class StaffTeachSubjectController extends Controller
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
        $data['staff']['data'] = Staff::all()->map(function ($row) {
            return [
                'id'    => $row['id'],
                'name'   => $row['first_name_km'] . ' ' . $row['last_name_km'] . ' - '
                    . $row['first_name_en'] . ' ' . $row['last_name_en'] . ' - '
                    . $row['phone'],
                'photo' => ImageHelper::site(Staff::$path['image'], $row['photo'])

            ];
        })->toArray();

        $data['study_subject']['data'] = StudySubjects::all()->map(function ($row) {
            return [
                'id'    => $row['id'],
                'name'   => $row[app()->getLocale()],
                'image' => $row['image'] ? ImageHelper::site(StudySubjects::$path['image'], $row['image']) : ImageHelper::prefix()
            ];
        })->toArray();
        $data['formData'] = array(
            'year' => Years::now(),
        );
        $data['formName'] = Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                request()->merge([
                    'ref'   => StudySubjectLesson::$path['url']
                ]);
                return StaffTeachSubject::getData();
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StaffTeachSubject::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'grid') {
            $data = $this->grid($data);
        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return StaffTeachSubject::addToTable();
            }
            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->method() === 'POST') {
                return StaffTeachSubject::updateToTable($id);
            }
            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
            return StaffTeachSubject::deleteFromTable($id);
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
            'parent'     => StaffTeachSubject::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormStaffTeachSubject::rulesField(),
            'attributes'  =>  FormStaffTeachSubject::attributeField(),
            'messages'    =>  FormStaffTeachSubject::customMessages(),
            'questions'   =>  FormStaffTeachSubject::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['response'] = StaffTeachSubject::getData(null, null, 10);
        $data['view']     = StaffTeachSubject::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.staff_teach_subject');
        return $data;
    }
    public function grid($data)
    {
        $data['response'] = StaffTeachSubject::getTeachSubjects(null, null, null, 10);

        $data['view']     = StaffTeachSubject::$path['view'] . '.includes.grid.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .grid.staff_teach_subject');
        return $data;
    }

    public function add($data)
    {
        $data['view']      = StaffTeachSubject::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.staff_teach_subject');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }



    public function show($data, $id, $type)
    {
        $response = StaffTeachSubject::getData(null, $id, true);
        $data['view']       = StaffTeachSubject::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.staff_teach_subject');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        return $data;
    }
}
