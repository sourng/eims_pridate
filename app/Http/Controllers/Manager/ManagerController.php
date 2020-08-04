<?php

namespace App\Http\Controllers\Manager;

use App\Models\App;
use App\Models\Quiz;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Students;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\ActivityFeed;
use App\Models\SocailsMedia;
use App\Models\StudyPrograms;
use App\Models\StaffInstitutes;
use App\Models\StudyCourseSession;
use App\Models\StudentsStudyCourse;
use App\Models\StudyCourseSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Study\StudyController;
use App\Http\Controllers\users\usersController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\ActivityFeed\ActivityFeedController;
use App\Models\StudentsRequest;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
        if (Auth::user()) {
            request()->merge([
                'instituteId' => Auth::user()->institute_id,
                'institute'   => Auth::user()->institute_id,
            ]);
        }
    }

    public function index($param1 = null, $param2 = null, $param3 = null, $param4 = null, $param5 = null, $param6 = null)
    {

        if (strtolower($param1) == null || strtolower($param1) == 'dashboard') {
            return $this->dashboard();
        } elseif (strtolower($param1) == ActivityFeed::$path['url']) {
            $view = new ActivityFeedController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == Staff::$path['url']) {
            $view = new StaffController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == Students::$path['url']) {
            $view = new StudentController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == 'study') {
            $view = new StudyController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == 'general') {
            $view = new GeneralController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == Users::$path['url']) {
            $view = new UsersController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == App::$path['url']) {
            $view = new SettingsController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == 'profile') {
            $view = new ProfileController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == Quiz::$path['url']) {
            $view = new QuizController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } else {
            abort(404);
        }
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
            'parent'     => "Manager",
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
                'gender'      => Students::gender(Students::where('institute_id',Auth::user()->institute_id)),
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

        $studyPrograms = StudyPrograms::getData();
        $data['studyProgram'] = [];
        if ($studyPrograms['success']) {
            foreach ($studyPrograms['data'] as $row) {
                $data['studyProgram'][] = [
                    'title'   => $row['name'],
                    'link'    => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list?programId=' . $row['id']),
                    'icon'    => null,
                    'image'   => $row['image'],
                    'gender'  => Students::gender(
                        StudentsStudyCourse::join((new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.study_course_session_id')
                            ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', '=', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
                            ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
                            ->whereNotIn('study_status_id', [7])
                            ->where((new StudyCourseSchedule())->getTable().'.study_program_id', $row['id'])
                            ->where((new StudyCourseSchedule())->getTable() . '.institute_id', Auth::user()->institute_id)
                    ),
                    'status'  => [], // StudentsStudyCourse::studyStatus(StudentsStudyCourse::join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_id')->where('institute_id', Auth::user()->institute_id)->where('study_program_id', $row['id'])),
                    'color'   => config('app.theme_color.name'),
                ];
            }
        }


        $data['users'] = Users::getData(null, null, 10);
        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }
}
