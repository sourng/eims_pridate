<?php

namespace App\Models;

use Carbon\Carbon;
use DomainException;
use App\Helpers\Exception;
use App\Helpers\Encryption;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StudyCourseRoutine extends Model
{
    public static $path = [
        'image'  => 'study-course-routines',
        'url'    => 'course-routine',
        'view'   => 'StudyCourseRoutine'
    ];

    public static function getData($study_course_session_id = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/study/' . self::$path['url'] . '/add/'),
            ),
        );
        $data = array();
        $get = self::select((new self())->getTable() . '.*')
            ->join((new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', (new self())->getTable() . '.study_course_session_id')
            ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
            ->orderBy('study_course_session_id', 'DESC');

        if ($study_course_session_id) {
            $study_course_session_id  =  (gettype($study_course_session_id) == 'array') ? $study_course_session_id :  explode(',', $study_course_session_id);
            $get = $get->whereIn('study_course_session_id', $study_course_session_id);
        }

        if (request('instituteId')) {
            $get = $get->where('institute_id', request('instituteId'));
        }

        $get = $get->groupBy('study_course_session_id');

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
                $routine = self::where('study_course_session_id', $row['study_course_session_id'])->get()->toArray();
                $kdata = [];

                foreach ($routine as  $k) {
                    $teacher = Staff::find($k['teacher_id']);
                    if ($teacher) {

                        $first_name = array_key_exists('first_name_' . app()->getLocale(), $teacher->getAttributes()) ? $teacher->{'first_name_' . app()->getLocale()} : $teacher->{'first_name_en'};
                        $last_name  = array_key_exists('last_name_' . app()->getLocale(), $teacher->getAttributes()) ? $teacher->{'last_name_' . app()->getLocale()} : $teacher->{'last_name_en'};
                        $teacher = [
                            'id'    => $teacher->id,
                            'name'  => $first_name . ' ' . $last_name,
                            'email'  => $teacher->email,
                            'phone'  => $teacher->phone,
                            'photo'  => ImageHelper::site(Staff::$path['image'], $teacher->photo),
                        ];
                    }
                    $kdata[$k['start_time'] . '-' . $k['end_time']]['times'] = [
                        'start_time' => $k['start_time'],
                        'end_time' => $k['end_time'],
                    ];
                    $kdata[$k['start_time'] . '-' . $k['end_time']]['days'][] = [
                        'day' => Days::getData($k['day_id'])['data'][0],
                        'teacher' => $teacher,
                        'study_subject' => StudySubjects::getData($k['study_subject_id'])['data'][0],
                        'study_class' => StudyClass::getData($k['study_class_id'])['data'][0],
                    ];
                }
                $generateId = Encryption::encode([
                    'study_course_session_id' => $row['study_course_session_id'],
                ]);
                $data[$key]    = array(
                    'id'    => $generateId,
                    'study_course_session' => StudyCoursesession::getData($row['study_course_session_id'])['data'][0],
                    'children' => array_values($kdata),
                    'action' => [
                        'edit'    => url(users::role() . '/study/' . self::$path['url'] . '/edit/' . $generateId),
                        'delete'  => url(users::role() . '/study/' . self::$path['url'] . '/delete/' . $generateId),
                    ]
                );
                $data[$key]['name'] =  $data[$key]['study_course_session']['name'];
                $data[$key]['image'] =  $data[$key]['study_course_session']['image'];

                $pages['listData'][$key] = array(
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
        $model = self::select((new self())->getTable().'.*')
        ->join((new StudyCourseSession())->getTable(), (new StudyCourseSession())->getTable() . '.id', (new self())->getTable() . '.study_course_session_id')
        ->join((new StudyCourseSchedule())->getTable(), (new StudyCourseSchedule())->getTable() . '.id', (new StudyCourseSession())->getTable() . '.study_course_schedule_id')
        ->groupBy('study_course_session_id');

        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $study_course_session = StudyCourseSession::getData($row['study_course_session_id'])['data'][0];
                $generateId = Encryption::encode([
                    'study_course_session_id' => $row['study_course_session_id'],
                ]);
                return [
                    'id'    => $row['id'],
                    'study_course_session' => $study_course_session,
                    'action' => [
                        'view'    => url(users::role() . '/study/' . self::$path['url'] . '/view/' . $generateId),
                        'edit'    => url(users::role() . '/study/' . self::$path['url'] . '/edit/' . $generateId),
                        'delete'  => url(users::role() . '/study/' . self::$path['url'] . '/delete/' . $generateId),
                    ]
                ];
            })
            ->filter(function ($query) {

                if(request('instituteId')){
                    $query = $query->where('institute_id',request('instituteId'));
                }

                // if (request('search.value')) {
                //     foreach (request('columns') as $i => $value) {
                //         if ($value['searchable']) {
                //             if ($value['data'] == 'name') {
                //                 $query =  $query->where(function ($q) {
                //                     $q->where('study_course_session.name', 'LIKE', '%' . request('search.value') . '%');
                //                 });
                //             }
                //         }
                //     }
                // }

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

    public static function getSubject($study_course_session_id, $study_subject_id = null)
    {
        $data = array();
        $get = self::orderBy('day_id', 'ASC')->groupBy('study_subject_id')
            ->where('study_course_session_id', $study_course_session_id);
        if ($study_subject_id) {
            $get = $get->where('study_subject_id', $study_subject_id);
        }
        if (request('teacherId')) {
            $get = $get->where('teacher_id', request('teacherId'));
        }

        $get = $get->get()->toArray();
        if ($get) {
            foreach ($get as $row) {
                if ($row['study_subject_id']) {
                    $data[] = array(
                        'subject'       => StudySubjects::getData($row['study_subject_id'])['data'][0],
                    );
                }
            }
        }
        return $data;
    }

    public static function addToTable()
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), Formself::rulesField('.*'), Formself::customMessages(), Formself::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $exists = self::existsToTable();
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

                    $values = array();
                    foreach (request('day') as $k => $day) {
                        foreach ($day as $key => $value) {
                            $teacher = request('teacher')[$k][$key];
                            $study_subject = request('study_subject')[$k][$key];
                            $study_class = request('study_class')[$k][$key];

                            $values[] = array(
                                'study_course_session_id' => request('study_course_session'),
                                'day_id'                   => $value,
                                'start_time'               => request('start_time')[$k],
                                'end_time'                 => request('end_time')[$k],
                                'teacher_id'               => is_numeric($teacher) ? $teacher : null,
                                'study_subject_id'         => is_numeric($study_subject) ? $study_subject : null,
                                'study_class_id'           => is_numeric($study_class) ? $study_class : null,
                            );
                        }
                    }

                    $add = self::insert($values);
                    if ($add) {
                        $response       = array(
                            'success'   => true,
                            'data'      => [],
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
    public static function updateToTable()
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), Formself::rulesField('.*'), Formself::customMessages(), Formself::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $exists = self::existsToTable();

                if ($exists) {
                    self::where('study_course_session_id', $exists->study_course_session_id)->delete();
                    $values = array();
                    foreach (request('day') as $k => $day) {
                        foreach ($day as $key => $value) {
                            $teacher = request('teacher')[$k][$key];
                            $study_subject = request('study_subject')[$k][$key];
                            $study_class = request('study_class')[$k][$key];

                            $values[] = array(
                                'study_course_session_id' => request('study_course_session'),
                                'day_id'                   => $value,
                                'start_time'               => request('start_time')[$k],
                                'end_time'                 => request('end_time')[$k],
                                'teacher_id'               => is_numeric($teacher) ? $teacher : null,
                                'study_subject_id'         => is_numeric($study_subject) ? $study_subject : null,
                                'study_class_id'           => is_numeric($study_class) ? $study_class : null,
                                'created_at'               => $exists->created_at,
                                'updated_at'               => Carbon::now(),
                            );
                        }
                    }


                    $add = self::insert($values);
                    if ($add) {
                        $response       = array(
                            'success'   => true,
                            'data'      => [],
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
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }
    public static function existsToTable()
    {
        return self::where('study_course_session_id', request('study_course_session'))->first();
    }

    public static function deleteFromTable($id)
    {
        if ($id) {

            $ids  = explode(',', $id);
            $id   = [];
            foreach ($ids as $key => $value) {
                $id[] = Encryption::decode($value)['study_course_session_id'];
            }
            if (self::whereIn('study_course_session_id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = self::whereIn('study_course_session_id', $id)->delete();
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
