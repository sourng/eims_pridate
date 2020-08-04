<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStudyShortCourseSchedule;
use Illuminate\Support\Facades\Auth;

class StudyShortCourseSchedule extends Model
{
    public static $path = [
        'image'  => 'study-short-course-schedules',
        'url'    => 'short-course-schedule',
        'view'   => 'StudyShortCourseSchedule'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/add/'),
            ),
        );
        $data = array();


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

        $get = StudyShortCourseSchedule::orderBy('id', $orderBy);

        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            if (request('ref') == StudyCourseSession::$path['url']) {
                $get = $get->whereNotIn('id', StudyCourseSession::select('stu_sh_c_schedule_id')->get());
            }
            if (request('instituteId')) {
                $get = $get->where('institute_id', request('instituteId'));
            }
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

                $data[$key]  = array(
                    'id'  => $row['id'],
                    'institute'   => Institute::getData($row['institute_id'])['data'][0],
                    'study_generation'   => StudyGeneration::getData($row['study_generation_id'])['data'][0],
                    'study_subject'   => StudySubjects::getData($row['study_subject_id'])['data'][0],
                    'action'        => [
                        'edit' => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
                $data[$key]['name']  = $data[$key]['study_subject']['name'] . ' - (' . $data[$key]['study_generation']['name']  . ') ';

                if (!request('instituteId')) {
                    $data[$key]['name'] = $data[$key]['institute']['short_name'] . ' - ' . $data[$key]['name'];
                }

                $data[$key]['image']  = $data[$key]['study_subject']['image'];

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
        $model = StudyShortCourseSchedule::select((new StudyShortCourseSchedule)->getTable() . '.*')
            ->join((new Institute)->getTable(), (new Institute)->getTable() . '.id', (new StudyShortCourseSchedule)->getTable() . '.institute_id')
            ->join((new StudyGeneration)->getTable(), (new StudyGeneration)->getTable() . '.id', (new StudyShortCourseSchedule)->getTable() . '.study_generation_id')
            ->join((new StudySubjects)->getTable(), (new StudySubjects)->getTable() . '.id', (new StudyShortCourseSchedule)->getTable() . '.study_subject_id');

        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'  => $row['id'],
                    'institute'   => Institute::getData($row['institute_id'])['data'][0],
                    'study_generation'   => StudyGeneration::getData($row['study_generation_id'])['data'][0],
                    'study_subject'   => StudySubjects::getData($row['study_subject_id'])['data'][0],
                    'action'        => [
                        'edit' => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/study/' . StudyShortCourseSchedule::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {
                if (request('instituteId')) {
                    $query = $query->where((new StudyShortCourseSchedule)->getTable() . '.institute_id', request('instituteId'));
                }


                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'study_generation.name') {
                                $query =  $query->where((new StudyGeneration())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');

                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudyGeneration)->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                    }
                                }
                            } elseif ($value['data'] == 'study_subject.name') {
                                $query =  $query->orWhere((new StudySubjects())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');
                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudySubjects)->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                    }
                                }
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
        $validator          = Validator::make(request()->all(), FormStudyShortCourseSchedule::rulesField(), FormStudyShortCourseSchedule::customMessages(), FormStudyShortCourseSchedule::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $exists = StudyShortCourseSchedule::existsToTable();
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
                    $add = StudyShortCourseSchedule::insertGetId([
                        'institute_id'        => request('institute'),
                        'study_generation_id'    => request('study_generation'),
                        'study_subject_id'      => request('study_subject')
                    ]);
                    if ($add) {
                        $response       = array(
                            'success'   => true,
                            'data'      => StudyShortCourseSchedule::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormStudyShortCourseSchedule::rulesField(), FormStudyShortCourseSchedule::customMessages(), FormStudyShortCourseSchedule::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $update = StudyShortCourseSchedule::where('id', $id)->update([
                    'institute_id'        => request('institute'),
                    'study_generation_id'    => request('study_generation'),
                    'study_subject_id'      => request('study_subject')
                ]);
                if ($update) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => StudyShortCourseSchedule::getData($id),
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
        return StudyShortCourseSchedule::where('institute_id', request('institute'))
            ->where('study_generation_id', request('study_generation'))
            ->where('study_subject_id', request('study_subject'))
            ->first();
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudyShortCourseSchedule::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudyShortCourseSchedule::whereIn('id', $id)->delete();
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
