<?php

namespace App\Http\Controllers\Department;

use App\Models\App;
use App\Models\Quiz;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Years;
use App\Models\Gender;
use App\Models\Marital;
use App\Models\Communes;
use App\Models\Students;
use App\Models\Villages;
use App\Models\Districts;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\Provinces;
use App\Models\BloodGroup;
use App\Models\MotherTong;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\Nationality;
use App\Models\ActivityFeed;
use App\Models\SocailsMedia;
use App\Models\StudyPrograms;
use App\Models\StaffInstitutes;
use App\Models\StudentsRequest;
use App\Http\Requests\FormStaff;
use App\Models\StaffDesignations;
use App\Models\StaffTeachSubject;
use App\Models\StudyCourseSession;
use App\Models\StudentsStudyCourse;
use App\Models\StudyCourseSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Study\StudyController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\ActivityFeed\ActivityFeedController;
use App\Http\Controllers\Teacher\TeacherController;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }
    public function index($param1 = null, $param2 = null, $param3 = null, $param4 = null, $param5 = null)
    {

        $data['institute']           = Institute::getData(request('instituteId', 'null'));
        $data['designation']         = StaffDesignations::getData(request('designationId', 'null'));
        $data['mother_tong']         = MotherTong::getData();
        $data['gender']              = Gender::getData();
        $data['nationality']         = Nationality::getData();
        $data['marital']             = Marital::getData();
        $data['blood_group']         = BloodGroup::getData();
        $data['provinces']           = Provinces::getData();
        $data['districts']           = Districts::getData('null');
        $data['communes']            = Communes::getData('null');
        $data['villages']            = Villages::getData('null');
        $data['curr_districts']      = Districts::getData('null');
        $data['curr_communes']       = Communes::getData('null');
        $data['curr_villages']       = Villages::getData('null');

        request()->merge([
            'institute'    => Auth::user()->institute_id,
            'instituteId' => Auth::user()->institute_id,
            'DepartmentId' => Auth::user()->node_id,
            'Department' => Auth::user()->node_id,
        ]);

        $data['formAction']          = '/add';
        $data['formName']            = Staff::$path['url'];
        $data['title']               = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']           = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']            = url(Users::role() . '/' . $param1);
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['listData']            = array();

        if (strtolower($param1)  == null) {
            return $this->dashboard($data);
        } elseif (strtolower($param1)  == 'dashboard') {
            return $this->dashboard($data);
        } elseif (strtolower($param1)  == ActivityFeed::$path['url']) {
            $view = new ActivityFeedController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1) == Quiz::$path['url']) {
            $view = new QuizController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1) == Staff::$path['url']) {
            $view = new StaffController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1) == Students::$path['url']) {
            $view = new StudentController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1)  == 'study') {
            $view = new StudyController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1)  == 'profile') {
            $view = new ProfileController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1)  == 'myclass') {
            $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .myclass');
            $data['response']   = Staff::getClassTeaching(Auth::user()->node_id);
            $data['view']       = Users::role('view_path') . '.includes.myclass.index';
        } elseif (strtolower($param1)  == 'teaching') {
            $view = new TeacherController;
            return $view->teaching($param2,$param3,$param4);
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
            'parent'     => Users::role('view_path'),
            'modal'      => Users::role('view_path') . '.includes.modal.index',
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormStaff::rulesField(),
            'attributes'  =>  FormStaff::attributeField(),
            'messages'    =>  FormStaff::customMessages(),
            'questions'   =>  FormStaff::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function dashboard()
    {
        $data['title'] = Translator::phrase("dashboard");
        $data['formData'] = null;
        $data['formName'] = null;
        $data['formAction'] = null;
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
                'param1' => null,
                'param2' => null,
                'param3' => null,
            ),
            'search'     => parse_url(request()->getUri(), PHP_URL_QUERY) ? '?' . parse_url(request()->getUri(), PHP_URL_QUERY) : '',
            'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction']),
            'parent'     => Users::role('view_path'),
            'view'       => Users::role('view_path') . ".includes.dashboard.index",
        );



        $data['staff'] = array(
            [
                'title'   => Translator::phrase('staff. & .teacher'),
                'link'    => url(Users::role() . '/' . Staff::$path['url'] . '/list'),
                'icon'    => 'fas fa-chalkboard-teacher',
                'image'   => null,
                'gender'  => Staff::gender(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable() . '.id', '=', (new StaffInstitutes())->getTable() . '.staff_id')->whereNotIn('staff_status_id', [1, 4])->whereNotIn('designation_id', [1])->where('institute_id', Auth::user()->institute_id)),
                'status'  => [], //Staff::staffStatus(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable().'.id', '=', (new StaffInstitutes())->getTable().'.staff_id')),
                'color'   => 'blue',
            ],
            [
                'title'   => Translator::phrase('teacher'),
                'link'    => url(Users::role() . '/' . Staff::$path['url'] . '/list'),
                'icon'    => 'fas fa-chalkboard-teacher',
                'image'   => null,
                'gender'  => Staff::gender(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable() . '.id', '=', (new StaffInstitutes())->getTable() . '.staff_id')->whereNotIn('staff_status_id', [1, 4])->where('designation_id', 2)->where('institute_id', Auth::user()->institute_id)),
                'status'  => [], //Staff::staffStatus(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable().'.id', '=', (new StaffInstitutes())->getTable().'.staff_id')),
                'color'   => 'blue',
            ],
        );

        $data['student'] = array(
            [
                'title'       => Translator::phrase('student.all'),
                'link'        => url(Users::role() . '/' . Students::$path['url'] . '/list'),
                'icon'        => 'fas fa-user-graduate',
                'image'       => null,
                'gender'      => Students::gender(new Students),
                'status'      => [],
                'color'       => 'green',
            ],
            [
                'title'       => Translator::phrase('student_study_course'),
                'link'        => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list'),
                'icon'        => 'fas fa-user-graduate',
                'image'       => null,
                'gender'  => Students::gender(
                    StudentsStudyCourse::join((new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.study_course_session_id')
                        ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', '=', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
                        ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                        ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
                        ->whereNotIn('study_status_id', [7])
                        ->where((new StudyCourseSchedule())->getTable() . '.institute_id', Auth::user()->institute_id)
                ),
                'status'      => [], //StudentsStudyCourse::studyStatus(StudentsStudyCourse::join((new Students())->getTable(), (new Students())->getTable().'.id', '=', (new StudentsStudyCourse())->getTable().'.student_id')),
                'color'       => 'green',
            ],
        );

        $data['current_subjects'] = StaffTeachSubject::getTeachSubjects(request('t-subjectId'), Auth::user()->node_id, null, 10, true, Years::now());


        $data['users'] = Users::getData(null, null, 10);
        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }
}
