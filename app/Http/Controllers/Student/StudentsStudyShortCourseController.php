<?php

namespace App\Http\Controllers\Student;

use App\Models\App;
use App\Models\Users;
use App\Models\Students;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Http\Controllers\Controller;
use App\Models\StudentsStudyShortCourse;
use App\Models\StudentsShortCourseRequest;
use App\Http\Requests\FormStudentsStudyShortCourse;
use App\Models\StudyShortCourseSession;

class StudentsStudyShortCourseController extends Controller
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
        request()->merge(['ref' => request('ref', StudentsStudyShortCourse::$path['url'])]);

        $data['study_short_course_session'] = StudyShortCourseSession::getData();

        $data['formAction']          = '/add';
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['formName']            = Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'];
        $data['title']               = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']           = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']            = url(Users::role() . '/' . $param1);


        $data['listData']            = array();

        if ($param1 == null || $param1 == 'list') {
            $data = $this->list($data);
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudentsStudyShortCourse::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() == 'POST') {
                return StudentsStudyShortCourse::addToTable();
            }
            $data = $this->show($data, request('id', $param2), $param1);
        } elseif ($param1 == 'edit') {
            if (request()->method() == 'POST') {
                return StudentsStudyShortCourse::updateToTable(request('id', $param2));
            }
            $data = $this->show($data, request('id', $param2), $param1);
        } elseif ($param1 == 'delete') {
            return StudentsStudyShortCourse::deleteFromTable(request('id', $param2));
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
            'parent'     => StudentsStudyShortCourse::$path['view'],
            'modal'      => StudentsStudyShortCourse::$path['view'] . '.includes.modal.index',
            'view'       => $data['view'],
        );





        $pages['form']['validate'] = [
            'rules'       => FormStudentsStudyShortCourse::rulesField(),
            'attributes'  => FormStudentsStudyShortCourse::attributeField(),
            'messages'    => FormStudentsStudyShortCourse::customMessages(),
            'questions'   => FormStudentsStudyShortCourse::questionField(),
        ];


        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);


        return view('StudentsStudyShortCourse.index', $data);
    }

    public function list($data)
    {
        $data['view']     = StudentsStudyShortCourse::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.student_study_short_course');
        return $data;
    }
    public function show($data, $id, $type)
    {
        $student = StudentsShortCourseRequest::where('status', '0');

        if (request('instituteId')) {
            $student = $student->where('institute_id', request('instituteId'));
        }
        $student = $student->pluck('id')->toArray();


        $data['view']       = StudentsStudyShortCourse::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.Student_Study_Course');
        $data['metaImage']  = asset('assets/img/icons/register.png');

        if ($id) {
            $student[] = $id;
            $response           = StudentsStudyShortCourse::getData($id);
            $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
            $data['formData']   = $response['data'][0];

            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        }
        $data['student']              = StudentsShortCourseRequest::getData($student);






        return $data;
    }
}
