<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\DateHelper;
use App\Helpers\Translator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStudyCourseSession;

class StudyCourseSession extends Model
{
    public static $path = [
        'image'  => 'study-course-sessions',
        'url'    => 'course-session',
        'view'   => 'StudyCourseSession'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/study/' . StudyCourseSession::$path['url'] . '/add/'),
            ),
        );
        if (Auth::user()->role_id == 8) {
            $pages['form']['action']['add'] = str_replace('study', 'teaching', $pages['form']['action']['add']);
        } elseif (Auth::user()->role_id == 6) {
            $pages['form']['action']['add'] = str_replace(StudyCourseSession::$path['url'], 'approved', $pages['form']['action']['add']);
        }
        $data = array();

        $getCallMethods = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);

        if (class_basename($getCallMethods[1]['class']) == class_basename('StudyCourseSessionController')) {
            $search = request('search');
        } elseif (class_basename($getCallMethods[1]['class']) == class_basename('TeacherController')) {
            $pages['form']['action']['add'] = str_replace('study', 'teaching', $pages['form']['action']['add']);
        } else {
            $search = null;
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

        $get = StudyCourseSession::select((new StudyCourseSession())->getTable() . '.*')
            ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
            ->orderBy((new StudyCourseSession())->getTable() . '.id', $orderBy);

        // if (class_basename($getCallMethods[2]['class']) == class_basename('StudyController')) {
        //     $courseRoutine = StudyCourseRoutine::select('study_course_session_id')->groupBy('study_course_session_id')->get()->toArray();
        //     $exists = [];
        //     foreach ($courseRoutine as $key => $value) {
        //         $exists[] = $value['study_course_session_id'];
        //     }
        //     if ($exists) {
        //         $get = $get->whereNotIn((new StudyCourseSession())->getTable() . '.id', $exists);
        //     }
        // }


        if ($id) {
            $get = $get->whereIn((new StudyCourseSession())->getTable() . '.id', $id);
        } else {
            if (request('instituteId')) {
                $get = $get->where('institute_id', request('instituteId'));
            }
        }




        // if ($search) {
        //     $get = $get->where('name', 'LIKE', '%' . $search . '%');
        //     if (array_key_exists('en', request()->all())) {
        //         $get = $get->orWhere('en', 'LIKE', '%' . $search . '%');
        //     }
        //     if (array_key_exists('km', request()->all())) {
        //         $get = $get->orWhere('km', 'LIKE', '%' . $search . '%');
        //     }
        // }


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
                $data[$key]  = array(
                    'id'  => $row['id'],
                    'name' => null,
                    'image' => null,
                    'study_course_schedule' => StudyCourseSchedule::getData($row['study_course_schedule_id'])['data'][0],
                    'study_session' => StudySession::getData($row['study_session_id'])['data'][0],
                    'study_start'   => DateHelper::convert($row['study_start'], $edit ? 'd-m-Y' : 'd-M-Y'),
                    'study_end'    => DateHelper::convert($row['study_end'],  $edit ? 'd-m-Y' : 'd-M-Y'),
                    'action'     => [
                        'edit'   => url(Users::role() . '/study/' . StudyCourseSession::$path['url'] . '/edit/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/study/' . StudyCourseSession::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
                $data[$key]['name']  = $data[$key]['study_course_schedule']['name'] . ' (' . $data[$key]['study_session']['name'] . ')';
                $data[$key]['image']  = $data[$key]['study_course_schedule']['image'];
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => $data[$key]['image'],
                    'action' => $data[$key]['action'],

                );
            }

            $response       = array(
                'success'   => true,
                'data'      => $data,
                'pages'     => $pages
            );
        } else {
            $response = array(
                'success'   => false,
                'data'      => [],
                'pages'     => $pages,
                'message'   => Translator::phrase('no_data'),
            );
        }

        return $response;
    }

    public static function getDataTable()
    {
        $model = StudyCourseSession::select((new StudyCourseSession())->getTable() . '.*')
            ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
            ->join((new StudySession)->getTable(), (new StudySession)->getTable() . '.id', (new StudyCourseSession)->getTable() . '.study_session_id')
            ->join((new Institute)->getTable(), (new Institute)->getTable() . '.id', (new StudyCourseSchedule)->getTable() . '.institute_id')
            ->join((new StudyPrograms)->getTable(), (new StudyPrograms)->getTable() . '.id', (new StudyCourseSchedule)->getTable() . '.study_program_id')
            ->join((new StudyCourse)->getTable(), (new StudyCourse)->getTable() . '.id', (new StudyCourseSchedule)->getTable() . '.study_course_id')
            ->join((new StudyGeneration)->getTable(), (new StudyGeneration)->getTable() . '.id', (new StudyCourseSchedule)->getTable() . '.study_generation_id')
            ->join((new StudyAcademicYears)->getTable(), (new StudyAcademicYears)->getTable() . '.id', (new StudyCourseSchedule)->getTable() . '.study_academic_year_id')
            ->join((new StudySemesters)->getTable(), (new StudySemesters)->getTable() . '.id', (new StudyCourseSchedule)->getTable() . '.study_semester_id');

        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'  => $row['id'],
                    'id'  => $row['id'],
                    'study_course_schedule' => StudyCourseSchedule::getData($row['study_course_schedule_id'])['data'][0],
                    'study_session' => StudySession::getData($row['study_session_id'])['data'][0],
                    'study_start'   => DateHelper::convert($row['study_start'], 'd-M-Y'),
                    'study_end'    => DateHelper::convert($row['study_end'],  'd-M-Y'),
                    'action'        => [
                        'edit' => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {
                if (Auth::user()->role_id == 2) {
                    $query =  $query->where((new StudyCourseSchedule())->getTable().'.institute_id', Auth::user()->institute_id);
                }

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'study_course_schedule.name') {
                                $query =  $query->where((new StudyPrograms)->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyPrograms)->getTable() . '.en', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyPrograms)->getTable() . '.km', 'LIKE', '%' . request('search.value') . '%')

                                    ->orWhere((new StudyCourse())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyCourse())->getTable() . '.en', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyCourse())->getTable() . '.km', 'LIKE', '%' . request('search.value') . '%')

                                    ->orWhere((new StudyGeneration())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyGeneration())->getTable() . '.en', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyGeneration())->getTable() . '.km', 'LIKE', '%' . request('search.value') . '%')

                                    ->orWhere((new StudyAcademicYears())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyAcademicYears())->getTable() . '.en', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudyAcademicYears())->getTable() . '.km', 'LIKE', '%' . request('search.value') . '%')

                                    ->orWhere((new StudySemesters())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudySemesters())->getTable() . '.en', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudySemesters())->getTable() . '.km', 'LIKE', '%' . request('search.value') . '%');
                            } elseif ($value['data'] == 'study_session.name') {
                                $query =  $query->orWhere((new StudySession())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudySession())->getTable() . '.en', 'LIKE', '%' . request('search.value') . '%')
                                    ->orWhere((new StudySession())->getTable() . '.km', 'LIKE', '%' . request('search.value') . '%');
                            }
                        }
                    }
                }

                return $query;
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
        $validator          = Validator::make(request()->all(), FormStudyCourseSession::rulesField(), FormStudyCourseSession::customMessages(), FormStudyCourseSession::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $exists = StudyCourseSession::existsToTable();
                if ($exists) {
                    $response       = array(
                        'success'   => false,
                        'data'      => $exists,
                        'type'      => 'add',
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('already_exists'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                } else {
                    $add = StudyCourseSession::insertGetId([
                        'study_course_schedule_id'  => request('study_course_schedule'),
                        'study_session_id'      => request('study_session'),
                        'study_start'      => DateHelper::convert(trim(request('study_start'))),
                        'study_end'      => DateHelper::convert(trim(request('study_end'))),
                    ]);
                    if ($add) {
                        $response       = array(
                            'success'   => true,
                            'data'      => StudyCourseSession::getData($add)['data'],
                            'type'      => 'add',
                            'message'   => array(
                                'title' => Translator::phrase('success'),
                                'text'  => Translator::phrase('add.successfully'),
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

    public static function updateToTable($id)
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormStudyCourseSession::rulesField(), FormStudyCourseSession::customMessages(), FormStudyCourseSession::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $update = StudyCourseSession::where('id', $id)->update([
                    'study_course_schedule_id'  => request('study_course_schedule'),
                    'study_session_id'      => request('study_session'),
                    'study_start'      => DateHelper::convert(trim(request('study_start'))),
                    'study_end'      => DateHelper::convert(trim(request('study_end'))),
                ]);
                if ($update) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => StudyCourseSession::getData($id),
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('update.successfully'),
                            'button'      => array(
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

    public static function existsToTable()
    {
        return StudyCourseSession::where('study_course_schedule_id', request('study_course_schedule'))
            ->where('study_session_id', request('study_session'))
            ->where('study_start', DateHelper::convert(trim(request('study_start'))))
            ->where('study_end', DateHelper::convert(trim(request('study_end'))))
            ->first();
    }
    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudyCourseSession::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudyCourseSession::whereIn('id', $id)->delete();
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
