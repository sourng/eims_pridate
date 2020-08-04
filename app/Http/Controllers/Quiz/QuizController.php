<?php

namespace App\Http\Controllers\Quiz;

use App\Models\App;
use App\Models\Quiz;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Http\Requests\FormQuiz;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Quiz\QuizQuestionController;
use App\Models\Institute;
use App\Models\QuizAnswerType;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionType;
use App\Models\QuizStudent;


class QuizController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }


    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        $data['institute'] = Institute::getData();
        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName'] = Quiz::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == null) {
            $data['shortcut'] = [
                [
                    'name'  => Translator::phrase('add.quiz'),
                    'link'  => url(Users::role() . '/' . Quiz::$path['url'] . '/add'),
                    'icon'  => 'fas fa-plus',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],
                [
                    'name'  => Translator::phrase('list.quiz'),
                    'link'  => url(Users::role() . '/' . Quiz::$path['url'] . '/list'),
                    'icon'  => 'fas fa-question-square',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],
                [
                    'name'  => Translator::phrase('list.quiz_question'),
                    'link'  => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestion::$path['url'] . '/list'),
                    'icon'  => 'fas fa-question',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],
                [
                    'name'  => Translator::phrase('list.quiz_student'),
                    'link'  => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizStudent::$path['url'] . '/list'),
                    'icon'  => 'fas fa-users-class',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],
                [
                    'name'  => Translator::phrase('list.quiz_answer_type'),
                    'link'  => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizAnswerType::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('quiz_answer_type'),
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],
                [
                    'name'  => Translator::phrase('list.quiz_question_type'),
                    'link'  => url(Users::role() . '/' . Quiz::$path['url'] . '/' . QuizQuestionType::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('quiz_question_type'),
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ]
            ];
            $data['view']  = 'Quiz.includes.dashboard.index';
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        } elseif ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return Quiz::getData(null, null, 10, request('search'));
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  Quiz::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {

            if (request()->method() === 'POST') {
                return Quiz::addToTable();
            }


            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);

            if (request()->method() === 'POST') {
                return Quiz::updateToTable($id);
            }


            $data = $this->edit($data, $id);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data = $this->view($data, $id);
        } elseif ($param1 == 'delete') {

            $id = request('id', $param2);
            return Quiz::deleteFromTable($id);
        } elseif ($param1 == QuizQuestionType::$path['url']) {
            $view = new QuizQuestionTypeController();
            return $view->index($param2, $param3);
        } elseif ($param1 == QuizAnswerType::$path['url']) {
            $view = new QuizAnswerTypeController();
            return $view->index($param2, $param3);
        } elseif ($param1 == QuizQuestion::$path['url']) {
            $view = new QuizQuestionController();
            return $view->index($param2, $param3);
        } elseif ($param1 == QuizStudent::$path['url']) {
            $view = new QuizStudentController();
            return $view->index($param2, $param3);
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
            'parent'     => Quiz::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormQuiz::rulesField(),
            'attributes'  =>  FormQuiz::attributeField(),
            'messages'    =>  FormQuiz::customMessages(),
            'questions'   =>  FormQuiz::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = Quiz::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . str_replace('-', '_', $data['formName']));
        return $data;
    }

    public function add($data)
    {
        $data['view']      = Quiz::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . str_replace('-', '_', $data['formName']));
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function edit($data, $id)
    {
        $response = Quiz::getData($id, true);
        $data['view']       = Quiz::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/edit/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/edit/' . $response['data'][0]['id'];
        return $data;
    }

    public function view($data, $quizId)
    {
        $get = QuizQuestion::where('quiz_id', $quizId);

        $get = $get->get()->toArray();
        if ($get) {
            $response = [
                'success' => true,
                'data' => $get,
            ];
        } else {
            $response = [
                'success' => false,
                'data' => [],
                'message' => Translator::phrase('no_data'),
            ];
        }

        $data['response'] = $response;
        $data['quiz']   = Quiz::getData($quizId);
        $data['view']       = Quiz::$path['view'] . '.includes.view.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .view.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/view/' . $quizId);
        $data['formAction'] = '/view/' . $quizId;
        return $data;
    }
}
