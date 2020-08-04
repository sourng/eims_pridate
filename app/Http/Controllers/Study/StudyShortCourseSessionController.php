<?php

namespace App\Http\Controllers\Study;

use App\Models\App;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Models\StudySession;
use App\Models\StudyShortCourseSession;
use App\Models\StudyCourseSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormStudyShortCourseSession;
use App\Models\StudyShortCourseSchedule;

class StudyShortCourseSessionController extends Controller
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
            'ref'   => StudyShortCourseSession::$path['url']
        ]);
        $data['study_short_course_schedule'] = StudyShortCourseSchedule::getData();
        $data['study_session'] = StudySession::getData();

        $data['formData']       = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName']       = 'study/' . StudyShortCourseSession::$path['url'];
        $data['formAction']     = '/add';
        $data['listData']       = array();
        if ($param1 == 'list') {

            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudyShortCourseSession::getData(null, null, 10);
            } else {
                $data = $this->list($data, $param1);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return StudyShortCourseSession::getDataTable();
            } else {
                $data = $this->list($data, $param1);
            }
        } elseif ($param1 == 'add') {

            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return StudyShortCourseSession::addToTable();
                }
            }

            $data = $this->show($data, null, $param1);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return StudyShortCourseSession::updateToTable($id);
                }
            }

            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $param1);
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
            return StudyShortCourseSession::deleteFromTable($id);
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
            'parent'     => StudyShortCourseSession::$path['view'],
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormStudyShortCourseSession::rulesField(),
            'attributes'  =>  FormStudyShortCourseSession::attributeField(),
            'messages'    =>  FormStudyShortCourseSession::customMessages(),
            'questions'   =>  FormStudyShortCourseSession::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data, $param1)
    {
        $data['view']     = StudyShortCourseSession::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Study_Course_Session' . '.' . $param1);
        return $data;
    }

    public function show($data, $id, $type)
    {
        $data['view']       = StudyShortCourseSession::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.Study_Course_Session');
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
        if ($id) {
            $response = StudyShortCourseSession::getData($id, true);
            $data['formData']   = $response['data'][0];
            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        }
        return $data;
    }
}
