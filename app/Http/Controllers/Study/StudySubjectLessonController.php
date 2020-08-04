<?php

namespace App\Http\Controllers\Study;

use App\Helpers\FileHelper;
use App\Models\App;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Models\StudySubjectLesson;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormStudySubjectLesson;
use App\Models\StaffTeachSubject;


class StudySubjectLessonController extends Controller
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



        request()->merge([
            'ref'   => StudySubjectLesson::$path['url']
        ]);

        $data['staff_teach_subject'] = StaffTeachSubject::getData();
        $data['formData'] = array(
            'image' => asset('/assets/img/icons/pdf.png'),
        );
        $data['formName'] = 'study/' . StudySubjectLesson::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {
            $data = $this->list($data);
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return StudySubjectLesson::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'grid') {
            $data = $this->grid($data);
        } elseif ($param1 == 'add') {

            if (request()->method() === 'POST') {
                return StudySubjectLesson::addToTable();
            }

            $data = $this->add($data);

        } elseif ($param1 == 'edit') {

            $id = request('id', $param2);
            if (request()->method() === 'POST') {
                return StudySubjectLesson::updateToTable($id);
            }

            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'delete') {

            $id = request('id', $param2);

            return StudySubjectLesson::deleteFromTable($id);
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
            'parent'     => StudySubjectLesson::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormStudySubjectLesson::rulesField(),
            'attributes'  =>  FormStudySubjectLesson::attributeField(),
            'messages'    =>  FormStudySubjectLesson::customMessages(),
            'questions'   =>  FormStudySubjectLesson::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);

        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = StudySubjectLesson::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Study_Subject_lesson');
        return $data;
    }
    public function grid($data)
    {
        $data['response'] =  StudySubjectLesson::getData(null, null, 10);
        $data['view']     = StudySubjectLesson::$path['view'] . '.includes.grid.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .grid.Study_Subject_lesson');
        return $data;
    }


    public function add($data)
    {
        $data['view']      = StudySubjectLesson::$path['view'] . '.includes.form.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.Study_Subject_lesson');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }



    public function show($data, $id, $type)
    {
        $response = StudySubjectLesson::getData($id, true);
        $data['view']       = StudySubjectLesson::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.Study_Subject_lesson');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        
        return $data;
    }
}
