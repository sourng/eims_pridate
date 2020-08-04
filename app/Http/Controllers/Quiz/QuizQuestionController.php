<?php

namespace App\Http\Controllers\Quiz;

use App\Models\App;
use App\Models\QuizQuestion;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Http\Requests\FormQuizQuestion;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormQuizAnswer;
use App\Models\Quiz;
use App\Models\QuizAnswerType;
use App\Models\QuizQuestionType;


class QuizQuestionController extends Controller
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
        $data['quiz_type'] = QuizQuestionType::getData();
        $data['quiz_answer_type'] = QuizAnswerType::getData();
        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName'] = Quiz::$path['url'] . '/' . QuizQuestion::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return QuizQuestion::getData();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {

            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return QuizQuestion::addToTable();
                }
            }

            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);

            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return QuizQuestion::updateToTable($id);
                }
            }
            $data = $this->show($data, $id, $param1);
            $data['view']       = QuizQuestion::$path['view'] . '.includes.form.index';
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $param1);
            $data['view']       = QuizQuestion::$path['view'] . '.includes.view.index';
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  QuizQuestion::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'delete') {

            $id = request('id', $param2);
            return QuizQuestion::deleteFromTable($id);
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
            'parent'     => QuizQuestion::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormQuizQuestion::rulesField() + FormQuizAnswer::rulesField('.*'),
            'attributes'  =>  FormQuizQuestion::attributeField() + FormQuizAnswer::attributeField('.*'),
            'messages'    =>  FormQuizQuestion::customMessages() + FormQuizAnswer::customMessages(),
            'questions'   =>  FormQuizQuestion::questionField() + FormQuizAnswer::questionField(),
        ];


        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = QuizQuestion::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . str_replace('-', '_', $data['formName']));
        return $data;
    }

    public function add($data)
    {
        $data['view']      = QuizQuestion::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . str_replace('-', '_', $data['formName']));
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }


    public function show($data, $id, $type)
    {
        $response = QuizQuestion::getData($id, true);
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        return $data;
    }
}
