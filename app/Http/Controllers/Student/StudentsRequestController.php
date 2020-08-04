<?php

namespace App\Http\Controllers\Student;


use App\Models\App;
use App\Models\Users;
use App\Models\Institute;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\ImageHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\StudyCourse;
use App\Models\SocailsMedia;
use App\Models\StudySession;
use App\Models\StudyPrograms;
use App\Models\StudySemesters;
use App\Models\StudentsRequest;
use App\Models\StudyGeneration;
use App\Models\StudyAcademicYears;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormStudentsRequest;
use App\Models\Students;
use Illuminate\Support\Facades\Auth;

class StudentsRequestController extends Controller
{


    public function __construct()
    {
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = 'list', $param2 = null, $param3 = null)
    {


        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );


        $data['formAction']      = '/add';
        $data['formName']        = Students::$path['url'] . '/' . StudentsRequest::$path['url'];
        $data['title']           = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.request_study');
        $data['metaImage']       = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']        = url(Users::role() . '/' . $param1);
        $data['listData']       = array();
        if ($param1 == 'list' || $param1 == null) {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return StudentsRequest::getData(null, null, 10, request('search'));
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudentsRequest::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {
            $data = $this->show($data, null, $param1);
        } elseif ($param1 == 'view') {
            $data = $this->show($data, request('id', $param2), $param1);
        } elseif ($param1 == 'edit') {
            if (request()->method() == 'POST') {
                return StudentsRequest::updateToTable(request('id', $param2));
            }
            $data = $this->show($data, request('id', $param2), $param1);
        } elseif ($param1 == 'delete') {
            return StudentsRequest::deleteFromTable(request('id', $param2));
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
            'parent'     => StudentsRequest::$path['view'],
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormStudentsRequest::rulesField(),
            'attributes'  =>  FormStudentsRequest::attributeField(),
            'messages'    =>  FormStudentsRequest::customMessages(),
            'questions'   =>  FormStudentsRequest::questionField(),
        ];
        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view(StudentsRequest::$path['view'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = StudentsRequest::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.request_study');
        $data['response'] =  StudentsRequest::getData(null, null, 10);
        return $data;
    }


    public function show($data, $id, $type)
    {


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


        $data['view']       = StudentsRequest::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.request_study');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');

        if($id){
            $response = StudentsRequest::getData($id, true);
            $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
            $data['formData']   = $response['data'][0];
            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
            request()->merge([
                'programId' => $data['formData']['study_program']['id']
            ]);
        }

        $data['institute']         = Institute::getData();
        $data['study_program']     = StudyPrograms::getData();
        $data['study_course']      = StudyCourse::getData();
        $data['study_generation']  = StudyGeneration::getData();
        $data['study_academic_year']  = StudyAcademicYears::getData();
        $data['study_semester']       = StudySemesters::getData();
        $data['study_session']       = StudySession::getData();

        return $data;
    }
}
