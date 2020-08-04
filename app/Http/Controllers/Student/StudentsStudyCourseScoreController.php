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
use App\Models\StudentsScore;
use App\Models\StudyCourseSession;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use App\Models\StudentsStudyCourseScore;
use App\Http\Requests\FormStudentsStudyCourseScore;

class StudentsStudyCourseScoreController extends Controller
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

        $data['study_course_session'] = StudyCourseSession::getData();
        $data['student']    = StudentsStudyCourse::getData();
        $data['formData']       = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName']       = Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . StudentsStudyCourseScore::$path['url'];
        $data['formAction']     = '/add';
        $data['listData']       = array();

        if (strtolower($param1) == null || strtolower($param1) == 'list') {
            $data = $this->list($data, $param1);
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudentsStudyCourseScore::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'add') {
            if (request()->method() === 'POST') {
                return StudentsStudyCourseScore::addToTable();
            }
            $data  = $this->add($data);
        } elseif (strtolower($param1) == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $param1);
        } elseif (strtolower($param1) == 'edit') {
            $id = request('id', $param2);
            if (request()->method() === 'POST') {
                return StudentsStudyCourseScore::updateToTable($id);
            }
            $data = $this->show($data, $id, $param1);
        } elseif (strtolower($param1) == 'subject') {

            if (strtolower($param2) == 'add') {
                if (request()->method() == "POST") {
                    return StudentsScore::addToTable(request('id'), request('subject'), request('marks'));
                }
            } elseif (strtolower($param2) == 'edit') {
                if (request()->method() == "POST") {
                    return StudentsScore::updateToTable(request('id'), request('subject'), request('marks'));
                }
            }
        } elseif (strtolower($param1) == 'attendance' || strtolower($param1) == 'other') {
            if (strtolower($param1) == 'attendance') {
                if (request()->method() == "POST") {
                    return StudentsStudyCourseScore::updateMarksToTable(request('id'), 'attendance_marks', request('marks'));
                }
            } elseif (strtolower($param1) == 'other') {
                if (request()->method() == "POST") {
                    return StudentsStudyCourseScore::updateMarksToTable(request('id'), 'other_marks', request('marks'));
                }
            }
        } elseif (strtolower($param1) == 'report') {
            $data = $this->report($data);
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
            'parent'     => StudentsStudyCourseScore::$path['view'],
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormStudentsStudyCourseScore::rulesField('.*'),
            'attributes'  =>  FormStudentsStudyCourseScore::attributeField('.*'),
            'messages'    =>  FormStudentsStudyCourseScore::customMessages(),
            'questions'   =>  FormStudentsStudyCourseScore::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }
    public function add($data)
    {
        $data['view']  = StudentsStudyCourseScore::$path['view'] . '.includes.form.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . $data['formName']);
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function list($data)
    {
        $data['response'] = StudentsStudyCourseScore::getData(null, null, null,null,true);
        $data['view']     = StudentsStudyCourseScore::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Student_score');
        return $data;
    }
    public function show($data, $id, $type)
    {
        $response           = StudentsStudyCourseScore::getData($id, true);
        $data['view']       = StudentsStudyCourseScore::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.Student_score');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        $data['student']    = StudentsStudyCourse::getData($response['data'][0]['node']['id']);
        return $data;
    }



    public function report($data)
    {
        $data['response']  = StudentsStudyCourseScore::getData();
        $data['view']      = StudentsStudyCourseScore::$path['view'] . '.includes.report.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . $data['formName'] . '.');
        return $data;
    }
}
