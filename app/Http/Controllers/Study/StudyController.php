<?php

namespace App\Http\Controllers\Study;

use App\Models\App;
use App\Models\Users;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\StudyClass;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\CourseTypes;
use App\Models\StudyCourse;
use App\Models\StudyStatus;
use App\Models\SocailsMedia;
use App\Models\StudyFaculty;
use App\Models\StudySession;
use App\Models\StudyModality;
use App\Models\StudyPrograms;
use App\Models\StudySubjects;
use App\Models\StudySemesters;
use App\Models\AttendancesType;
use App\Models\StudyGeneration;
use App\Models\CurriculumAuthor;
use App\Models\StudyOverallFund;
use App\Models\StudyAcademicYears;
use App\Models\StudyCourseSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CurriculumEndorsement;
use App\Http\Controllers\Study\InstituteController;
use App\Http\Controllers\Study\CourseTypeController;
use App\Http\Controllers\Study\StudyCourseController;
use App\Http\Controllers\Study\StudyStatusController;
use App\Http\Controllers\Study\StudyFacultyController;
use App\Http\Controllers\Study\StudyProgramController;
use App\Http\Controllers\Study\StudySessionController;
use App\Http\Controllers\Study\StudyModalityController;
use App\Http\Controllers\Study\StudySemesterController;
use App\Http\Controllers\Study\StudyGenerationController;
use App\Http\Controllers\Study\CurriculumAuthorController;
use App\Http\Controllers\Study\StudyOverallFundController;
use App\Http\Controllers\Study\StudyAcademicYearController;
use App\Http\Controllers\Study\StudyCourseScheduleController;
use App\Http\Controllers\Study\CurriculumEndorsementController;
use App\Models\StudyCourseRoutine;
use App\Models\StudyCourseSession;
use App\Models\StudyGrade;
use App\Models\StudyShortCourseSchedule;
use App\Models\StudyShortCourseSession;
use App\Models\StudySubjectLesson;

class StudyController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }


    public function index($param1 = null, $param2 = null, $param3 = null)
    {

        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName']   = 'Study';
        $data['formAction'] = '/add';
        $data['listData']   = array();


        if ($param1 == null) {

            $data['shortcuts'] = [
                [
                    'title' => null,
                    'children' => [
                        [
                            'name'  => Translator::phrase('list.institute'),
                            'link'  => url(Users::role() . '/study/' . Institute::$path['url'] . '/list'),
                            'icon'  => 'fas fa-school',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                        [
                            'name'  => Translator::phrase('list.study_program'),
                            'link'  => url(Users::role() . '/study/' . StudyPrograms::$path['url'] . '/list'),
                            'icon'  => 'fas fa-graduation-cap',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.study_course'),
                            'link'  => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/list'),
                            'icon'  => 'fas fa-user-hard-hat',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.course_type'),
                            'link'  => url(Users::role() . '/study/' . CourseTypes::$path['url'] . '/list'),
                            'icon'  => 'fas fa-hard-hat',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                        [
                            'name'  => Translator::phrase('list.study_generation'),
                            'link'  => url(Users::role() . '/study/' . StudyGeneration::$path['url'] . '/list'),
                            'icon'  => null,
                            'text'  => Translator::phrase('study_generation'),
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.study_academic_year'),
                            'link'  => url(Users::role() . '/study/' . StudyAcademicYears::$path['url'] . '/list'),
                            'icon'  => null,
                            'text'  => Translator::phrase('study_academic_year'),
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.study_semester'),
                            'link'  => url(Users::role() . '/study/' . StudySemesters::$path['url'] . '/list'),
                            'icon'  => null,
                            'text'  => Translator::phrase('study_semester'),
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ]
                    ]
                ],
                [
                    'title' => null,
                    'children'  => [
                        [
                            'name'  => Translator::phrase('list.study_session'),
                            'link'  => url(Users::role() . '/study/' . StudySession::$path['url'] . '/list'),
                            'icon'  => 'fas fa-hourglass-start',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                        [
                            'name'  => Translator::phrase('list.study_class'),
                            'link'  => url(Users::role() . '/study/' . StudyClass::$path['url'] . '/list'),
                            'icon'  => null,
                            'text'  => Translator::phrase('study_class'),
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                    ]
                ],

                [
                    'title' => Translator::phrase('study_course_schedule'),
                    'children'  => [
                        [
                            'name'  => Translator::phrase('list.study_course_schedule'),
                            'link'  => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/list'),
                            'icon'  => 'fas fa-calendar-alt',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                       [
                            'name'  => Translator::phrase('list.study_course_session'),
                            'link'  => url(Users::role() . '/study/' . StudyCourseSession::$path['url'] . '/list'),
                            'icon'  => 'fas fa-table',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.study_course_routine'),
                            'link'  => url(Users::role() . '/study/' . StudyCourseRoutine::$path['url'] . '/list'),
                            'icon'  => 'fal fa-table',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ]
                    ]
                ],
                [
                    'title' => Translator::phrase('short_course_schedule'),
                    'children'  => [
                        [
                            'name'  => Translator::phrase('list.short_course_schedule'),
                            'link'  => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/list'),
                            'icon'  => 'fas fa-calendar-alt',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                       [
                            'name'  => Translator::phrase('list.short_course_session'),
                            'link'  => url(Users::role() . '/study/' . StudyShortCourseSession::$path['url'] . '/list'),
                            'icon'  => 'fas fa-table',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                    ]
                ],
                [
                    'title' => Translator::phrase('study_subject'),
                    'children'  => [
                        [
                            'name'  => Translator::phrase('list.study_subject'),
                            'link'  => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/list'),
                            'icon'  => 'fas fa-books',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                        [
                            'name'  => Translator::phrase('list.study_subject_lesson'),
                            'link'  => url(Users::role() . '/study/' . StudySubjectLesson::$path['url'] . '/list'),
                            'icon'  => 'fas fa-book-alt',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                    ]
                ],
                [
                    'title' => null,
                    'children'  => [
                        [
                            'name'  => Translator::phrase('list.study_modality'),
                            'link'  => url(Users::role() . '/study/' . StudyModality::$path['url'] . '/list'),
                            'icon'  => 'fas fa-chalkboard',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.study_overall_fund'),
                            'link'  => url(Users::role() . '/study/' . StudyOverallFund::$path['url'] . '/list'),
                            'icon'  => 'fas fa-donate',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.study_faculty'),
                            'link'  => url(Users::role() . '/study/' . StudyFaculty::$path['url'] . '/list'),
                            'icon'  => 'fas fa-industry-alt',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.study_status'),
                            'link'  => url(Users::role() . '/study/' . StudyStatus::$path['url'] . '/list'),
                            'icon'  => 'fas fa-question-square',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],  [
                            'name'  => Translator::phrase('list.curriculum_author'),
                            'link'  => url(Users::role() . '/study/' . CurriculumAuthor::$path['url'] . '/list'),
                            'icon'  => 'fas fa-book-user',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ], [
                            'name'  => Translator::phrase('list.curriculum_endorsement'),
                            'link'  => url(Users::role() . '/study/' . CurriculumEndorsement::$path['url'] . '/list'),
                            'icon'  => 'fas fa-people-carry',
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],
                        [
                            'name'  => Translator::phrase('list.study_grade'),
                            'link'  => url(Users::role() . '/study/' . StudyGrade::$path['url'] . '/list'),
                            'icon'  => null,
                            'text'  => Translator::phrase('study_grade'),
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ],  [
                            'name'  => Translator::phrase('list.attendance_type'),
                            'link'  => url(Users::role() . '/study/' . AttendancesType::$path['url'] . '/list'),
                            'icon'  => null,
                            'text'  => Translator::phrase('attendance_type'),
                            'image' => null,
                            'color' => 'bg-' . config('app.theme_color.name'),
                        ]
                    ]
                ]

            ];

            if (Auth::user()->role_id != 1) {
                unset($data['shortcuts'][0]['children'][0]);
            }


            $data['view']  = 'Study.includes.dashboard.index';
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        } elseif (strtolower($param1) == StudyPrograms::$path['url']) {
            $view = new StudyProgramController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == Institute::$path['url'] && Auth::user()->role_id == 1) {
            $view = new InstituteController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyCourse::$path['url']) {
            $view = new StudyCourseController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == CourseTypes::$path['url']) {
            $view = new CourseTypeController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyCourseSchedule::$path['url']) {
            $view = new StudyCourseScheduleController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyCourseSession::$path['url']) {
            $view = new StudyCourseSessionController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyCourseRoutine::$path['url']) {
            $view = new StudyCourseRoutineController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyModality::$path['url']) {
            $view = new StudyModalityController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyOverallFund::$path['url']) {
            $view = new StudyOverallFundController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyFaculty::$path['url']) {
            $view = new StudyFacultyController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyGeneration::$path['url']) {
            $view = new StudyGenerationController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyAcademicYears::$path['url']) {
            $view = new StudyAcademicYearController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudySemesters::$path['url']) {
            $view = new StudySemesterController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyStatus::$path['url']) {
            $view = new StudyStatusController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudySession::$path['url']) {
            $view = new StudySessionController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == CurriculumAuthor::$path['url']) {
            $view = new CurriculumAuthorController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == CurriculumEndorsement::$path['url']) {
            $view = new CurriculumEndorsementController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudySubjects::$path['url']) {
            $view = new StudySubjectController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudySubjectLesson::$path['url']) {
            $view = new StudySubjectLessonController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyClass::$path['url']) {
            $view = new StudyClassController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == AttendancesType::$path['url']) {
            $view = new AttendanceTypeController();
            return $view->index($param2, $param3);
        } elseif (strtolower($param1) == StudyGrade::$path['url']) {
            $view = new StudyGradeController();
            return $view->index($param2, $param3);

        } elseif (strtolower($param1) == StudyShortCourseSchedule::$path['url']) {
            $view = new StudyShortCourseScheduleController;
            return $view->index($param2, $param3);

        } elseif (strtolower($param1) == StudyShortCourseSession::$path['url']) {
            $view = new StudyShortCourseSessionController;
            return $view->index($param2, $param3);
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
            'parent'     => 'Study',
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
}
