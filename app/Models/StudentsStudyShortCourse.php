<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStudentsStudyShortCourse;

class StudentsStudyShortCourse extends Model
{
    public static $path  = [
        'url'    => 'study-short-course',
        'image'   => 'study-short-course',
        'view'   => 'StudentsStudyShortCourse',
    ];

    public static function getData($id = null, $paginate = null, $search = null)
    {
        $student_study_short_course = (new StudentsStudyShortCourse)->getTable();
        $student_short_cououre_request = (new StudentsShortCourseRequest)->getTable();
        $study_short_cououre_schedule = (new StudyShortCourseSchedule)->getTable();
        $study_short_cououre_session = (new StudyShortCourseSession)->getTable();
        $student = new Students;




        $orderBy = 'ASC';
        $data = [];
        $pages = [];
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

        $get = StudentsStudyShortCourse::orderBy($student_study_short_course . '.id', $orderBy)
            ->join($study_short_cououre_session, $study_short_cououre_session . '.id', $student_study_short_course . '.stu_sh_c_session_id')
            ->join($student_short_cououre_request, $student_short_cououre_request . '.id', $student_study_short_course . '.stu_sh_c_request_id')
            ->join($study_short_cououre_schedule, $study_short_cououre_schedule . '.id', $study_short_cououre_session . '.stu_sh_c_schedule_id');

        if ($id) {
            $get = $get->whereIn($student_study_short_course . '.id', $id);
        } else {
            if (request('instituteId')) {
                $get = $get->where($study_short_cououre_schedule . '.institute_id', request('instituteId'));
            }
        }
        if ($search) {
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
                $student_request = StudentsShortCourseRequest::where('id', $row['stu_sh_c_request_id'])->first();
                $student = Students::where('id', $student_request->student_id)->first()->toArray();
                $account = Users::where('email', $student['email'])->where('node_id', $student['id'])->first();
                $data[$key] = [
                    'id'    => $row['id'],
                    'request_id'  => $row['stu_sh_c_request_id'],
                    'name'  => $student['first_name_km'] . ' ' . $student['last_name_km'] . ' - ' . $student['first_name_en'] . ' ' . $student['last_name_en'],
                    'study_short_course_session'    =>  StudyShortCourseSession::getData($row['stu_sh_c_session_id'])['data'][0],
                    'account'   => $account ? Users::getData($account->id)['data'][0] : null,
                    'photo' => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyShortCourse::$path['image'], $row['photo'])) : ImageHelper::site(Students::$path['image'], $student['photo']),
                    'action'    => [
                        'edit'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/edit/' . $row['id']),
                        'view'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/delete/' . $row['id']),
                    ]
                ];
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => $data[$key]['photo'],
                    'action' => $data[$key]['action'],
                );
            }

            $response =  [
                'success'   => true,
                'data'   => $data,
                'pages' => $pages
            ];
        } else {
            $response =  [
                'success'   => false,
                'data'   => [],
                'message'   => Translator::phrase('no_data'),
                'pages' => $pages
            ];
        }

        return $response;
    }

    public static function getDataTable()
    {
        $model = StudentsStudyShortCourse::select((new StudentsStudyShortCourse())->getTable() . '.*', (new Students())->getTable() . '.gender_id')
            ->join((new StudentsShortCourseRequest())->getTable(), (new StudentsShortCourseRequest())->getTable() . '.id', '=', (new StudentsStudyShortCourse())->getTable() . '.stu_sh_c_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsShortCourseRequest())->getTable() . '.student_id')
            ->join((new StudyShortCourseSession())->getTable(), (new StudyShortCourseSession())->getTable() . '.id', '=', (new StudentsStudyShortCourse())->getTable() . '.stu_sh_c_session_id')
            ->join((new StudyShortCourseSchedule())->getTable(), (new StudyShortCourseSchedule())->getTable() . '.id', '=', (new StudyShortCourseSession())->getTable() . '.stu_sh_c_schedule_id')
            ->join((new Institute())->getTable(), (new Institute())->getTable() . '.id', '=', (new StudyShortCourseSchedule())->getTable() . '.institute_id');
        return DataTables::eloquent($model)
            ->filter(function ($query) {

                if (request('instituteId')) {
                    $query =  $query->where((new StudyShortCourseSchedule())->getTable() . '.institute_id', request('instituteId'));
                }
                if (request('course-sessionId')) {
                    $query =  $query->where('stu_sh_c_session_id', request('course-sessionId'));
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
                $student_request = StudentsShortCourseRequest::where('id', $row['stu_sh_c_request_id'])->first();
                $student = Students::where('id', $student_request->student_id)->first()->toArray();

                $account = Users::where('email', $student['email'])->where('node_id', $student['id'])->first();
                return [
                    'id'    => $row['id'],
                    'request_id'  => $row['stu_sh_c_request_id'],
                    'name'  => $student['first_name_km'] . ' ' . $student['last_name_km'] . ' - ' . $student['first_name_en'] . ' ' . $student['last_name_en'],
                    'study_short_course_session'    =>  StudyShortCourseSession::getData($row['stu_sh_c_session_id'])['data'][0],
                    'account'   => $account ? Users::getData($account->id)['data'][0] : null,
                    'photo' => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsStudyShortCourse::$path['image'], $row['photo'])) : ImageHelper::site(Students::$path['image'], $student['photo']),
                    'action'    => [
                        'edit'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/edit/' . $row['id']),
                        'view'   => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/delete/' . $row['id']),
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

    public static function addToTable()
    {
        $response           = array();
        $validator          = Validator::make(request()->all(), FormStudentsStudyShortCourse::rulesField('.*'), FormStudentsStudyShortCourse::customMessages(), FormStudentsStudyShortCourse::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {
                $sid = '';
                foreach (request('student') as $stu_sh_c_request_id) {

                    if (!StudentsStudyShortCourse::existsToTable($stu_sh_c_request_id, request('study_short_course_session'))) {

                        $values = [
                            'stu_sh_c_request_id'  => $stu_sh_c_request_id,
                            'stu_sh_c_session_id'  => request('study_short_course_session'),
                        ];
                        $add = StudentsStudyShortCourse::insertGetId($values);
                        if ($add) {
                            $sid  .= $add . ',';
                        }
                    }
                }
                if ($sid) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => StudentsStudyShortCourse::getData($sid)['data'],
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
        $validator          = Validator::make(request()->all(), FormStudentsStudyShortCourse::rulesField('.*'), FormStudentsStudyShortCourse::customMessages(), FormStudentsStudyShortCourse::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {
                $exists =  StudentsStudyShortCourse::existsToTable(request('student')[0], request('study_short_course_session'));

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
                }
                if (!$exists) {
                    $update = StudentsStudyShortCourse::where('id', $id)->update([
                        'stu_sh_c_request_id'  =>    request('student')[0],
                        'stu_sh_c_session_id'  => request('study_short_course_session'),
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

    public static function updateImageToTable($id, $photo)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($photo) {
            try {
                $update =  StudentsStudyShortCourse::where('id', $id)->update([
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

    public static function existsToTable($stu_sh_c_request_id, $stu_sh_c_session_id)
    {
        $student_request = StudentsShortCourseRequest::where('id', $stu_sh_c_request_id)->get()->first();
        return StudentsStudyShortCourse::join((new StudentsShortCourseRequest())->getTable(), (new StudentsShortCourseRequest())->getTable() . '.id', '=', (new StudentsStudyShortCourse())->getTable() . '.stu_sh_c_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', '=', (new StudentsShortCourseRequest())->getTable() . '.student_id')
            ->where('student_id', $student_request->student_id)
            ->where('stu_sh_c_session_id', $stu_sh_c_session_id)
            ->groupBy('student_id')
            ->first();
    }

    public static function getStudy($student_id)
    {
        $get =  StudentsStudyShortCourse::join((new StudentsShortCourseRequest())->getTable(), (new StudentsShortCourseRequest())->getTable() . '.id', (new StudentsStudyShortCourse())->getTable() . '.stu_sh_c_request_id')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', (new StudentsShortCourseRequest())->getTable() . '.student_id')
            ->where((new StudentsShortCourseRequest())->getTable() . '.student_id', $student_id)
            ->groupBy('stu_sh_c_session_id')
            ->get()->toArray();

        $stu_sh_c_session_id = [];
        if ($get) {
            foreach ($get as $key => $row) {
                $stu_sh_c_session_id[] = $row['stu_sh_c_session_id'];
            }
            return StudyShortCourseSession::getData($stu_sh_c_session_id);
        } else {
            return StudyShortCourseSession::getData('null');
        }
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudentsStudyShortCourse::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudentsStudyShortCourse::whereIn('id', $id)->delete();
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
}
