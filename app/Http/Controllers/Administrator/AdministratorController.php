<?php

namespace App\Http\Controllers\Administrator;

use App\Models\App;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Students;
use App\Models\Institute;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\ActivityFeed;
use App\Models\SocailsMedia;
use App\Models\StudyPrograms;
use App\Models\StaffInstitutes;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Study\StudyController;
use App\Http\Controllers\users\usersController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Settings\SettingsController;
use App\Http\Controllers\ActivityFeed\ActivityFeedController;
use App\Http\Controllers\Mailbox\MailboxController;
use App\Http\Controllers\Quiz\QuizController;
use App\Models\Mailbox;
use App\Models\Quiz;
use App\Models\StudentsRequest;
use App\Models\StudyCourseSchedule;
use App\Models\StudyCourseSession;


class AdministratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = null, $param2 = null, $param3 = null, $param4 = null, $param5 = null, $param6 = null)
    {
        if (strtolower($param1) == null || strtolower($param1) == 'dashboard') {
            return $this->dashboard();
        } elseif (strtolower($param1) == ActivityFeed::$path['url']) {
            $view = new ActivityFeedController();
            return $view->index($param2, $param3, $param4, $param5, $param6);
        } elseif (strtolower($param1) == Mailbox::$path['url']) {
            $view = new MailboxController();
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
        $data['formAction'] = 'feed/post';
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
            'parent'     => "Administrator",
            'view'       => Users::role('view_path') . ".includes.dashboard.index",
        );

        $institute = Institute::getData();

        $data['staff'] = array(
            [
                'title'   => Translator::phrase('staff. & .teacher'),
                'link'    => url(Users::role() . '/' . Staff::$path['url'] . '/list'),
                'icon'    => 'fas fa-chalkboard-teacher',
                'image'   => null,
                'gender'  => Staff::gender(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable() . '.id', '=', (new StaffInstitutes())->getTable() . '.staff_id')->whereNotIn('staff_status_id', [1, 4])),
                'status'  => [], //Staff::staffStatus(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable().'.id', '=', (new StaffInstitutes())->getTable().'.staff_id')),
                'color'   => 'blue',
            ],
        );

        if ($institute['success']) {
            foreach ($institute['data'] as $row) {
                $data['staff'][] = [
                    'title'   => $row['name'],
                    'link'    => url(Users::role() . '/' . Staff::$path['url'] . '/list?instituteId=' . $row['id']),
                    'text'    => Translator::phrase('staff. & .teacher'),
                    'icon'    => 'fas fa-chalkboard-teacher',
                    'image'   => $row['image'],
                    'gender'  => Staff::gender(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable() . '.id', '=', (new StaffInstitutes())->getTable() . '.staff_id')->whereNotIn('staff_status_id', [1, 4])->where('institute_id', $row['id'])),
                    'status'  => [], //Staff::staffStatus(Staff::join((new StaffInstitutes())->getTable(), (new Staff())->getTable().'.id', '=', (new StaffInstitutes())->getTable().'.staff_id')->where('institute_id',$row['id'])),
                    'color'   => 'blue',
                ];
            }
        }

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
                'gender'      => Students::gender(StudentsStudyCourse::join( (new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                                    ->join( (new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')->whereNotIn('study_status_id', [7])),
                'status'      => [], //StudentsStudyCourse::studyStatus(StudentsStudyCourse::join((new Students())->getTable(), (new Students())->getTable().'.id', '=', (new StudentsStudyCourse())->getTable().'.student_id')),
                'color'       => 'green',
            ],
        );

        if ($institute['success']) {
            foreach ($institute['data'] as $row) {
                $data['student'][] = [
                    'title'   => $row['name'],
                    'link'    => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list?instituteId=' . $row['id']),
                    'text'    => Translator::phrase('student_study_course'),
                    'icon'    => 'fas fa-user-graduate',
                    'image'   => $row['image'],
                    'gender'  => Students::gender(
                        StudentsStudyCourse::join( (new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.study_course_session_id')
                        ->join( (new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', '=', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
                        ->join( (new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                        ->join( (new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
                        ->whereNotIn('study_status_id', [7])
                        ->where((new StudyCourseSchedule())->getTable().'.institute_id', $row['id'])),
                    'status'  => [], //StudentsStudyCourse::studyStatus(StudentsStudyCourse::join((new Students())->getTable(), (new Students())->getTable().'.id', '=', (new StudentsStudyCourse())->getTable().'.student_id')->where('institute_id',$row['id'])),
                    'color'   => 'green',
                ];
            }
        }

        $studyPrograms = StudyPrograms::getData();
        if ($studyPrograms['success']) {
            foreach ($studyPrograms['data'] as $row) {
                $data['studyProgram'][] = [
                    'title'   => $row['name'],
                    'link'    => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list?programId=' . $row['id']),
                    'icon'    => null,
                    'image'   => $row['image'],
                    'gender'  => Students::gender(
                        StudentsStudyCourse::join( (new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.study_course_session_id')
                        ->join( (new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', '=', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
                        ->join( (new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                        ->join( (new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
                        ->whereNotIn('study_status_id', [7])
                        ->where((new StudyCourseSchedule())->getTable().'.study_program_id', $row['id'])),
                    'status'  => [],//StudentsStudyCourse::studyStatus(StudentsStudyCourse::join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_id')->where('study_program_id', $row['id'])),
                    'color'   => config('app.theme_color.name'),
                ];
            }
        }
        $data['response'] =  ActivityFeed::getData(null, true);
        $data['users'] = Users::getData(null, null, 10);
        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }
}
