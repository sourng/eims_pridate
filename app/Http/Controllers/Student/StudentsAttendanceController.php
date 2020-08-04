<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\App;
use App\Models\Users;
use App\Models\Years;
use App\Models\Months;
use App\Models\Holidays;
use App\Models\Students;
use App\Helpers\QRHelper;
use App\Models\Languages;
use App\Helpers\Encryption;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Models\AttendancesType;
use App\Models\StudyCourseSession;
use App\Models\StudentsAttendances;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;

class StudentsAttendanceController extends Controller
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

        $data['formData']             = array(
            'image'                   => asset('/assets/img/icons/image.jpg'),
        );
        $data['listData']             = array();
        $data['formAction']           = '/scan';
        $data['formName']             = Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . StudentsAttendances::$path['url'];
        $data['title']                = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']            = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']             = url(Users::role() . '/' . $param1);

        if ($param1 == 'list' || $param1 == null) {
            $data = $this->list($data, $param3);
        } elseif ($param1 == 'edit') {
            if (request()->method() == 'POST') {
                request()->merge(['id' => $param2]);
                return $this->edit();
            }
        } elseif ($param1 == 'scan') {
            if(request()->method() == 'POST'){
                return $this->qrcode();
            }
            $data = $this->scan($data);
        } elseif ($param1 == 'add') {
            return $this->qrcode();
        } elseif ($param1 == 'report') {
            //return Excel::download(new StudentsAttendanceExport, 'students-attendance.xlsx');
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
            'parent'     => StudentsAttendances::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  [],
            'attributes'  =>  [],
            'messages'    =>  [],
            'questions'   =>  [],
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['formData']['node_type'] = request('type');
        $data['attendances_type']     = AttendancesType::getData();
        $data['study_course_session'] = StudyCourseSession::getData();
        $data['months']               = Months::getData();
        $data['holiday']   = Holidays::getHoliday(request('year'), request('month'))['data'];
        $data['response']  = StudentsAttendances::getData(request('year'), request('month'), null, request('id'), 10);
        $data['view']      = StudentsAttendances::$path['view'] . '.includes.list.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.student_attendance');

        return $data;
    }

    public function edit()
    {
        $exists = StudentsAttendances::existsToTable(
            request('year'),
            request('month'),
            request('date'),
            Encryption::decode(request('id'))['student_study_course_id']
        );

        if ($exists) {

            $response =  StudentsAttendances::updateToTable(
                request('year'),
                request('month'),
                request('date'),
                Encryption::decode(request('id'))['student_study_course_id'],
                request('absent')
            );
        } else {
            $response =  StudentsAttendances::addToTable(
                request('year'),
                request('month'),
                request('date'),
                Encryption::decode(request('id'))['student_study_course_id'],
                request('absent')
            );
        }
        //event(new Attendances($response));

        return  $response;
    }

    public function qrcode()
    {
        $response = array();
        $qrcode = QRHelper::decrypt(request()->post('code'), 'fc', true);
        $nodeId   = $qrcode['id'];
        $nodeType = $qrcode['type'];

        if ($nodeType === Students::$path['role']) {
            $node = StudentsStudyCourse::getData($nodeId)['data'];
        }
        $exp = Carbon::createFromDate($qrcode['exp']);
        $now = Carbon::now();
        $diff = $exp->diffInDays($now);
        if ($diff > 0) {
            $exists = StudentsAttendances::existsToTable(Years::now(),  Months::now(), date('d'), $nodeId);

            if ($exists) {
                if (in_array($exists->attendance_type_id, [2])) {
                    $response = StudentsAttendances::updateToTable(Years::now(), Months::now(), date('d'), $nodeId, 1);
                } else {
                    $response = array(
                        'success'   => false,
                        'data'      => $node,
                        'type'      => 'exists',
                        'sound'     => asset('assets/sounds/' . app()->getLocale() . '/your_presence_is_already_exists.mp3'),
                        'message'   => Translator::phrase('already_exists'),
                    );
                }
            } else {
                $response = StudentsAttendances::addToTable(Years::now(), Months::now(), date('d'), $nodeId, 1);
            }
        } else {
            $response = array(
                'success'   => false,
                'data'      => $node,
                'type'      => 'expired',
                'sound'     => asset('assets/sounds/' . app()->getLocale() . '/your_qrcode_is_expired.mp3'),
                'message'   => Translator::phrase('qrcode_expired'),
            );
        };

        return  $response;
    }

    public function scan($data)
    {
        $data['view']      = StudentsAttendances::$path['view'] . '.includes.scan.index';
        return $data;
    }

    public function report($data)
    {
        $data['formData']['node_type'] = request('type');
        $data['holiday']   = Holidays::getHoliday(request('year'), request('month'))['data'];
        $data['response']  = StudentsAttendances::getData(request('year'), request('month'), null, request('id'));
        $data['view']      = StudentsAttendances::$path['view'] . '.includes.report.index';
        $data['title']     = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . $data['formName'] . '.');
        return $data;
    }
}
