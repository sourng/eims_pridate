<?php

namespace App\Http\Controllers\Student;

use App\Models\App;
use App\Models\Users;
use App\Models\Students;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\ImageHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Http\Controllers\Controller;
use App\Models\StudentsShortCourseRequest;
use App\Http\Requests\FormStudentsShortCourseRequest;
use App\Models\Institute;
use App\Models\StudySession;
use App\Models\StudySubjects;

class StudentsShortCourseRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = null, $param2 = null, $param3 = null, $param4 = null)
    {
        request()->merge([
            'courseTId' => 1,
        ]);

        $data['formAction']          = '/add';
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['formName']            = Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'];
        $data['title']               = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']           = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']            = url(Users::role() . '/' . $param1);


        $data['listData']            = array();

        if ($param1 == null || $param1 == 'list') {
            $data = $this->list($data);
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudentsShortCourseRequest::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() == 'POST') {
                return StudentsShortCourseRequest::addToTable();
            }
            $data = $this->show($data, null, $param1);
        } elseif ($param1 == 'edit') {
            if (request()->method() == 'POST') {
                return StudentsShortCourseRequest::addToTable(request('id', $param2));
            }
            $data = $this->show($data, request('id', $param2), $param1);
        } elseif ($param1 == 'delete') {
            return StudentsShortCourseRequest::deleteFromTable(request('id', $param2));
        } else {

            abort(404);
        }



        MetaHelper::setConfig(
            [
                'title'       => $data['title'],
                'author'      => config('app.name'),
                'keywords'    => '',
                'description' => '',
                'link'        => $data['metaLink'],
                'image'       => $data['metaImage']
            ]
        );

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
            'parent'     => StudentsShortCourseRequest::$path['view'],
            'modal'      => StudentsShortCourseRequest::$path['view'] . '.includes.modal.index',
            'view'       => $data['view'],
        );





        $pages['form']['validate'] = [
            'rules'       => FormStudentsShortCourseRequest::rulesField(),
            'attributes'  => FormStudentsShortCourseRequest::attributeField(),
            'messages'    => FormStudentsShortCourseRequest::customMessages(),
            'questions'   => FormStudentsShortCourseRequest::questionField(),
        ];


        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);


        return view('StudentsShortCourseRequest.index', $data);
    }

    public function list($data)
    {
        $data['view']     = StudentsShortCourseRequest::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.student_short_course_request');
        return $data;
    }

    public function show($data, $id, $type)
    {
        $data['institute']          = Institute::getData();
        $data['study_subject']      = StudySubjects::getData();
        $data['study_session']      = StudySession::getData();

        $student = Students::orderBy('first_name_km', 'ASC');
        if (request('instituteId')) {
            $student->where('institute_id', request('instituteId'));
        }
        $data['student']['data'] =  $student->get(['id', 'first_name_km', 'last_name_km', 'first_name_en', 'last_name_en', 'photo'])->map(function ($row) {
            return [
                'id'    => $row['id'],
                'name'  => $row['first_name_km'] . ' ' . $row['last_name_km'] . ' - ' . $row['first_name_en'] . ' ' . $row['last_name_en'],
                'photo' => ImageHelper::site(Students::$path['image'], $row['photo'])
            ];
        })->toArray();


        $data['view']       = StudentsShortCourseRequest::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.student_short_course_request');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');

        if ($id) {
            $response = StudentsShortCourseRequest::getData($id, true);
            $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
            $data['formData']   = $response['data'][0];
            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        }
        return $data;
    }
}
