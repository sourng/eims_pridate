<?php

namespace App\Http\Controllers\Study;

use App\Models\App;
use App\Models\Days;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\CourseTypes;
use App\Models\StudyCourse;
use App\Models\SocailsMedia;
use App\Models\StudyFaculty;
use App\Models\StudySession;
use App\Models\StudyModality;
use App\Models\StudyPrograms;
use App\Models\StudySubjects;
use App\Models\StudySemesters;
use App\Models\CurriculumAuthor;
use App\Models\StudyOverallFund;
use App\Models\StudyAcademicYears;
use App\Http\Controllers\Controller;
use App\Models\CurriculumEndorsement;
use App\Http\Requests\FormStudyCourse;
use App\Models\Institute;

class StudyCourseController extends Controller
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

        $data['institute']                = Institute::getData();
        $data['study_faculty']            = StudyFaculty::getData();
        $data['course_type']              = CourseTypes::getData();
        $data['study_modality']           = StudyModality::getData();
        $data['study_program']            = StudyPrograms::getData();
        $data['study_overall_fund']       = StudyOverallFund::getData();
        $data['curriculum_author']        = CurriculumAuthor::getData();
        $data['curriculum_endorsement']   = CurriculumEndorsement::getData();
        $data['study_academic_year']      = StudyAcademicYears::getData();
        $data['study_semester']           = StudySemesters::getData();
        $data['study_subject']            = StudySubjects::getData();

        $data['days']               = Days::getData();
        $data['schedule']           = StudySession::getData();



        $data['formData']       = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName']       = 'study/' . StudyCourse::$path['url'];
        $data['formAction']     = '/add';
        $data['listData']       = array();

        if ($param1 == 'list' || $param1 == 'short' || $param1 == 'long') {

            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudyCourse::getData(null, null, 10,request('search'));
            } else {
                $data = $this->list($data, $param1);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return StudyCourse::getDataTable();
            } else {
                $data = $this->list($data, $param1);
            }
        } elseif ($param1 == 'add') {
            if (request()->method() === 'POST') {
                return StudyCourse::addToTable();
            } else {
                $data = $this->add($data);
            }
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->method() === 'POST') {
                return StudyCourse::updateToTable($id);
            }
            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);

            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
            return StudyCourse::deleteFromTable($id);
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
            'parent'     => StudyCourse::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormStudyCourse::rulesField(),
            'attributes'  =>  FormStudyCourse::attributeField(),
            'messages'    =>  FormStudyCourse::customMessages(),
            'questions'   =>  FormStudyCourse::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data, $param1)
    {
        if ($param1 == "short") {
            request()->merge(["typeId" => 1]);
        } elseif ($param1 == "long") {
            request()->merge(["typeId" => 2]);
        }
        $data['view']     = StudyCourse::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Study_Course' . '.' . $param1);
        return $data;
    }

    public function add($data)
    {
        $data['view']      = StudyCourse::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.Study_Course');
        $data['metaImage'] = asset('assets/img/icons/add.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function show($data, $id, $type)
    {
        $response = StudyCourse::getData($id, true);
        $data['view']       = StudyCourse::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.Study_Course');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        return $data;
    }
}
