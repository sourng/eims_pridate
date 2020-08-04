<?php

namespace App\Http\Controllers\Student;

use App\Models\App;
use App\Models\Users;
use App\Models\Years;
use App\Models\Months;
use App\Models\Students;
use App\Models\Languages;
use App\Models\CardFrames;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;

use App\Models\StudyStatus;
use App\Models\SocailsMedia;
use App\Models\StudentsAttendances;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use App\Models\StudentsStudyCourseScore;
use App\Http\Controllers\Card\CardController;
use App\Http\Requests\FormStudentsStudyCourse;
use App\Http\Controllers\Photo\PhotoController;
use App\Http\Controllers\QrCode\QrCodeController;
use App\Http\Controllers\Certificate\CertificateController;
use App\Http\Controllers\Student\StudentsAttendanceController;
use App\Http\Controllers\Student\StudentsStudyCourseScoreController;
use App\Models\CertificateFrames;
use App\Models\StudentsRequest;
use App\Models\StudyCourseSession;

class StudentsStudyCourseController extends Controller
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
        request()->merge(['ref' => request('ref', StudentsStudyCourse::$path['url'])]);

        $data['study_course_session'] = StudyCourseSession::getData();
        $data['study_status']         = StudyStatus::getData();
        $data['formAction']           = '/add';
        $data['formName']             = Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'];
        $data['title']                = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']            = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']             = url(Users::role() . '/' . $param1);

        $data['formData']       = array(
            'photo' => asset('/assets/img/user/male.jpg'),
        );
        $data['listData']       = array();
        $id = $param2 ? $param2 : request('id');

        if (strtolower($param1) == null || strtolower($param1) == 'list') {
            request()->merge(['id' => $id]);
            $data  = $this->list($data);

            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return StudentsStudyCourse::getData(null, null, 10);
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudentsStudyCourse::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'add') {
            if (request()->method() === 'POST') {
                return StudentsStudyCourse::addToTable();
            }
            $data  = $this->show($data, null, $param1);
        } elseif (strtolower($param1) == 'edit') {
            request()->merge(['id' => $id]);
            if (request()->method() === 'POST') {
                return StudentsStudyCourse::updateToTable($id);
            }
            $data  = $this->show($data, $id, $param1);
        } elseif (strtolower($param1) == 'view') {
            $data  = $this->show($data, $id, $param1);
        } elseif (strtolower($param1) == 'photo') {
            $id = $param3 ? $param3 : request('id');
            request()->merge(['id' => $id]);
            request()->merge(['ref' => StudentsStudyCourse::$path['image'] . '-photo']);
            $view = new PhotoController();
            if (request()->method() === 'POST') {
                return StudentsStudyCourse::makeImageToTable($id);
            }
            return $view->index($param2, $param3, StudentsStudyCourse::getData($id));
        } elseif (strtolower($param1) == 'qrcode') {
            $id = $param3 ? $param3 : request('id');
            request()->merge(['ref' => StudentsStudyCourse::$path['image'] . '-qrcode']);
            request()->merge(['id' => $id, 'qrcode_type' => Students::$path['role']]);
            if (request()->method() === 'POST') {
                return StudentsStudyCourse::makeQrcodeToTable($id);
            }
            $view = new QrCodeController();
            return $view->index($param2, $param3, StudentsStudyCourse::getData($id));
        } elseif (strtolower($param1) == CardFrames::$path['url']) {
            $id = $param3 ? $param3 : request('id');
            request()->merge(['id' => $id]);
            request()->merge(['ref' => StudentsStudyCourse::$path['image'] . '-card']);
            if (request()->method() == "POST") {
                if ($param2 == "save") {
                    return StudentsStudyCourse::makeCardToTable();
                }
            }
            $view = new CardController();
            return $view->index($param2, $param3, StudentsStudyCourse::getData($id));
        } elseif (strtolower($param1) == StudentsStudyCourseScore::$path['url']) {
            $view = new StudentsStudyCourseScoreController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == CertificateFrames::$path['url']) {
            $id = $param3 ? $param3 : request('id');
            request()->merge(['id' => $id]);
            request()->merge(['ref' => StudentsStudyCourse::$path['image'] . '-certificate']);
            if (request()->method() == "POST") {
                if ($param2 == "save") {
                    return StudentsStudyCourse::makeCardToTable();
                }
            }
            $view = new CertificateController();
            return $view->index($param2, $param3, StudentsStudyCourse::getData($id, 'certificate'));
        } elseif (strtolower($param1) == StudentsAttendances::$path['url']) {

            $view = new StudentsAttendanceController();
            $monthYear =  request('month_year') ? explode('-', request('month_year')) : null;
            request()->merge([
                'year'  => $monthYear ? $monthYear[1] : Years::now(),
                'month' => $monthYear ? $monthYear[0] : Months::now(),
                'date'  => request('date') ? request('date') : date('d'),
                'type'  => Students::$path['role'],
            ]);

            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == 'account') {
            $id = $param3 ? $param3 : request('id');
            if ($param2 == 'create') {
                if (request()->method() == "POST") {
                    return StudentsStudyCourse::createAccountToTable($id);
                }
                $data =  $this->account($data, $id, $param2);
            }
        } elseif (strtolower($param1) == 'delete') {
            $id = $param2 ? $param2 : request('id');
            return StudentsStudyCourse::deleteFromTable($id);
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
            'parent'     => StudentsStudyCourse::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       => (strtolower($param1) == 'account') ? ['password' => 'required'] :  FormStudentsStudyCourse::rulesField(),
            'attributes'  => (strtolower($param1) == 'account') ? ['password' => Translator::phrase('password')] :  FormStudentsStudyCourse::attributeField(),
            'messages'    => (strtolower($param1) == 'account') ? [] :  FormStudentsStudyCourse::customMessages(),
            'questions'   => (strtolower($param1) == 'account') ? [] :  FormStudentsStudyCourse::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = StudentsStudyCourse::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Student_Study_Course');
        return $data;
    }



    public function show($data, $id, $type)
    {

        $student = StudentsRequest::where('status', 0)->pluck('id')->toArray();
        
        $data['view']       = StudentsStudyCourse::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.Student_Study_Course');
        $data['metaImage']  = asset('assets/img/icons/register.png');

        if ($id) {
            $student[] = $id;
            $response           = StudentsStudyCourse::getData($id);
            $data['metaLink']   = url(Users::role() . '/' . $type . '/' . $id);
            $data['formData']   = $response['data'][0];
            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/' . $type . '/' . $response['data'][0]['id'];
        }
        $data['student']              = StudentsRequest::getData($student);






        return $data;
    }
    public function account($data, $id, $type)
    {
        $response           = StudentsStudyCourse::getData($id, 'account');
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/account/' . $type . '/' . $response['data'][0]['id'];
        $data['view']       = StudentsStudyCourse::$path['view'] . '.includes.account.index';
        return $data;
    }
}
