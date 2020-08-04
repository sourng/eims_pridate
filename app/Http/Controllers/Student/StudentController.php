<?php

namespace App\Http\Controllers\Student;

use App\Models\App;
use App\Models\Days;
use App\Models\Quiz;
use App\Models\Roles;
use App\Models\Users;
use App\Models\Years;
use App\Models\Gender;
use App\Models\Months;
use App\Models\Mailbox;
use App\Models\Marital;
use App\Models\Communes;
use App\Models\Holidays;
use App\Models\Students;
use App\Models\Villages;
use App\Models\Districts;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\Provinces;
use App\Models\BloodGroup;
use App\Models\CardFrames;
use App\Models\MotherTong;
use App\Models\StudyClass;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\Nationality;
use App\Models\QuizStudent;
use App\Models\StudyCourse;
use App\Models\ActivityFeed;
use App\Models\SocailsMedia;
use App\Models\StudySession;
use App\Models\StudyPrograms;
use App\Models\StudySubjects;
use App\Models\StudySemesters;
use App\Models\AttendancesType;
use App\Models\StudentsRequest;
use App\Models\StudyGeneration;
use App\Models\CertificateFrames;
use App\Models\QuizStudentAnswer;
use App\Models\StudyAcademicYears;
use App\Models\StudyCourseRoutine;
use App\Models\StudyCourseSession;
use App\Http\Requests\FormStudents;
use App\Models\StudentsAttendances;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentsStudyCourseScore;
use App\Models\StudentsStudyShortCourse;
use App\Http\Requests\FormStudentsRequest;
use App\Models\StudentsShortCourseRequest;
use App\Http\Requests\FormQuizStudentAnswer;
use App\Http\Controllers\Card\CardController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\Mailbox\MailboxController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Requests\FormStudentsShortCourseRequest;
use App\Http\Controllers\Quiz\QuizStudentAnswerController;
use App\Http\Controllers\Certificate\CertificateController;
use App\Http\Controllers\ActivityFeed\ActivityFeedController;
use App\Http\Controllers\Student\StudentsStudyCourseController;
use App\Http\Controllers\Student\StudentsShortCourseRequestController;

class StudentController extends Controller
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
        

        if (Auth::user()->role_id != 6) {
            $data['institute']            = Institute::getData();
            $data['blood_group']         = BloodGroup::getData();
            $data['mother_tong']         = MotherTong::getData();
            $data['gender']              = Gender::getData();
            $data['nationality']         = Nationality::getData();
            $data['marital']             = Marital::getData();
            $data['provinces']           = Provinces::getData();
            $data['districts']           = Districts::getData('null', 'null');
            $data['communes']            = Communes::getData('null', 'null');
            $data['villages']            = Villages::getData('null', 'null');
            $data['curr_districts']      = Districts::getData('null', 'null');
            $data['curr_communes']       = Communes::getData('null', 'null');
            $data['curr_villages']       = Villages::getData('null', 'null');
        }
        $data['formAction']          = '/add';
        $data['formName']            = Students::$path['url'];
        $data['title']               = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']           = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']            = url(Users::role() . '/' . $param1);
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['listData']            = array();

        if (Auth::user()->role_id == 6) {
            if (strtolower($param1)  == null) {
                $data = $this->dashboard($data);
            } elseif (strtolower($param1)  == 'dashboard') {
                $data = $this->dashboard($data);
            } elseif (strtolower($param1)  == 'study') {
                return $this->study($param2, $param3, $param4, $param5, $param6);
            } elseif (strtolower($param1)  == 'general') {
                if (request()->method() == 'GET') {
                    return $this->general($param2, $param3, $param4, $param5);
                } else {
                    abort(404);
                }
            } elseif (strtolower($param1)  == 'profile') {
                $view = new ProfileController();
                return $view->index($param2, $param3, $param4);
            } elseif (strtolower($param1)  == Users::$path['url']) {
                return Users::getData(null, null, 10, request('search'));
            } elseif (strtolower($param1)  == ActivityFeed::$path['url']) {
                $view = new ActivityFeedController();
                return $view->index($param2, $param3, $param4);
            } elseif (strtolower($param1)  == Mailbox::$path['url']) {
                $view = new MailboxController();
                return $view->index($param2, $param3, $param4);
            } else {
                abort(404);
            }
        } else {
            if (strtolower($param1)  == null) {
                $data['shortcuts'] = [
                    [
                        'title' => null,
                        'children'  => [
                            [
                                'name'  => Translator::phrase('add.student'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/add'),
                                'icon'  => 'fas fa-user-plus',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                            [
                                'name'  => Translator::phrase('add.student.short_form'),
                                'link'  => url('student-register'),
                                'target' => '_blank',
                                'icon'  => 'fas fa-user-plus',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.student.all'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/list'),
                                'icon'  => 'fas fa-users-class',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.card'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/list'),
                                'icon'  => 'fas fa-id-card',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.certificate'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/list'),
                                'icon'  => 'fas fa-file-certificate',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                        ]
                    ],
                    [
                        'title' => Translator::phrase('long_course'),
                        'children' => [
                            [
                                'name'  => Translator::phrase('list.student_study_course'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list'),
                                'icon'  => 'fas fa-user-graduate',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.request_study'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsRequest::$path['url'] . '/list'),
                                'icon'  => 'fas fa-users-medical',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.student.attendance'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . StudentsAttendances::$path['url'] . '/list'),
                                'icon'  => 'fas fa-calendar-edit',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.student.score'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . StudentsStudyCourseScore::$path['url'] . '/list'),
                                'icon'  => 'fas fa-trophy-alt',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                        ]
                    ],
                    [
                        'title' => Translator::phrase('short_course'),
                        'children' => [
                            [
                                'name'  => Translator::phrase('list.student'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/list'),
                                'icon'  => 'fas fa-user-graduate',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.student.request_study'),
                                'link'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'] . '/list'),
                                'icon'  => 'fas fa-users-medical',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                        ]
                    ]
                ];


                $data['view']  = Students::$path['view'] . '.includes.dashboardAdmin.index';
                $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
            } elseif (strtolower($param1)  == 'list') {
                if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {

                    return  Students::getData(null, null, 10, request('search'));
                } else {
                    $data = $this->list($data);
                }
            } elseif (strtolower($param1) == 'list-datatable') {
                if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                    return  Students::getDataTable();
                } else {
                    $data = $this->list($data);
                }
            } elseif (strtolower($param1)  == 'add') {
                if (request()->method() === 'POST') {
                    return Students::addToTable();
                }
                $data = $this->add($data);
            } elseif (strtolower($param1)  == 'view') {
                if ($param2) {
                    $data = $this->show($data, $param2, $param1);
                    $data['view']  = Students::$path['view'] . '.includes.view.index';
                } else {
                    $data = $this->list($data);
                }
            } elseif (strtolower($param1)  == 'print') {
                if ($param2) {
                    $data['response'] = Students::getData($param2, true);
                    $data['view']  = Students::$path['view'] . '.includes.print.index';
                } else {
                    $data = $this->list($data);
                }
            } elseif (strtolower($param1)  == 'edit') {
                if ($param2) {
                    if (request()->method() === 'POST') {
                        return Students::updateToTable($param2);
                    }
                    $data = $this->show($data, $param2, $param1);
                } else {
                    $data = $this->list($data);
                }
            } elseif (strtolower($param1)  == 'delete') {
                $id = request('id', $param2);
                return Students::deleteFromTable($id);
            } elseif (strtolower($param1) == 'account') {
                $id = request('id', $param3);
                if ($param2 == 'create') {
                    if (request()->method() == "POST") {
                        return Students::createAccountToTable($id);
                    }

                    $data =  $this->account($data, $id, $param2);
                }
            } elseif (strtolower($param1)  == StudentsStudyCourse::$path['url']) {
                $student = new StudentsStudyCourseController();
                return $student->index($param2, $param3, $param4);
            } elseif (strtolower($param1)  == StudentsRequest::$path['url']) {
                $student = new StudentsRequestController();
                return $student->index($param2, $param3, $param4);
            } elseif (strtolower($param1) == CardFrames::$path['url']) {
                $view = new CardController();
                return $view->index($param2, $param3, $param4, $param5, $param6);
            } elseif (strtolower($param1) == CertificateFrames::$path['url']) {
                $view = new CertificateController();
                return $view->index($param2, $param3, $param4, $param5, $param6);
            } elseif (strtolower($param1) == StudentsStudyShortCourse::$path['url']) {
                $view = new StudentsStudyShortCourseController();
                return $view->index($param2, $param3, $param4, $param5, $param6);
            } elseif (strtolower($param1) == StudentsShortCourseRequest::$path['url']) {
                $view = new StudentsShortCourseRequestController();
                return $view->index($param2, $param3, $param4, $param5, $param6);
            } else {
                abort(404);
            }
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
            'parent'     => Students::$path['view'],
            'modal'      => Students::$path['view'] . '.includes.modal.index',
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormStudents::rulesField(),
            'attributes'  =>  FormStudents::attributeField(),
            'messages'    =>  FormStudents::customMessages(),
            'questions'   =>  FormStudents::questionField(),
        ];

        if (Auth::user()->role_id && $param1 == 'dashboard' || $param1 == null) {
            $pages['form']['validate'] = [
                'rules'       =>  FormQuizStudentAnswer::rulesField(),
                'attributes'  =>  FormQuizStudentAnswer::attributeField(),
                'messages'    =>  FormQuizStudentAnswer::customMessages(),
                'questions'   =>  FormQuizStudentAnswer::questionField(),
            ];
        }

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);

        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {

        $student = Students::orderBy('id', 'DESC');
        if (request('instituteId')) {
            $student = $student->where('institute_id', request('instituteId'));
        }
        $data['response'] = [
            'gender'      => Students::gender($student)
        ];
        $data['view']  = Students::$path['view'] . '.includes.list.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . $data['formName']);
        return $data;
    }

    public function add($data)
    {
        $data['view']  = Students::$path['view'] . '.includes.form.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.' . $data['formName']);
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');
        return $data;
    }

    public function account($data, $id, $type)
    {
        $response           = Students::getData($id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/account/' . $type . '/' . $response['data'][0]['id'];
        $data['view']       = Students::$path['view'] . '.includes.account.index';

        return $data;
    }

    public function show($data, $id, $type)
    {
        $response           = Students::getData($id, true);
        $data['view']       = Students::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.' . $data['formName']);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/' . $type . '/' . $id;
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . $data['formAction']);
        $pob                = $data['formData']['place_of_birth'];
        $cur                = $data['formData']['current_resident'];
        $data['blood_group']         = BloodGroup::getData();
        $data['mother_tong']         = MotherTong::getData();
        $data['gender']              = Gender::getData();
        $data['nationality']         = Nationality::getData();
        $data['marital']             = Marital::getData();

        if ($pob['province']) {
            $data['districts'] = Districts::getData($pob['province']['id']);
        }
        if ($pob['district']) {
            $data['communes'] = Communes::getData($pob['district']['id']);
        }
        if ($pob['commune']) {
            $data['villages'] = Villages::getData($pob['commune']['id']);
        }

        if ($cur['province']) {
            $data['curr_districts'] = Districts::getData($cur['province']['id']);
        }
        if ($cur['district']) {
            $data['curr_communes'] = Communes::getData($cur['district']['id']);
        }
        if ($cur['commune']) {
            $data['curr_villages'] = Villages::getData($cur['commune']['id']);
        }


        return $data;
    }

    public function dashboard($data)
    {
        $data['days']                  = Days::getData();
        $data['institute']            = Institute::getData(request('instituteId', 'null'));
        $data['study_program']        = StudyPrograms::getData(request('programId', 'null'));
        $data['study_course']         = StudyCourse::getData(request('courseId', 'null'));
        $data['study_generation']     = StudyGeneration::getData(request('generationId', 'null'));
        $data['study_academic_year']  = StudyAcademicYears::getData(request('yearId', 'null'));
        $data['study_semester']       = StudySemesters::getData(request('semesterId', 'null'));
        $data['study_session']        = StudySession::getData(request('sessionId', 'null'));
        $data['study_class']          = StudyClass::getData(request('classId', 'null'));

        $data['months']               = Months::getData();
        $data['attendances_type']     = AttendancesType::getData();
        $data['formAction']          = '/add';
        $data['formName']            = Students::$path['url'];
        $data['metaImage']           = asset('assets/img/icons/add.png');
        $data['metaLink']            = url(Users::role() . '/add');
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['listData']            = array();
        request()->merge([
            'year'  => request('year', Years::now()),
            'month' => request('month', Months::now()),
        ]);

        $data['study_course_session'] = null;
        if (Auth::user()->node_id) {
            $student_study_course = StudentsStudyCourse::select((new StudentsStudyCourse())->getTable() . '.*')->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
                ->where((new StudentsRequest())->getTable() . '.student_id', Auth::user()->node_id)
                ->latest((new StudentsStudyCourse())->getTable() . '.id')
                ->first();
            if ($student_study_course) {
                $data['study_course_session'] = StudyCourseSession::getData($student_study_course->study_course_session_id);
                $data['study_course_session']['data'][0]['schedules'] = StudyCourseRoutine::getData($student_study_course->study_course_session_id)['data'];
                $data['study_course_session']['data'][0]['score'] = StudentsStudyCourseScore::getData(null, null, null, $student_study_course->id);
                $data['study_course_session']['data'][0]['attendances'] = StudentsAttendances::getData(null, null, null, $student_study_course->id);
                $data['study_course_session']['data'][0]['holiday'] = Holidays::getHoliday(request('year'), request('month'), $student_study_course->study_course_session_id)['data'];
            }
        }
        $quiz = new QuizStudentAnswerController;
        $quiz = $quiz->list(['formName' => null])['response'];
        $data['quiz'] = $quiz;
        $data['formName'] = 'study/' . Quiz::$path['url'] . '/' . QuizStudentAnswer::$path['url'];

        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .dashboard');
        $data['view']    = Students::$path['view'] . '.includes.dashboard.index';

        return  $data;
    } // End dashboard

    public function study($param1 = null, $param2 = null, $param3 = null, $param4 = null)
    {


        $data['study_course_session'] = StudentsStudyCourse::getStudy(Auth::user()->node_id);
        $data['course_routine'] = StudentsStudyCourse::join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', (new StudentsRequest())->getTable() . '.student_id')
            ->where((new StudentsRequest())->getTable() . '.student_id', Auth::user()->node_id)
            ->latest('study_course_session_id')
            ->first();

        if ($data['course_routine']) {
            request()->merge([
                'course-sessionId' => request('course-sessionId', $data['course_routine']->study_course_session_id),
            ]);
        }

        $data['formAction']          = '/add';
        $data['formName']            = 'study';
        $data['metaImage']           = asset('assets/img/icons/add.png');
        $data['metaLink']            = url(Users::role() . '/add');
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['institute']         = Institute::getData();
        $data['study_program']     = StudyPrograms::getData();
        $data['study_course']      = StudyCourse::getData();
        $data['study_generation']  = StudyGeneration::getData();
        $data['study_academic_year']  = StudyAcademicYears::getData();
        $data['study_semester']       = StudySemesters::getData();
        $data['study_session']       = StudySession::getData();

        $data['listData']            = array();

        if (strtolower($param1)  == null) {
            if (Auth::user()->node_id) {
                $data['shortcuts'] = [
                    [
                        'title' => null,
                        'children'  => [
                            [
                                'name'  => Translator::phrase('edit.register'),
                                'link'  => url(Users::role() . '/study/edit'),
                                'icon'  => 'fas fa-user-edit',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                            [
                                'name'  => Translator::phrase('list.quiz'),
                                'link'  => url(Users::role() . '/study/' . Quiz::$path['url'] . '/list'),
                                'icon'  => 'fas fa-question-circle',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                        ]
                    ],
                    [
                        'title' => Translator::phrase('long_course'),
                        'children'  => [

                            [
                                'name'  => Translator::phrase('study_course'),
                                'link'  => url(Users::role() . '/study/'.str_replace('request','approved',StudentsRequest::$path['url']).'/list'),
                                'icon'  => 'fas fa-user-graduate',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                            [
                                'name'  => Translator::phrase('request_study'),
                                'link'  => url(Users::role() . '/study/' . StudentsRequest::$path['url'] . '/list'),
                                'icon'  => 'fas fa-layer-plus',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.schedule'),
                                'link'  => url(Users::role() . '/study/schedule/list'),
                                'icon'  => 'fas fa-calendar-alt',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.attendance'),
                                'link'  => url(Users::role() . '/study/' . StudentsAttendances::$path['url'] . '/list'),
                                'icon'  => 'fas fa-calendar-edit',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ], [
                                'name'  => Translator::phrase('list.score'),
                                'link'  => url(Users::role() . '/study/' . StudentsStudyCourseScore::$path['url'] . '/list'),
                                'icon'  => 'fas fa-trophy-alt',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                        ]
                    ],
                    [
                        'title' => Translator::phrase('short_course'),
                        'children'  => [

                            [
                                'name'  => Translator::phrase('study_course'),
                                'link'  => url(Users::role() . '/study/' . str_replace('request', 'approved', StudentsShortCourseRequest::$path['url']) . '/list'),
                                'icon'  => 'fas fa-user-graduate',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                            [
                                'name'  => Translator::phrase('request_study'),
                                'link'  => url(Users::role() . '/study/' . StudentsShortCourseRequest::$path['url'] . '/list'),
                                'icon'  => 'fas fa-layer-plus',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                        ]
                    ]
                ];
            } else {
                $data['shortcuts'] = [
                    [
                        'title' => null,
                        'children'  => [
                            [
                                'name'  => Translator::phrase('register'),
                                'link'  => url(Users::role() . '/study/register'),
                                'icon'  => 'fas fa-user-plus',
                                'image' => null,
                                'color' => 'bg-' . config('app.theme_color.name'),
                            ],
                        ]
                    ]

                ];
            }
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .study');
            $data['view']  = Students::$path['view'] . '.includes.study.includes.dashboard.index';
        } elseif (strtolower($param1) == 'register') {
            $data['mother_tong']         = MotherTong::getData();
            $data['blood_group']         = BloodGroup::getData();
            $data['gender']              = Gender::getData();
            $data['nationality']         = Nationality::getData();
            $data['marital']             = Marital::getData();
            $data['provinces']           = Provinces::getData();
            $data['districts']           = Districts::getData('null', 'null');
            $data['communes']            = Communes::getData('null', 'null');
            $data['villages']            = Villages::getData('null', 'null');
            $data['curr_districts']      = Districts::getData('null', 'null');
            $data['curr_communes']       = Communes::getData('null', 'null');
            $data['curr_villages']       = Villages::getData('null', 'null');
            $data = $this->add($data);
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .register');
        } elseif (strtolower($param1) == 'edit') {
            $data['provinces']           = Provinces::getData();
            $data['districts']           = Districts::getData('null', 'null');
            $data['communes']            = Communes::getData('null', 'null');
            $data['villages']            = Villages::getData('null', 'null');
            $data['curr_districts']      = Districts::getData('null', 'null');
            $data['curr_communes']       = Communes::getData('null', 'null');
            $data['curr_villages']       = Villages::getData('null', 'null');
            if (request()->method() == 'POST') {
                $id = $param2 ? $param2 : request('id');
                return Students::updateToTable($id);
            } else {
                $data = $this->show($data, Auth::user()->node_id, 'edit');
                $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit');
            }
        } elseif (strtolower($param1) == str_replace('request','approved',StudentsRequest::$path['url'])) {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudentsStudyCourse::getStudy(Auth::user()->node_id);
            } else {
                $data['formName']            = 'study/' . StudentsRequest::$path['url'];

                if (strtolower($param2) == 'list' || strtolower($param2) == null) {
                    $data['studys'] = StudentsStudyCourse::getStudy(Auth::user()->node_id);
                    $data['response']  = StudentsRequest::getData(null, Auth::user()->node_id, 10);
                    $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.approved.and.request_study');
                    $data['view']    = Students::$path['view'] . '.includes.study.includes.course.list.index';
                } else {
                    abort(404);
                }
            }
        } elseif (strtolower($param1) == StudentsRequest::$path['url']) {
            $data['formName'] .= '/' . StudentsRequest::$path['url'];

            if (strtolower($param2) == 'list' || strtolower($param2) == null) {
                $data['response']  = StudentsRequest::getData(null, Auth::user()->node_id, 10);
                $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .request');
                $data['view']    = Students::$path['view'] . '.includes.study.includes.requesting.list.index';
            } elseif (strtolower($param2) == 'add') {
                if (request()->method() == 'POST') {
                    request()->merge([
                        'student' => [Auth::user()->node_id]
                    ]);
                    return StudentsRequest::addToTable();
                } else {
                    $data['title']   = Translator::phrase(Users::role(app()->getLocale()) . '. | .course');
                    $data['view']    = Students::$path['view'] . '.includes.study.includes.requesting.form.index';
                }
            } elseif (strtolower($param2) == 'edit') {
                if (request()->method() == 'POST') {
                    return StudentsRequest::updateToTable(request('id', $param3));
                } else {
                    $data['formAction']          = '/edit';
                    request()->merge([
                        'ref'   => Students::$path['url'] . '-' . StudentsRequest::$path['url']
                    ]);
                    $data['title']   = Translator::phrase(Users::role(app()->getLocale()) . '. | .course');
                    $data['view']    = Students::$path['view'] . '.includes.study.includes.requesting.form.index';
                    $response  = StudentsRequest::getData(request('id', $param3));

                    $data['formData'] = $response['data'][0];
                    $data['listData'] = $response['pages']['listData'];
                    $data['institute']         = Institute::getData();
                    $data['study_program']     = StudyPrograms::getData();
                    $data['study_course']      = StudyCourse::getData();
                    $data['study_generation']  = StudyGeneration::getData();
                    $data['study_academic_year']  = StudyAcademicYears::getData();
                    $data['study_semester']       = StudySemesters::getData();
                    $data['study_session']       = StudySession::getData();
                }
            } elseif (strtolower($param2) == 'delete') {
                return StudentsRequest::deleteFromTable(request('id', $param3));
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == str_replace('request','approved',StudentsShortCourseRequest::$path['url'])) {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  StudentsStudyShortCourse::getStudy(Auth::user()->node_id);
            } else {
                $data['formName']            = 'study/' . StudentsShortCourseRequest::$path['url'];


                if (strtolower($param2) == 'list' || strtolower($param2) == null) {
                    $data['studys'] = StudentsStudyShortCourse::getStudy(Auth::user()->node_id);
                    $data['response']  = StudentsShortCourseRequest::getData(null, Auth::user()->node_id, 10);



                    $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.short_course.approved.and.request_study');
                    $data['view']    = Students::$path['view'] . '.includes.study.includes.short_course.list.index';
                } else {
                    abort(404);
                }
            }
        } elseif (strtolower($param1) == StudentsShortCourseRequest::$path['url']) {
            $data['formName'] .= '/' . StudentsShortCourseRequest::$path['url'];

            if (strtolower($param2) == 'list' || strtolower($param2) == null) {
                $data['response']  = StudentsShortCourseRequest::getData(null, Auth::user()->node_id, 10);
                $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .short_course_request');
                $data['view']    = Students::$path['view'] . '.includes.study.includes.short_course_requesting.list.index';
            }elseif(strtolower($param2) == 'list-datatable'){
                if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                    request()->merge([
                        'ref'   => Students::$path['url'].'-'. StudentsShortCourseRequest::$path['url'],
                    ]);
                    return  StudentsShortCourseRequest::getDataTable(Auth::user()->node_id);
                }
            } elseif (strtolower($param2) == 'add') {
                request()->merge([
                    'ref'   => Students::$path['url'] . '-' . StudentsShortCourseRequest::$path['url'],
                    'courseTId' => 1,
                ]);
                if (request()->method() == 'POST') {
                    request()->merge([
                        'student' => [Auth::user()->node_id]
                    ]);
                    return StudentsShortCourseRequest::addToTable();
                } else {
                    $data['title']   = Translator::phrase(Users::role(app()->getLocale()) . '. | .course');
                    $data['view']    = Students::$path['view'] . '.includes.study.includes.short_course_requesting.form.index';
                    $data['study_subject']       = StudySubjects::getData();
                }
            } elseif (strtolower($param2) == 'edit') {
                if (request()->method() == 'POST') {
                    return StudentsShortCourseRequest::updateToTable(request('id', $param3));
                } else {
                    $data['formAction']          = '/edit';

                    $data['title']   = Translator::phrase(Users::role(app()->getLocale()) . '. | .course');
                    $data['view']    = Students::$path['view'] . '.includes.study.includes.short_course_requesting.form.index';
                    $response  = StudentsShortCourseRequest::getData(request('id', $param3));

                    $data['formData'] = $response['data'][0];
                    $data['listData'] = $response['pages']['listData'];
                    $data['institute']         = Institute::getData();
                    $data['study_subject']       = StudySubjects::getData();
                    $data['study_session']       = StudySession::getData();
                }
            } elseif (strtolower($param2) == 'delete') {
                return StudentsShortCourseRequest::deleteFromTable(request('id', $param3));
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == 'schedule') {
            if ($data['course_routine']) {
                $data['days']                  = Days::getData();
                $data['response'] = StudyCourseRoutine::getData(request('course-sessionId', $data['course_routine']->study_course_session_id));
                $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .schedule');
                $data['view']  = Students::$path['view'] . '.includes.study.includes.schedule.index';
            } else {
                abort(404);
            }
        } elseif (strtolower($param1) == StudentsAttendances::$path['url']) {
            $data['months']               = Months::getData();
            $data['attendances_type']     = AttendancesType::getData();
            $data = $this->attendance($data);
            $data['view']    = Students::$path['view'] . '.includes.study.includes.attendance.index';
        } elseif (strtolower($param1) == Quiz::$path['url']) {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                $course_routine = StudentsStudyCourse::select((new QuizStudent())->getTable() . '.*')
                    ->join((new QuizStudent())->getTable(), (new QuizStudent())->getTable() . '.student_study_course_id', '=', (new StudentsStudyCourse())->getTable() . '.id')
                    ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
                    ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
                    ->where('student_id', Auth::user()->node_id)
                    ->get()->toArray();
                if ($course_routine) {
                    $quiz_id = [];
                    foreach ($course_routine as $key => $row) {
                        $quiz_id[] = $row['quiz_id'];
                    }
                    return Quiz::getData(request('quizId', $quiz_id));
                }
            } else {
                $view = new QuizStudentAnswerController();
                return $view->index($param2, $param3, $param4);
            }
        } elseif (strtolower($param1) == StudentsStudyCourseScore::$path['url']) {
            $data = $this->score($data);
            $data['view']    = Students::$path['view'] . '.includes.study.includes.score.index';
        } elseif (strtolower($param1) == Institute::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return Institute::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == StudyPrograms::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return StudyPrograms::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == StudyCourse::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return StudyCourse::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == StudyGeneration::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return StudyGeneration::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == StudyAcademicYears::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return StudyAcademicYears::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == StudySemesters::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return StudySemesters::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == StudySession::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return StudySession::getData(null, null, 10);
            }
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
            'parent'     => Students::$path['view'],
            'modal'      => Students::$path['view'] . '.includes.modal.index',
            'view'       => $data['view'],
        );

        if (strtolower($param1) == StudentsRequest::$path['url']) {
            $pages['form']['validate'] = [
                'rules'       =>  FormStudentsRequest::rulesField(),
                'attributes'  =>  FormStudentsRequest::attributeField(),
                'messages'    =>  FormStudentsRequest::customMessages(),
                'questions'   =>  FormStudentsRequest::questionField(),
            ];

        }elseif (strtolower($param1) == StudentsShortCourseRequest::$path['url']) {
            $pages['form']['validate'] = [
                'rules'       =>  FormStudentsShortCourseRequest::rulesField(),
                'attributes'  =>  FormStudentsShortCourseRequest::attributeField(),
                'messages'    =>  FormStudentsShortCourseRequest::customMessages(),
                'questions'   =>  FormStudentsShortCourseRequest::questionField(),
            ];
        } else {
            $pages['form']['validate'] = [
                'rules'       =>  FormStudents::rulesField(),
                'attributes'  =>  FormStudents::attributeField(),
                'messages'    =>  FormStudents::customMessages(),
                'questions'   =>  FormStudents::questionField(),
            ];
        }

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function attendance($data)
    {

        if ($data['course_routine']) {
            $monthYear =  request('month_year') ? explode('-', request('month_year')) : null;
            request()->merge([
                'course-sessionId' => request('course-sessionId', $data['course_routine']->study_course_session_id),
                'year'             => $monthYear ? $monthYear[1] : Years::now(),
                'month'            => $monthYear ? $monthYear[0] : Months::now(),
                'date'             => request('date') ? request('date') : date('d'),
                'type'             => Students::$path['role'],
            ]);
            $data['study_course_session'] = StudyCourseSession::getData(request('course-sessionId', $data['course_routine']->study_course_session_id), null, 10);
        }

        $view = new StudentsAttendanceController();
        return $view->list($data);
    }
    public function score($data)
    {

        if ($data['course_routine']) {
            request()->merge([
                'course-sessionId' => request('course-sessionId', $data['course_routine']->study_course_session_id),
                'type'           => Students::$path['role'],
            ]);
        }
        $view = new StudentsStudyCourseScoreController();
        return $view->list($data);
    }

    public function general($param1 = null, $param2 = null, $param3 = null, $param4 = null)
    {
        $view = new GeneralController();
        if ($param1 != null) {
            return $view->index($param1, $param2, $param3, $param4);
        } else {
            abort(404);
        }
    }
}
