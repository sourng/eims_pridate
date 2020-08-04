<?php

namespace App\Http\Controllers\Quiz;

use App\Models\App;
use App\Models\Quiz;
use App\Models\Users;
use App\Models\Gender;
use App\Models\Students;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\QuizStudent;
use App\Helpers\ImageHelper;
use App\Models\QuizQuestion;
use App\Models\SocailsMedia;
use App\Models\StudentsRequest;
use App\Models\QuizStudentAnswer;
use App\Models\StudyCourseSession;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormQuizStudent;
use App\Http\Requests\FormQuizStudentAnswerMarks;

class QuizStudentController extends Controller
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
        $data['quiz'] = Quiz::getData();
        $data['study_course_session'] = StudyCourseSession::getData();
        $data['student']  = StudentsStudyCourse::getData();

        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName'] = Quiz::$path['url'] . '/' . QuizStudent::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return QuizStudent::getData(null, null, 10);
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  QuizStudent::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'report') {
            $data = $this->report($data);
        } elseif ($param1 == 'add') {
            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return QuizStudent::addToTable();
                }
            }

            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return QuizStudent::updateToTable($id);
                }
            }

            $data = $this->show($data, $id, $param1);
            $data['view']       = QuizStudent::$path['view'] . '.includes.form.index';
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $param1);
            $data['view']    = QuizStudent::$path['view'] . '.includes.view.index';
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
            return QuizStudent::deleteFromTable($id);
        } elseif ($param1 == 'answer_again') {
            $id = $param2 ? $param2 : request('id');
            return QuizStudentAnswer::updateAnswerAgainToTable($id);
        } elseif ($param1 == 'marks') {
            if ($param2 == 'update') {
                $id = $param3 ? $param3 : request('id');
                return QuizStudentAnswer::updateMarksToTable($id);
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
            'parent'     => QuizStudent::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormQuizStudent::rulesField(),
            'attributes'  =>  FormQuizStudent::attributeField(),
            'messages'    =>  FormQuizStudent::customMessages(),
            'questions'   =>  FormQuizStudent::questionField(),
        ];
        $pages['form2']['validate'] = [
            'rules'       =>  FormQuizStudentAnswerMarks::rulesField(),
            'attributes'  =>  FormQuizStudentAnswerMarks::attributeField(),
            'messages'    =>  FormQuizStudentAnswerMarks::customMessages(),
            'questions'   =>  FormQuizStudentAnswerMarks::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = QuizStudent::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.quiz_student');
        return $data;
    }

    public function add($data)
    {

        $data['view']      = QuizStudent::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.quiz_student');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function show($data, $id, $type)
    {
        $response = QuizStudent::getData($id);
        $data['response'] = $response;
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.quiz_student');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['quiz'] = Quiz::getData($data['formData']['quiz']['id']);
        $data['student'] = StudentsStudyCourse::getData($data['formData']['student']['id']);
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        return $data;
    }

    public function report($data)
    {
        if (request('quizId')) {
            $get = new QuizStudent;
            if (request('quizId')) {
                $get = $get->where('quiz_id', request('quizId'));
            }
            $get = $get->get()->toArray();


            if ($get) {
                $data1 = [];
                $question = [];
                foreach ($get as $row) {
                    $student_study_course =   StudentsStudyCourse::select((new StudentsRequest())->getTable() . '.*')
                        ->join((new QuizStudent())->getTable(), (new QuizStudent())->getTable() . '.student_study_course_id', (new StudentsStudyCourse())->getTable() . '.id')
                        ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                        ->join((new Students())->getTable(), (new Students())->getTable() . '.id', (new StudentsRequest())->getTable() . '.student_id')
                        ->where((new StudentsStudyCourse())->getTable() . '.id', $row['student_study_course_id'])
                        ->first()->toArray();


                    $student    =   Students::where('id', $student_study_course['student_id'])->first()->toArray();
                    $node = [
                        'id'            => $student['id'],
                        'first_name'         => array_key_exists('first_name_' . app()->getLocale(), $student) ? $student['first_name_' . app()->getLocale()] : $student['first_name_en'],
                        'last_name'          => array_key_exists('last_name_' . app()->getLocale(), $student) ? $student['last_name_' . app()->getLocale()] : $student['last_name_en'],
                        'gender'    => $student['gender_id'] ? (Gender::getData($student['gender_id'])['data'][0]) : null,
                        'photo'     => ImageHelper::site(Students::$path['image'], $student['photo']),
                    ];
                    $question = QuizQuestion::where('quiz_id', $row['quiz_id'])->get();
                    $quiz_answered = [];
                    if ($question) {

                        $qa = [];
                        foreach ($question->toArray() as $key => $q) {
                            $a  = QuizStudentAnswer::where('quiz_student_id', $row['id'])->where('quiz_question_id', $q['id'])->first();
                            $qa[] = [
                                'id'        => null,
                                'question'  => QuizQuestion::getData($q['id'])['data'][0],
                                'answered'  => null,
                                'marks'     => $a ? $a->marks : 0,
                            ];
                        }
                        $quiz_answered = $qa;
                    }

                    $data1[]         = [
                        'id'            => $row['id'],
                        'quiz'          => Quiz::getData($row['quiz_id'])['data'][0],
                        'quiz_answered' => $quiz_answered,
                        'student'       => [
                            'id'        =>  $student_study_course['id'],
                            'photo'     =>  $student_study_course['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'], $student_study_course['photo'])) : $node['photo'],
                            'node'      =>  $node,
                        ],
                    ];
                }

                $data['response'] = [
                    'success'   => true,
                    'data'      => $data1,
                    'question'  => $question
                ];
            } else {
                $data['response'] = [
                    'success'   => false,
                    'message'   => Translator::phrase('no_data'),
                ];
            }
        }else{
            $data['response'] = [
                'success'   => false,
                'message'   => Translator::phrase('please_filter'),
            ];
        }
        $data['view']     = QuizStudent::$path['view'] . '.includes.report.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .report.quiz_student');
        return $data;
    }
}
