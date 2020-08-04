<?php

namespace App\Models;

use DateTime;
use DomainException;
use App\Helpers\QRHelper;
use App\Helpers\Exception;
use App\Helpers\DateHelper;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStudentsStudyCourse;
use Illuminate\Support\Facades\Auth;

class StudentsStudyCourse extends Model
{
    public static $path = [
        'image'  => 'study-course',
        'url'    => 'study-course',
        'view'   => 'StudentsStudyCourse'
    ];



    public static function getData($id = null, $edit = null, $paginate = null)
    {

        $pages = array(
            'form' => array(
                'action'  => array(
                    'add'    => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/add/'),
                ),
            ),
            'listData' => array(),
        );




        $getCallMethods = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        if (class_basename($getCallMethods[1]['class']) == class_basename('StudentsStudyCourseController')) {
            $pages['form']['action']['add'] = $pages['form']['action']['add'] . '?ref=' . StudentsStudyCourse::$path['url'];
        } elseif (class_basename($getCallMethods[1]['class']) == class_basename('QuizStudentController')) {
            $pages['form']['action']['add'] = $pages['form']['action']['add'] . '?ref=' . Quiz::$path['url'];
        } elseif (class_basename($getCallMethods[1]['class']) == class_basename('StudentsStudyCourseScoreController')) {
            $pages['form']['action']['add'] = $pages['form']['action']['add'] . '?ref=' . StudentsStudyCourseScore::$path['url'];
        }

        if (Users::role('id') == 8) {
            $pages['form']['action']['add'] = str_replace(Students::$path['url'], 'teaching/' . Students::$path['url'], $pages['form']['action']['add']);
        }




        $orderBy = 'DESC';
        if ($id) {
            $id  =  gettype($id) == 'array' ? $id : explode(',', $id);
            $sorted = array_values($id);
            sort($sorted);
            if ($id === $sorted) {
                $orderBy = 'ASC';
            } else {
                $orderBy = 'DESC';
            }
        }

        $get = StudentsStudyCourse::select((new StudentsStudyCourse())->getTable() . '.*', (new Students())->getTable() . '.gender_id')
            ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
            ->join((new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.study_course_session_id')
            ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', '=', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
            ->join((new Institute())->getTable(), (new Institute())->getTable() . '.id', '=', (new StudyCourseSchedule())->getTable() . '.institute_id')
            ->orderBy((new StudentsStudyCourse())->getTable() . '.id', $orderBy);
        $gender =  Students::gender($get);
        $studyStatus = StudentsStudyCourse::studyStatus($get);
        if ($id) {
            $get = $get->whereIn((new StudentsStudyCourse())->getTable() . '.id', $id);
        } else {
            if (request('instituteId')) {
                $get = $get->where((new StudyCourseSchedule())->getTable() . '.institute_id', request('instituteId'));
            }
            if (request('programId')) {
                $get = $get->where((new StudyCourseSchedule())->getTable() . '.study_program_id', request('programId'));
            }

            if (request('course-sessionId')) {
                $get = $get->where('study_course_session_id', request('course-sessionId'));
            }


            if (request('statusId')) {
                $get = $get->where('study_status_id', request('statusId'));
            }
        }

        // if ($search) {
        //     if (is_numeric($search)) {
        //         $get = $get->where('id', 'LIKE', '%' . $search . '%');
        //     } else {
        //         $get = Students::searchName($get, $search);
        //     }
        // }

        if (gettype($edit) == 'string' && $edit == 'count') {
            return $get->count();
        } elseif (gettype($edit) == 'string' && $edit == 'origin') {

            return $get->get()->toArray();
        }

        if ($paginate) {
            $get = $get->paginate($paginate)->toArray();
            foreach ($get as $key => $value) {
                if ($key == 'data') {
                } else {
                    $pages[$key] = $value;
                }
            }

            $get = $get['data'];
        } else {
            $get = $get->get()->toArray();
        }



        if ($get) {

            foreach ($get as $key => $row) {

                $student_request = StudentsRequest::where('id', $row['student_request_id'])->first()->toArray();
                $student = Students::where('id', $student_request['student_id'])->first()->toArray();
                $node = [
                    'id'            => $student['id'],
                    'first_name'    => array_key_exists('first_name_' . app()->getLocale(), $student) ? $student['first_name_' . app()->getLocale()] : $student['first_name_en'],
                    'last_name'     => array_key_exists('last_name_' . app()->getLocale(), $student) ? $student['last_name_' . app()->getLocale()] : $student['last_name_en'],
                    '_fullname'     => $student['first_name_en'] . ' ' . $student['last_name_en'],
                    'date_of_birth' => DateHelper::convert($student['date_of_birth'], 'd-M-Y'),
                    '_date_of_birth' => DateHelper::convert($student['date_of_birth'], 'd-m-Y'),
                    'gender'    => $student['gender_id'] ? (Gender::getData($student['gender_id'])['data'][0]) : null,
                    'photo'     => ImageHelper::site(Students::$path['image'], $student['photo']),
                ];
                $account = Users::where('email', $student['email'])->where('node_id', $student['id'])->first();

                $data[$key] = [
                    'id'    => $row['id'],
                    'request_id'  => $row['student_request_id'],
                    'name'  => $student['first_name_km'] . ' ' . $student['last_name_km'] .' - '.$student['first_name_en'] . ' ' . $student['last_name_en'],
                    'study_course_session'    => $row['study_course_session_id'] == null ? null : StudyCourseSession::getData($row['study_course_session_id'])['data'][0],
                    'node'      =>  $node,
                    'photo' => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'], $row['photo'])) : $node['photo'],
                    'action' => [],

                ];


                if (request('ref') == Quiz::$path['url']) {

                    $data[$key]['name'] = $data[$key]['name'] . ' - ' . $data[$key]['study_course_session']['name'];
                } elseif (request('ref') == StudentsStudyCourseScore::$path['url']) {
                    $data[$key]['name'] = $data[$key]['name'] . ' - ' . $data[$key]['study_course_session']['name'];
                    $data[$key]['action']                   = [
                        'edit'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/edit/' . $row['id']),
                        'view'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/view/' . $row['id']),
                    ];
                } elseif (request('ref') == StudentsStudyCourse::$path['url']) {

                    $data[$key]['qrcode']  = $row['qrcode'] ? (ImageHelper::site(Students::$path['image'] . '/' . QRHelper::$path['image'], $row['qrcode'])) : null;
                    $data[$key]['card'] = $row['card'] ? (ImageHelper::site(Students::$path['image'] . '/' . CardFrames::$path['image'], $row['card'])) : null;
                    $data[$key]['study_status'] = $row['study_status_id'] == null ? null : StudyStatus::getData($row['study_status_id'])['data'][0];
                    $data[$key]['account']  = $account ? Users::getData($account->id)['data'][0] : null;
                    $data[$key]['action'] = [
                        'edit'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/edit/' . $row['id']),
                        'view'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/view/' . $row['id']),
                        'photo'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/photo/make/' . $row['id']),
                        'qrcode' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . QRHelper::$path['url'] . '/make/' . $row['id']),
                        'card'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . CardFrames::$path['url'] . '/make/' . $row['id']),
                        'certificate'=> url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . CertificateFrames::$path['url'] . '/make/' . $row['id']),
                        'account' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/account/create/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/delete/' . $row['id']),
                    ];
                } elseif (request('ref') == StudentsStudyCourse::$path['image'] . '-photo') {
                    $data[$key]['listImage'] = StudentsStudyCourse::getImage($row['student_request_id'])['data'];
                    $data[$key]['action'] = [
                        'photo'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/photo/make/' . $row['id']),
                    ];
                } elseif (request('ref') == StudentsStudyCourse::$path['image'] . '-qrcode') {
                    $data[$key]['qrcode'] = $row['qrcode'] ? (ImageHelper::site(Students::$path['image'] . '/' . QRHelper::$path['image'], $row['qrcode'])) : null;
                    $data[$key]['action'] = [
                        'qrcode' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . QRHelper::$path['url'] . '/make/' . $row['id']),
                    ];
                    $date = new DateTime();
                    $date->modify(request('expired', '+1 year'));
                    $qrcode  = QRHelper::encrypt([
                        'stuId'  => $row['student_request_id'],
                        'id'     => $row['id'],
                        'type'   => Students::$path['role'],
                        'exp'    => $date->format('Y-m-d'),
                    ], '?fc');
                    $data[$key]['qrcode_url']  = $qrcode;
                } elseif (request('ref') == StudentsStudyCourse::$path['image'] . '-card') {
                    $data[$key] = array(
                        'id'        => $data[$key]['id'],
                        'fullname'  => $student['first_name_km'] . ' ' . $student['last_name_km'],
                        '_fullname' => $data[$key]['node']['_fullname'],
                        'gender'    => $data[$key]['node']['gender']['name'],
                        'course'    => $data[$key]['study_course_session']['study_course_schedule']['study_course']['name'],
                        'dob'       => $data[$key]['node']['date_of_birth'],
                        'photo'     => $data[$key]['photo'].'?type=original',
                        'qrcode'    => $row['qrcode'] ? (ImageHelper::site(Students::$path['image'] . '/' . QRHelper::$path['image'], $row['qrcode'],'original')) : null,
                    );
                } elseif (request('ref') == StudentsStudyCourse::$path['image'] . '-certificate') {
                    $data[$key] = array(
                        'id'        => $data[$key]['id'],
                        'fullname'  => $student['first_name_km'] . ' ' . $student['last_name_km'],
                        '_fullname' => $data[$key]['node']['_fullname'],
                        'program'   => $data[$key]['study_course_session']['study_course_schedule']['study_program']['name'],
                        '_program'  => $data[$key]['study_course_session']['study_course_schedule']['study_program']['_name'],
                        'course'    => $data[$key]['study_course_session']['study_course_schedule']['study_course']['name'],
                        '_course'   => $data[$key]['study_course_session']['study_course_schedule']['study_course']['_name'],
                        'dob'       => $data[$key]['node']['date_of_birth'],
                        '_dob'      => $data[$key]['node']['_date_of_birth'],
                        'photo'     => $data[$key]['photo'].'?type=original',
                        'qrcode'    => $row['qrcode'] ? (ImageHelper::site(Students::$path['image'] . '/' . QRHelper::$path['image'], $row['qrcode'],'original')) : null,
                    );
                }



                // } else {
                //     foreach ($get as $key => $row) {

                //         $student = Students::getData($row['student_id'])['data'][0];

                //         $data[$key]                   = array(
                //             'id'                      => $row['id'],
                //             'nid'                     => $row['nid'],
                //             'name'                    => $student['first_name'] . ' ' . $student['last_name'],
                //             'node'                    => $student,
                //             'study_course_session'    => $row['study_course_session_id'] == null ? null : StudyCourseSession::getData($row['study_course_session_id'])['data'][0],
                //
                //             'photo'                   => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'], $row['photo'])) : $student['photo'],


                //         if (class_basename($getCallMethods[1]['class']) == class_basename('StudentsStudyCourseScoreController')) {
                //             $data[$key]['name'] = $data[$key]['name'] . ' - ' . $data[$key]['study_course_session']['name'];
                //         } else {

                //
                //             $data[$key] += array(
                //                 'qrcode'                  => $row['qrcode'] ? (ImageHelper::site(Students::$path['image'] . '/' . QRHelper::$path['image'], $row['qrcode'])) : null,
                //                 'card'                    => $row['card'] ? (ImageHelper::site(Students::$path['image'] . '/' . CardFrames::$path['image'], $row['card'])) : null,
                //                 'listImage'               => StudentsStudyCourse::getImage($row['student_request_id'])['data'],
                //                 'description'             => $row['description'],
                //                 'study_status'            => $row['study_status_id'] == null ? null : StudyStatus::getData($row['study_status_id'])['data'][0],
                //
                //             );


                //             if (in_array($row['study_status_id'], [2])) {
                //                 if ($row['created_at']) {
                //                     $created = Carbon::createFromDate($row['created_at']);
                //                     $created->addMonths(3);
                //                     $now = Carbon::now();
                //                     $diff = $created->diffInDays($now);
                //                     if ($diff > 90) {
                //                         if (StudentsStudyCourse::updateStudyStatus($row['id'], 3)) {
                //                             $data[$key]['study_status']  = StudyStatus::getData(3)['data'][0];
                //                         };
                //                     };
                //                 }
                //             };







                //             if (gettype($edit) == 'string' && $edit == 'card' || $edit == 'certificate') {
                //                 $data[$key]                   = array(
                //                     'id'                      => $data[$key]['id'],
                //                     'fullname'                => $data[$key]['name'],
                //                     '_fullname'               => $data[$key]['node']['_fullname'],
                //
                //
                //                     'gender'                  => $data[$key]['node']['gender']['name'],
                //                     'study_course_session'    => $data[$key]['study_course_session'],
                //                     'study_status'            => $data[$key]['study_status'],
                //                     'dob'                     => $data[$key]['node']['date_of_birth'],
                //                     '_dob'                    => $data[$key]['node']['date_of_birth'],

                //                 );
                //             } elseif (gettype($edit) == 'string' && $edit == 'attendance') {
                //                 $atten = StudentsAttendances::getAtten(request('year'), request('month'), $data[$key]['id'], request('date'));
                //                 $data[$key]                   = array(
                //                     'id'                      => $data[$key]['id'],
                //                     'fullname'                => $data[$key]['name'],
                //                     'photo'                   => $data[$key]['photo'],
                //                     'study_course_session'    => $data[$key]['study_course_session']['name'],
                //                     'date'                    => $atten['date'],
                //                     'total_p'                 => $atten['total_p'],
                //                     'total_a'                 => $atten['total_a'],
                //                     'total_all'               => $atten['total_p'] + $atten['total_a'],
                //                 );
                //             }
                //         }
                //     }

                if ((request('ref') != StudentsStudyCourse::$path['image'] . '-card') && (request('ref') != StudentsStudyCourse::$path['image'] . '-certificate')) {

                    $pages['listData'][] = array(
                        'id'     => $data[$key]['id'],
                        'name'   => $data[$key]['name'],
                        'image'  => $data[$key]['photo'],
                        'action' => $data[$key]['action'],
                    );
                }
            }

            $response       = array(
                'success'     => true,
                'data'        => $data,
                'gender'          => $gender,
                'studyStatus'     => $studyStatus,
                'pages'       => $pages
            );
        } else {
            $response = array(
                'success'         => false,
                'data'            => [],
                'pages'           => $pages,
                'message'         => Translator::phrase('no_data'),
                'gender'          => $gender,
                'studyStatus'     => $studyStatus,
            );
        }

        return $response;
    }

    public static function getDataTable()
    {
        $model = StudentsStudyCourse::select((new StudentsStudyCourse())->getTable() . '.*', (new Students())->getTable() . '.gender_id')
            ->join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
            ->join((new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.study_course_session_id')
            ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', '=', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
            ->join((new Institute())->getTable(), (new Institute())->getTable() . '.id', '=', (new StudyCourseSchedule())->getTable() . '.institute_id');

        return DataTables::eloquent($model)
            ->filter(function ($query) {

                if (Auth::user()->role_id == 2) {
                    $query =  $query->where((new StudyCourseSchedule())->getTable() . '.institute_id', Auth::user()->institute_id);
                }
                if (request('course-sessionId')) {
                    $query =  $query->where('study_course_session_id', request('course-sessionId'));
                }
                if (request('statusId')) {
                    $query =  $query->where('study_status_id', request('statusId'));
                }

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name') {
                                $query =  Students::searchName($query, request('search.value'));
                            }
                        }
                    }
                }

                return $query;
            })
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $student_request = StudentsRequest::where('id', $row['student_request_id'])->first()->toArray();
                $student = Students::where('id', $student_request['student_id'])->first()->toArray();
                $node = [
                    'id'            => $student['id'],
                    'first_name'    => array_key_exists('first_name_' . app()->getLocale(), $student) ? $student['first_name_' . app()->getLocale()] : $student['first_name_en'],
                    'last_name'     => array_key_exists('last_name_' . app()->getLocale(), $student) ? $student['last_name_' . app()->getLocale()] : $student['last_name_en'],
                    '_fullname'     => $student['first_name_en'] . ' ' . $student['last_name_en'],
                    'date_of_birth' => DateHelper::convert($student['date_of_birth'], 'd-M-Y'),
                    '_date_of_birth' => DateHelper::convert($student['date_of_birth'], 'd-m-Y'),
                    'gender'    => $student['gender_id'] ? (Gender::getData($student['gender_id'])['data'][0]) : null,
                    'photo'     => ImageHelper::site(Students::$path['image'], $student['photo']),
                ];
                $account = Users::where('email', $student['email'])->where('node_id', $student['id'])->first();
                return [
                    'id'    => $row['id'],
                    'request_id'  => $row['student_request_id'],
                    'name'  => $student['first_name_km'] . ' ' . $student['last_name_km'] .' - '.$student['first_name_en'] . ' ' . $student['last_name_en'],
                    'study_course_session'    => $row['study_course_session_id'] == null ? null : StudyCourseSession::getData($row['study_course_session_id'])['data'][0],
                    'node'      =>  $node,
                    'account'   => $account ? Users::getData($account->id)['data'][0] : null,
                    'photo' => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'], $row['photo'])) : $node['photo'],
                    'qrcode' => $row['qrcode'] ? (ImageHelper::site(Students::$path['image'] . '/' . QRHelper::$path['image'], $row['qrcode'])) : null,
                    'card' => $row['card'] ? (ImageHelper::site(Students::$path['image'] . '/' . CardFrames::$path['image'], $row['card'])) : null,

                    'action'    => [
                        'edit'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/edit/' . $row['id']),
                        'view'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/view/' . $row['id']),
                        'photo'  => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/photo/make/' . $row['id']),
                        'qrcode' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . QRHelper::$path['url'] . '/make/' . $row['id']),
                        'card'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . CardFrames::$path['url'] . '/make/' . $row['id']),
                        'certificate'=> url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . CertificateFrames::$path['url'] . '/make/' . $row['id']),
                        'account' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/account/create/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/delete/' . $row['id']),
                    ]
                ];
            })
            ->order(function ($query) {
                if (request('order')) {
                    foreach (request('order') as $order) {
                        $col = request('columns')[$order['column']];
                        if ($col['data'] == 'id') {
                            $query->orderBy('id', $order['dir']);
                        }
                    }
                }
            })
            ->toJson();
    }

    public static function studyStatus($query)
    {
        $data = [];
        if (gettype($query) == 'object' && $query->count()) {
            $studyStatus = StudyStatus::getData();
            if ($studyStatus['success']) {
                foreach ($studyStatus['data'] as  $status) {
                    $data[$status['id']] = [
                        'title' => in_array($status['id'], [2, 3]) ? $status['name'] :  Translator::phrase('student.' . $status['name']),
                        'color' => $status['color'],
                        'text'  => [],
                    ];
                    foreach ($query->get()->toArray() as  $row) {

                        if ($status['id'] == $row['study_status_id']) {
                            $data[$status['id']]['text'][$row['student_request_id']][] = $row['student_request_id'];
                        }

                        if (strpos($query->toSql(), 'institute_id') > 0) {
                            $value = $query->getBindings();
                            if ($value) {
                                $data[$status['id']]['link'] = url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list/?instituteId=' . $value[0] . '&statusId=' . $status['id']);
                            }
                        } elseif (strpos($query->toSql(), 'study_program_id') > 0) {
                            $value = $query->getBindings();
                            if ($value) {
                                $data[$status['id']]['link'] = url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list/?programId=' . $value[0] . '&statusId=' . $status['id']);
                            }
                        } else {
                            $data[$status['id']]['link'] = url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/list/?statusId=' . $status['id']);
                        }
                    }
                }
            }
        }

        $newData = [];

        foreach ($data as $key => $value) {
            $newData[$key] = $value;

            $newData[$key]['text'] = count($value['text']) . ((app()->getLocale() == 'km') ? ' នាក់' : ' Poeple');
        }
        return $newData;
    }

    public static function updateStudyStatus($student_study_course_id, $study_status_id)
    {
        return StudentsStudyCourse::where('id', $student_study_course_id)->update([
            'study_status_id' => $study_status_id
        ]);
    }

    public static function addToTable()
    {
        $response           = array();
        $validator          = Validator::make(request()->all(), FormStudentsStudyCourse::rulesField('.*'), FormStudentsStudyCourse::customMessages(), FormStudentsStudyCourse::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {
                $sid = '';
                foreach (request('student') as $student_request_id) {

                    if (!StudentsStudyCourse::existsToTable($student_request_id, request('study_course_session'))) {

                        $values = [
                            'student_request_id'  => $student_request_id,
                            'study_course_session_id'  => request('study_course_session'),
                            'study_status_id'  => request('study_status'),
                        ];
                        $add = StudentsStudyCourse::insertGetId($values);
                        if ($add) {
                            $sid  .= $add . ',';
                        }
                    }
                }
                if ($sid) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => StudentsStudyCourse::getData($sid)['data'],
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('add.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),

                    );
                } else {
                    $response       = array(
                        'success'   => false,
                        'errors'    => [],
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL . Translator::phrase('already_exists'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }
    public static function updateToTable($id)
    {
        $response           = array();
        $validator          = Validator::make(request()->all(), FormStudentsStudyCourse::rulesField('.*'), FormStudentsStudyCourse::customMessages(), FormStudentsStudyCourse::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {
                $exists =  StudentsStudyCourse::existsToTable(request('student')[0], request('study_course_session'));
                if ($exists) {
                    $response       = array(
                        'success'   => false,
                        'errors'    => [],
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('update.unsuccessful') . PHP_EOL . Translator::phrase('already_exists'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                    if ($exists->study_status_id  !== request('study_status')) {
                        $exists = null;
                    } elseif ($exists->student_request_id  !== request('student')[0]) {
                        $exists = null;
                    }
                }
                if (!$exists) {
                    $update = StudentsStudyCourse::where('id', $id)->update([
                        'student_request_id'  =>    request('student')[0],
                        'study_course_session_id'  => request('study_course_session'),
                        'study_status_id'  => request('study_status'),
                    ]);
                    if ($update) {
                        $response       = array(
                            'success'   => true,
                            'type'      => 'update',
                            'data'      => QuizStudent::getData($id),
                            'message'   => array(
                                'title' => Translator::phrase('success'),
                                'text'  => Translator::phrase('update.successfully'),
                                'button'   => array(
                                    'confirm' => Translator::phrase('ok'),
                                    'cancel'  => Translator::phrase('cancel'),
                                ),
                            ),
                        );
                    }
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }

    public static function existsToTable($student_request_id, $study_course_session_id)
    {
        $student_request = StudentsRequest::where('id', $student_request_id)->get()->first();
        return StudentsStudyCourse::join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', '=', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsRequest())->getTable() . '.student_id')
            ->where('student_id', $student_request->student_id)
            ->where('study_course_session_id', $study_course_session_id)
            ->groupBy('student_id')
            ->first();
    }
    public static function createAccountToTable($id)
    {


        $studentStudyCourse = StudentsStudyCourse::where('id', $id)->first()->toArray();


        if ($studentStudyCourse) {

            $student_request = StudentsRequest::where('id', $studentStudyCourse['student_request_id'])->first()->toArray();
            $student = Students::where('id', $student_request['student_id'])->first()->toArray();
            $account = Users::where('email', $student['email'])->where('node_id', $student['id'])->first();

            if ($account) {
                return [
                    'success' => false,
                    'data'    => [],
                    'message'   => array(
                        'title' => Translator::phrase('account'),
                        'text'  => Translator::phrase('already_exists'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                ];
            }

            $folder  = 'public/' . ImageHelper::$path['image'] . '/' . Students::$path['image'];
            $filePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folder;

            if (request('password')) {
                $first_name = array_key_exists('first_name_' . app()->getLocale(), $student) ? $student['first_name_' . app()->getLocale()] : $student['first_name_en'];
                $last_name  = array_key_exists('last_name_' . app()->getLocale(), $student) ? $student['last_name_' . app()->getLocale()] : $student['last_name_en'];
                $create = Users::insertGetId([
                    'name'          => $first_name . ' ' . $last_name,
                    'email'         => $student['email'],
                    'password'      => Hash::make(request('password')),
                    'phone'         => $student['phone'],
                    'address'       => $student['permanent_address'],
                    'role_id'       => Students::$path['roleId'],
                    'node_id'       => $student['id'],
                    'institute_id'  => $studentStudyCourse['institute_id'],
                ]);

                if ($create) {

                    if ($studentStudyCourse['photo'] && File::exists($filePath . '/' . StudentsStudyCourse::$path['image'] . '/original/' . $studentStudyCourse['photo'])) {
                        $profile = ImageHelper::uploadImage(null, Users::$path['image'], null, $filePath . '/' . StudentsStudyCourse::$path['image'] . '/original/' . $studentStudyCourse['photo']);
                        Users::updateImageToTable($create, $profile);
                    } elseif ($student['photo'] && File::exists($filePath . '/' . $student['photo'])) {
                        $profile = ImageHelper::uploadImage(null, Users::$path['image'], null, $filePath . '/' . $student['photo']);
                        Users::updateImageToTable($create, $profile);
                    }

                    $response = [
                        'success' => true,
                        'data'    => Users::getData($create),
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('create.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'data'    => [],
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('no_password'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                ];
            }
        }

        return $response;
    }
    public static function updateImageToTable($id, $photo)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($photo) {
            try {
                $update =  StudentsStudyCourse::where('id', $id)->update([
                    'photo'    => $photo,
                ]);

                if ($update) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('update.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }

        return $response;
    }
    public static function getImage($student_request_id)
    {
        $response = array(
            'success'   => false,
            'data'      => [],
            'message'   => Translator::phrase('no_photo'),
        );

        if ($student_request_id) {
            $get = StudentsStudyCourse::where('student_request_id', $student_request_id)->get()->toArray();
            $data = array();
            if ($get) {
                foreach ($get as $key => $row) {
                    if ($row['photo']) {
                        $data[] = array(
                            'id'                      => $row['id'],
                            'study_course_session'    => ($row['study_course_session_id'] == null ? null : StudyCourseSession::getData($row['study_course_session_id'])['data'][0]),
                            'photo'                   => (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'], $row['photo'])),
                        );
                    }
                }
            }

            if ($data) {
                $response       = array(
                    'success'   => true,
                    'data'      => $data,
                );
            }
        }
        return $response;
    }
    public static function makeImageToTable($id, $options = null)
    {
        $response = array(
            'success'   => false,
            'type'   => 'makePhoto',
            'data'   => [],
        );

        if ($id) {
            $photo = null;
            if (request()->hasFile('photo')) {
                $photo      = request()->file('photo');
            }

            $photo = ImageHelper::uploadImage(
                $photo,
                Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'],
                null,
                request('photo')
            );
            if ($photo) {
                try {
                    $update =  StudentsStudyCourse::where('id', $id)->update([
                        'photo' => $photo,
                    ]);
                    if ($update) {
                        $response       = array(
                            'success'   => true,
                            'type'      => 'makePhoto',
                            'data'      => ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyCourse::$path['image'], $photo),
                            'message'   => array(
                                'title' => Translator::phrase('success'),
                                'text'  => Translator::phrase('update.successfully'),
                                'button'   => array(
                                    'confirm' => Translator::phrase('ok'),
                                    'cancel'  => Translator::phrase('cancel'),
                                ),
                            ),
                        );
                    }
                } catch (DomainException $e) {
                    $response       = Exception::exception($e);
                }
            }
        }
        return $response;
    }
    public static function makeQrcodeToTable($id = null, $options = null)
    {
        $response = array(
            'success'   => false,
            'type'   => 'makeQRCode',
            'data'   => [],
        );


        if ($id) {
            $get = StudentsStudyCourse::getData($id);
            if ($get['success']) {
                $data = array();
                foreach ($get['data'] as $row) {

                    $q['size'] = request('qrcode_size') ? request('qrcode_size') : 100;
                    $q['code']  = $row['qrcode_url'];
                    if (request('qrcode_image_size')) {
                        $q['center']  = array(
                            'image' => $row['photo'],
                            'percentage' => request('qrcode_image_size') / $q['size']
                        );
                    }

                    $qrCode = ImageHelper::uploadImage(null,  Students::$path['image'] . '/' . QRHelper::$path['image'], null, QRHelper::make($q, true));

                    if ($qrCode) {
                        try {
                            StudentsStudyCourse::where('id', $row['id'])->update([
                                'qrcode'  => $qrCode,
                            ]);
                        } catch (DomainException $e) {
                            $response       = Exception::exception($e);
                        }
                        $data[] = ImageHelper::site(Students::$path['image'] . '/' . QRHelper::$path['image'], $qrCode);
                    }
                }

                $response       = array(
                    'success'   => true,
                    'type'   => 'makeQRCode',
                    'data'   => StudentsStudyCourse::getData($id)['data'],
                    'message'   => array(
                        'title' => Translator::phrase('success'),
                        'text'  => Translator::phrase('update.successfully'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            }
        }
        return $response;
    }

    public static function makeCardToTable()
    {

        $response = array(
            'success'   => false,
            'type'   => 'make',
            'data'   => [],
        );
        $id = '';
        if (request('cards')) {
            foreach (request('cards') as $key => $card) {
                if (count(request('cards')) == $key + 1) {
                    $id .= $card['id'];
                } else {
                    $id .= $card['id'] . ',';
                }

                $image =  ImageHelper::uploadImage($card['image'], Students::$path['image'] . '/' . CardFrames::$path['image']);
                if ($image) {
                    StudentsStudyCourse::where('id', $card['id'])->update([
                        'card'  => $image,
                    ]);
                }
            }
            $response       = array(
                'success'   => true,
                'type'   => 'make',
                'message'   => array(
                    'title' => Translator::phrase('success'),
                    'text'  => Translator::phrase('make.successfully'),
                    'button'   => array(
                        'confirm' => Translator::phrase('ok'),
                        'cancel'  => Translator::phrase('cancel'),
                    ),
                ),
            );
        }
        return $response;
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudentsStudyCourse::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudentsStudyCourse::whereIn('id', $id)->delete();
                        if ($delete) {
                            $response       =  array(
                                'success'   => true,
                                'message'   => array(
                                    'title' => Translator::phrase('deleted.!'),
                                    'text'  => Translator::phrase('delete.successfully'),
                                    'button'   => array(
                                        'confirm' => Translator::phrase('ok'),
                                        'cancel'  => Translator::phrase('cancel'),
                                    ),
                                ),
                            );
                        }
                    } catch (\Exception $e) {
                        $response       = Exception::exception($e);
                    }
                } else {
                    $response = response(
                        array(
                            'success'   => true,
                            'message'   => array(
                                'title' => Translator::phrase('are_you_sure.?'),
                                'text'  => Translator::phrase('you_wont_be_able_to_revert_this.!') . PHP_EOL .
                                    'ID : (' . implode(',', $id) . ')',
                                'button'   => array(
                                    'confirm' => Translator::phrase('yes_delete_it.!'),
                                    'cancel'  => Translator::phrase('cancel'),
                                ),
                            ),
                        )
                    );
                }
            } else {
                $response = response(
                    array(
                        'success'   => false,
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('no_data'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    )
                );
            }
        } else {
            $response = response(
                array(
                    'success'   => false,
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('please_select_data.!'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                )
            );
        }
        return $response;
    }

    public static function getStudy($student_id)
    {
        $get =  StudentsStudyCourse::join((new StudentsRequest())->getTable(), (new StudentsRequest())->getTable() . '.id', (new StudentsStudyCourse())->getTable() . '.student_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id',  (new StudentsRequest())->getTable() . '.student_id')
            ->where((new StudentsRequest())->getTable() . '.student_id', $student_id)
            ->groupBy('study_course_session_id')
            ->get()->toArray();

        $study_course_session_id = [];
        if ($get) {
            foreach ($get as $key => $row) {
                $study_course_session_id[] = $row['study_course_session_id'];
            }
            return StudyCourseSession::getData($study_course_session_id);
        }else{
            return StudyCourseSession::getData('null');
        }

    }
}
