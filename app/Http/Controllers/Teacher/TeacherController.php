<?php

namespace App\Http\Controllers\Teacher;

use App\Models\App;
use App\Models\Days;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Years;
use App\Models\Gender;
use App\Models\Months;
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
use App\Helpers\ImageHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\Nationality;
use App\Models\StaffStatus;
use App\Models\SocailsMedia;
use App\Models\StudentsScore;
use App\Models\AttendancesType;
use App\Http\Requests\FormStaff;
use App\Models\StaffCertificate;
use App\Models\StaffDesignations;
use App\Models\StudyCourseRoutine;
use App\Models\StudyCourseSession;
use App\Http\Requests\FormStudents;
use App\Models\StudentsAttendances;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FormStudentsScore;
use App\Models\StudentsStudyCourseScore;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Student\StudentsAttendanceController;
use App\Http\Controllers\Student\StudentsStudyCourseController;
use App\Http\Requests\FormStudySubjectLesson;
use App\Models\Quiz;
use App\Models\StaffTeachSubject;
use App\Models\StudySubjectLesson;
use App\Models\StudySubjects;

class TeacherController extends Controller
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
            'teacherId' => Auth::user()->node_id,
            'teacher' => Auth::user()->node_id,
        ]);

        $data['formAction']          = '/add';
        $data['formName']            = Students::$path['url'];
        $data['title']               = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']           = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']            = url(Users::role() . '/' . $param1);
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['listData']            = array();

        if (strtolower($param1)  == null) {
            $data = $this->dashboard($data);
        } elseif (strtolower($param1)  == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  Students::getData(null, null, 10);
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
        } elseif (strtolower($param1)  == 'dashboard') {
            $data = $this->dashboard($data);
        } elseif (strtolower($param1) == Quiz::$path['url']) {
            $view = new QuizController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1)  == 'teaching') {
            return $this->teaching($param2, $param3, $param4);
        } elseif (strtolower($param1)  == 'general') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return $this->general($param2, $param3, $param4, $param5);
            } else {
                abort(404);
            }
        } elseif (strtolower($param1)  == 'profile') {
            $view = new ProfileController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1)  == 'myclass') {
            $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .myclass');
            $data['response']    = Staff::getClassTeaching(Auth::user()->node_id);
            $data['view']       = 'Teacher.includes.myclass.index';
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
            'parent'     => 'Teacher',
            'modal'      => Students::$path['view'] . '.includes.modal.index',
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

    public function show($data, $id, $type)
    {


        if($id){
            $response           = staff::getData($id, true);
            $data['formData']   = $response['data'][0];
            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/' . $type . '/' . $id;

            $pob                = $data['formData']['place_of_birth'];
            $cur                = $data['formData']['current_resident'];

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
        }

        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.' . $data['formName']);
        $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
        $data['metaLink']   = url(Users::role() . $data['formAction']);
        $data['mother_tong'] = MotherTong::getData();
        $data['gender']      = Gender::getData();
        $data['nationality'] = Nationality::getData();
        $data['marital']     = Marital::getData();


        return $data;
    }



    public function dashboard($data)

    {
        $data['months']               = Months::getData();
        $data['attendances_type']     = AttendancesType::getData();
        $data['formAction']          = '/add';
        $data['formName']            = Staff::$path['url'];
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
        $data['current_subjects'] = StaffTeachSubject::getTeachSubjects(request('t-subjectId'), Auth::user()->node_id, null, 10, true, Years::now());
        //dd($data['current_subjects']);
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .dashboard');
        $data['view']    = 'Teacher.includes.dashboard.index';

        return  $data;
    } // End dashboard



    public function teaching($param1 = null, $param2 = null, $param3 = null)

    {
        $data['study_course_session'] = Staff::getTeaching(Auth::user()->node_id);
        $data['course_routine'] = StudyCourseRoutine::where('teacher_id', Auth::user()->node_id)
            ->groupBy('study_course_session_id')
            ->latest('study_course_session_id')
            ->first();
        if ($data['course_routine']) {
            request()->merge([
                'course-sessionId' => request('course-sessionId', $data['course_routine']->study_course_session_id),
            ]);
        }

        $data['formAction']          = '/add';
        $data['formName']            = 'teaching';
        $data['metaImage']           = asset('assets/img/icons/add.png');
        $data['metaLink']            = url(Users::role() . '/add');
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['listData']            = array();

        if (strtolower($param1)  == null) {
            $data['shortcut'] = [
                [
                    'name'  => Auth::user()->node_id ?  Translator::phrase('edit.register') :  Translator::phrase('register'),
                    'link'  => url(Users::role() .  (Auth::user()->node_id ? '/teaching/edit' : '/teaching/register')),
                    'icon'  => Auth::user()->node_id ? 'fas fa-user-edit' : 'fas fa-user-plus',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('subject'),
                    'link'  => url(Users::role() . '/teaching/' . StaffTeachSubject::$path['url'] . '/list'),
                    'icon'  => 'fas fa-books',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.schedule'),
                    'link'  => url(Users::role() . '/teaching/schedule/list'),
                    'icon'  => 'fas fa-calendar-alt',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],
                [
                    'name'  => Translator::phrase('list.attendance'),
                    'link'  => url(Users::role() . '/teaching/' . StudentsAttendances::$path['url'] . '/list'),
                    'icon'  => 'fas fa-calendar-edit',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.score'),
                    'link'  => url(Users::role() . '/teaching/' . StudentsStudyCourseScore::$path['url'] . '/list'),
                    'icon'  => 'fas fa-trophy-alt',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],
            ];
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .dashboard');
            $data['view']  = 'Teacher.includes.teaching.index';
        } elseif (strtolower($param1) == 'register') {
            $data['mother_tong']         = MotherTong::getData('null');
            $data['gender']              = Gender::getData('null');
            $data['nationality']         = Nationality::getData('null');
            $data['marital']             = Marital::getData('null');
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
            $view = new StaffController;
            $data['institute']           = Institute::getData(Auth::user()->institute_id);
            $data['status']              = StaffStatus::getData();
            $data['designation']         = StaffDesignations::getData();
            $data['mother_tong']         = MotherTong::getData();
            $data['gender']              = Gender::getData();
            $data['nationality']         = Nationality::getData();
            $data['marital']             = Marital::getData();
            $data['blood_group']         = BloodGroup::getData();
            $data['provinces']           = Provinces::getData();
            $data['districts']           = Districts::getData('null');
            $data['communes']            = Communes::getData('null');
            $data['villages']            = Villages::getData('null');
            $data['staff_certificate']   = StaffCertificate::getData();
            $data['curr_districts']      = $data['districts'];
            $data['curr_communes']       = $data['communes'];
            $data['curr_villages']       = $data['villages'];
            $data = $view->show($data, Auth::user()->node_id, 'edit');
            $data['view']       = 'Teacher.includes.form.includes.edit.index';
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit');
        } elseif (strtolower($param1) == StaffTeachSubject::$path['url']) {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return StaffTeachSubject::getTeachSubjects(null, Auth::user()->node_id, null, 10, false);
            } else {
                $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .subject');
                $data['response'] = StaffTeachSubject::getTeachSubjects(null, Auth::user()->node_id);
                $data['view']    = 'Teacher.includes.teaching.includes.subject.index';
            }
        } elseif (strtolower($param1) == StudySubjectLesson::$path['url']) {
            $data['staff_teach_subject']['data'] = StaffTeachSubject::where('staff_id', Auth::user()->node_id)->get(['id','study_subject_id'])->map(function ($row) {
                $study_subject = StudySubjects::where('id', $row['study_subject_id'])->first([app()->getLocale() . ' as name', 'image']);
                return [
                    'id'    => $row['id'],
                    'name'  => $study_subject->name,
                    'image'  => $study_subject->image? ImageHelper::site(StudySubjects::$path['image'], $study_subject->image) : ImageHelper::prefix(),
                ];
            })->toArray();

            $data['formName']            = 'teaching/' . StudySubjectLesson::$path['url'];
            $data['formData'] = array(
                'image' => asset('/assets/img/icons/pdf.png'),
            );
            if ($param2 == 'add') {
                if (request()->method() == 'POST') {
                    return StudySubjectLesson::addToTable();
                }

                $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .subject.&.lesson');
                $data['view']    = 'Teacher.includes.form.includes.lesson.index';
            } elseif ($param2 == 'edit') {
                $id = request('id', $param3);
                if (request()->method() == 'POST') {
                    return StudySubjectLesson::updateToTable($id);
                }
                $id = request('id', $param3);
                $response = StudySubjectLesson::getData($id);
                $data['formData']   = $response['data'][0];
                $data['formAction']          = '/edit/' . $response['data'][0]['id'];
                $data['listData']   = $response['pages']['listData'];
                //$data['staff_teach_subject'] = StaffTeachSubject::getTeachSubjects($response['data'][0]['staff_teach_subject'], Auth::user()->node_id, null, true, false);


                $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit.lesson');
                $data['view']    = 'Teacher.includes.form.includes.lesson.index';
            } elseif ($param2 == 'view') {
                $data['formAction']          = '/view';
                $id = request('id', $param3);
                $response = StudySubjectLesson::getData($id);
                $data['formData']   = $response['data'][0];
                $data['listData']   = $response['pages']['listData'];

                $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .view.lesson');
                $data['view']    = 'Teacher.includes.form.includes.lesson.index';
            } elseif ($param2 == 'list-datatable') {
                if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                    return StudySubjectLesson::getDataTable();
                }
            } else {
                $staff_teach_subject_id = request('t-subjectId', $param3);

                $data['response'] = StudySubjectLesson::getData(null, $staff_teach_subject_id, 10);
                $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .subject.&.lesson');
                $data['view']     = 'Teacher.includes.teaching.includes.lesson.includes.list.index';
                if ($param2 == 'grid') {
                    $data['view']     = 'Teacher.includes.teaching.includes.lesson.includes.grid.index';
                }
            }
        } elseif (strtolower($param1) == 'schedule') {
            $data['days']   = Days::getData();
            $course_routine = StudyCourseRoutine::where('teacher_id', Auth::user()->node_id)->groupBy('study_course_session_id')->get()->toArray();
            if ($course_routine) {
                $study_course_session_id = [];
                foreach ($course_routine as $key => $value) {
                    $study_course_session_id[] = $value['study_course_session_id'];
                }
                $data['response'] = StudyCourseRoutine::getData($study_course_session_id);
            } else {
                $data['response'] = [
                    'success'   => false,
                    'message'   => Translator::phrase('no_data')
                ];
            }
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.schedule');
            $data['view']    = 'Teacher.includes.teaching.includes.schedule.index';
        } elseif (strtolower($param1) == StudentsAttendances::$path['url']) {

            $data['months']               = Months::getData();
            $data['attendances_type']     = AttendancesType::getData();
            $course_routine = StudyCourseRoutine::where('teacher_id', Auth::user()->node_id)->groupBy('study_course_session_id')->get()->toArray();
            $study_course_session_id = [];
            foreach ($course_routine as $key => $value) {
                $study_course_session_id[] = $value['study_course_session_id'];
            }
            $data['routine'] = StudyCourseRoutine::getData(request('course-sessionId', 'null'));

            $monthYear =  request('month_year') ? explode('-', request('month_year')) : null;
            request()->merge([
                'year'           => $monthYear ? $monthYear[1] : Years::now(), 'month'          => $monthYear ? $monthYear[0] : Months::now(), 'date'           => request('date') ? request('date') : date('d'),
            ]);



            $view = new StudentsAttendanceController();
            $data =  $view->list($data);
            $data['view']    = 'Teacher.includes.teaching.includes.attendance.index';
        } elseif (strtolower($param1) == StudentsStudyCourseScore::$path['url']) {
            $data['student'] = StudentsStudyCourse::getData('null');
            $id = request('id', $param3);
            $data['metaImage']  = asset('assets/img/icons/register.png');
            $data['metaLink']   = url(Users::role() . '/edit/' . $id);

            if ($param2 == null || $param2 == 'list') {
                $data['response'] = StudentsStudyCourseScore::getData(null, null, 10);
                $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Student_score');
                $data['view']    = 'Teacher.includes.teaching.includes.score.index';
                $data['formAction'] = '/score/add/';
            } elseif ($param2 == 'edit') {
                if (request()->method() == 'POST') {
                    if (request('study_subject')) {
                        $update = null;
                        foreach (request('study_subject') as $key => $value) {
                            $update = StudentsScore::addToTable($id, $key, $value);
                        }
                        return $update;
                    }
                } else {
                    $response = StudentsStudyCourseScore::getData($id);
                    if ($response['success']) {
                        $data['student'] = StudentsStudyCourse::getData($response['data'][0]['node']['id']);
                    }
                    $data['formData']   = $response['data'][0];
                    $data['listData']   = $response['pages']['listData'];
                    $data['formAction'] = '/score/edit/' . $response['data'][0]['id'];
                    $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Student_score');
                    $data['view']    = 'Teacher.includes.form.includes.score.index';
                }
            }
        } elseif (strtolower($param1) == Institute::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                return Institute::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == Quiz::$path['url']) {

            if (request()->ajax() && request()->method() == 'GET') {
                return Quiz::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == StudyCourseSession::$path['url']) {
            if (request()->ajax() && request()->method() == 'GET') {
                $course_routine = StudyCourseRoutine::where('teacher_id', Auth::user()->node_id)->groupBy('study_course_session_id')->get()->toArray();
                if ($course_routine) {
                    $study_course_session_id = [];
                    foreach ($course_routine as $key => $value) {
                        $study_course_session_id[] = $value['study_course_session_id'];
                    }
                    return StudyCourseSession::getData($study_course_session_id, null, 10);
                }
                return StudyCourseSession::getData(null, null, 10);
            }
        } elseif (strtolower($param1) == Students::$path['url']) {
            if (strtolower($param2)  == StudentsStudyCourse::$path['url']) {
                $student = new StudentsStudyCourseController();
                return $student->index($param3);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }



        MetaHelper::setConfig(
            [
                'title'       => $data['title'], 'author'      => config('app.name'), 'keywords'    => '', 'description' => '', 'link'        => $data['metaLink'], 'image'       => $data['metaImage']
            ]

        );



        $pages = array(
            'host'       => url('/'), 'path'       => '/' . Users::role(), 'pathview'   => '/' . $data['formName'] . '/', 'parameters' => array(
                'param1' => $param1, 'param2' => $param2, 'param3' => $param3,
            ), 'search'     => parse_url(request()->getUri(), PHP_URL_QUERY) ? '?' . parse_url(request()->getUri(), PHP_URL_QUERY) : '', 'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction']), 'parent'     => 'Teacher', 'modal'      => 'Teacher.includes.modal.index', 'view'       => $data['view'],

        );





        if ($param1 == 'score') {
            $pages['form']['validate'] = [
                'rules'       =>  FormStudentsScore::rulesField('.*'), 'attributes'  =>  FormStudentsScore::attributeField('.*'), 'messages'    =>  FormStudentsScore::customMessages(), 'questions'   =>  FormStudentsScore::questionField(),
            ];
        } elseif ($param1 == StudySubjectLesson::$path['url']) {
            $pages['form']['validate'] = [
                'rules'       =>  FormStudySubjectLesson::rulesField('.*'), 'attributes'  =>  FormStudySubjectLesson::attributeField('.*'), 'messages'    =>  FormStudySubjectLesson::customMessages(), 'questions'   =>  FormStudySubjectLesson::questionField(),
            ];
        } else {
            $pages['form']['validate'] = [
                'rules'       =>  FormStudents::rulesField(), 'attributes'  =>  FormStudents::attributeField(), 'messages'    =>  FormStudents::customMessages(), 'questions'   =>  FormStudents::questionField(),
            ];
        }
        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
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

    public function staff($param1 = null, $param2 = null, $param3 = null, $param4 = null)

    {

        $view = new StaffController();

        if ($param1 != null) {
            return $view->index($param1, $param2, $param3, $param4);
        } else {
            abort(404);
        }
    }
}
