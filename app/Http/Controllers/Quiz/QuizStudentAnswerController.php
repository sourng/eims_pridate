<?php

namespace App\Http\Controllers\Quiz;

use App\Models\App;
use App\Models\Quiz;
use App\Models\Users;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\StudyClass;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\QuizStudent;
use App\Models\StudyCourse;
use App\Models\SocailsMedia;
use App\Models\StudySession;
use App\Models\StudyPrograms;
use App\Models\StudySemesters;
use App\Models\StudyGeneration;
use App\Models\QuizStudentAnswer;
use App\Models\StudyAcademicYears;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FormQuizStudentAnswer;
use App\Models\QuizAnswerType;
use App\Models\Students;
use App\Models\StudentsRequest;

class QuizStudentAnswerController extends Controller
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

        $data['course_routine'] = StudentsStudyCourse::select((new QuizStudent())->getTable() . '.*')
            ->join((new QuizStudent())->getTable(), (new QuizStudent())->getTable() . '.student_study_course_id', '=', (new StudentsStudyCourse())->getTable() . '.id')
            ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
            ->where('student_id', Auth::user()->node_id)
            ->get()->toArray();

        $data['quiz'] = Quiz::getData(request('quizId', 'null'));
        if ($data['course_routine']) {
            $quiz_id = [];
            foreach ($data['course_routine'] as $key => $row) {
                $quiz_id[] = $row['quiz_id'];
            }
            $data['quiz'] = Quiz::getData(request('quizId', $quiz_id));
        }



        $data['formName'] = 'study/' . Quiz::$path['url'] . '/' . QuizStudentAnswer::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list' || $param1 == null) {
            $data = $this->list($data);

        } elseif ($param1 == 'add') {
            if (request()->ajax() && request()->method() === 'POST') {
                return QuizStudentAnswer::addToTable();
            }
            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->ajax() && request()->method() === 'POST') {
                return QuizStudentAnswer::updateToTable($id);
            }

            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $$param1);
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
            return QuizStudentAnswer::deleteFromTable($id);
        } elseif ($param1 == QuizStudentAnswer::$path['url']) {
            if ($param2 == 'add') {
                return QuizStudentAnswer::addToTable();
            } elseif ($param2 == 'update') {
                $id = $id = request('id', $param3);
                return QuizStudentAnswer::updateToTable($id);
            }
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
            'parent'     => QuizStudentAnswer::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormQuizStudentAnswer::rulesField(),
            'attributes'  =>  FormQuizStudentAnswer::attributeField(),
            'messages'    =>  FormQuizStudentAnswer::customMessages(),
            'questions'   =>  FormQuizStudentAnswer::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $studentStudyCourse = StudentsStudyCourse::select((new StudentsStudyCourse())->getTable() . '.*')
            ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
            ->where('student_id', Auth::user()->node_id)
            ->get()->toArray();
        $student_study_course_id = [];
        foreach ($studentStudyCourse as $key => $course) {
            $student_study_course_id[] = $course['id'];
        }
        $data['response'] = QuizStudentAnswer::getData1($student_study_course_id);
        
        $data['view']     = QuizStudentAnswer::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.quiz_question');
        return $data;
    }

    public function add($data)
    {
        $data['quiz'] = Quiz::getData(null, null, true);
        $data['institute']            = Institute::getData(request('instituteId', 'null'));
        $data['study_program']        = StudyPrograms::getData(request('programId', 'null'));
        $data['study_course']         = StudyCourse::getData(request('courseId', 'null'));
        $data['study_generation']     = StudyGeneration::getData(request('generationId', 'null'));
        $data['study_academic_year']  = StudyAcademicYears::getData(request('yearId', 'null'));
        $data['study_semester']       = StudySemesters::getData(request('semesterId', 'null'));
        $data['study_session']        = StudySession::getData(request('sessionId', 'null'));
        $data['study_class']          = StudyClass::getData(request('classId', 'null'));
        $data['student']              = StudentsStudyCourse::getData(null, null, 10);
        $data['class']                = StudentsStudyCourse::studyClass(null, true);

        $data['view']      = QuizStudentAnswer::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . str_replace('-', '_', $data['formName']));
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }
    public function show($data, $id, $type)
    {

        $data['quiz'] = Quiz::getData(null, null, true);
        $data['institute']            = Institute::getData(request('instituteId', 'null'));
        $data['study_program']        = StudyPrograms::getData(request('programId', 'null'));
        $data['study_course']         = StudyCourse::getData(request('courseId', 'null'));
        $data['study_generation']     = StudyGeneration::getData(request('generationId', 'null'));
        $data['study_academic_year']  = StudyAcademicYears::getData(request('yearId', 'null'));
        $data['study_semester']       = StudySemesters::getData(request('semesterId', 'null'));
        $data['study_session']        = StudySession::getData(request('sessionId', 'null'));
        $data['study_class']          = StudyClass::getData(request('classId', 'null'));
        $data['student']              = StudentsStudyCourse::getData(null, null, 10);
        $data['class']                = StudentsStudyCourse::studyClass(null, true);

        $response = QuizStudentAnswer::getData($id, 10);
        $data['view']       = QuizStudentAnswer::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        return $data;
    }
}
