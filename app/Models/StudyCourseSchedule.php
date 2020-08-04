<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStudyCourseSchedule;
use Illuminate\Support\Facades\Auth;

class StudyCourseSchedule extends Model
{
    public static $path = [
        'image'  => 'study-course-schedules',
        'url'    => 'course-schedule',
        'view'   => 'StudyCourseSchedule'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/add/'),
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

        $get = StudyCourseSchedule::orderBy('id', $orderBy);

        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            if(request('ref') == StudyCourseSession::$path['url']){
                $get = $get->whereNotIn('id',StudyCourseSession::select('study_course_schedule_id')->get());
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

                $data[$key]                   = array(
                    'id'  => $row['id'],
                    'name' => null,
                    'image' => null,
                    'institute'   => Institute::getData($row['institute_id'])['data'][0],
                    'study_program'   => StudyPrograms::getData($row['study_program_id'])['data'][0],
                    'study_course' => StudyCourse::getData($row['study_course_id'])['data'][0],
                    'study_generation'   => StudyGeneration::getData($row['study_generation_id'])['data'][0],
                    'study_academic_year'   => StudyAcademicYears::getData($row['study_academic_year_id'])['data'][0],
                    'study_semester'   => StudySemesters::getData($row['study_semester_id'])['data'][0],

                    'action'                   => [
                        'edit'   => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/edit/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
                $data[$key]['name']  = $data[$key]['study_course']['name'] . ' - (' . $data[$key]['study_generation']['name'] . ', ' . $data[$key]['study_academic_year']['name'] . ', ' . $data[$key]['study_semester']['name'] . ') ' . $data[$key]['study_program']['name'];

                if (!request('instituteId')) {
                    $data[$key]['name'] = $data[$key]['institute']['short_name'] . ' - ' . $data[$key]['name'];
                }

                $data[$key]['image']  = $data[$key]['study_course']['image'];

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
        $model = StudyCourseSchedule::select((new StudyCourseSchedule)->getTable() . '.*')
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
                    'institute'   => Institute::getData($row['institute_id'])['data'][0],
                    'study_program'   => StudyPrograms::getData($row['study_program_id'])['data'][0],
                    'study_course' => StudyCourse::getData($row['study_course_id'])['data'][0],
                    'study_generation'   => StudyGeneration::getData($row['study_generation_id'])['data'][0],
                    'study_academic_year'   => StudyAcademicYears::getData($row['study_academic_year_id'])['data'][0],
                    'study_semester'   => StudySemesters::getData($row['study_semester_id'])['data'][0],
                    'action'        => [
                        'edit' => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/study/' . StudyCourseSchedule::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {
                if (Auth::user()->role_id == 2) {
                    $query =  $query->where((new StudyCourseSchedule)->getTable().'.institute_id', Auth::user()->institute_id);
                }

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'study_program.name') {
                                $query =  $query->where((new StudyPrograms)->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');

                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudyPrograms)->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                    }
                                }
                            } elseif ($value['data'] == 'study_course.name') {
                                $query =  $query->orWhere((new StudyCourse())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');
                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudyCourse)->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                    }
                                }
                            } elseif ($value['data'] == 'study_generation.name') {
                                $query =  $query->orWhere((new StudyGeneration())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');

                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudyGeneration)->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                    }
                                }
                            } elseif ($value['data'] == 'study_academic_year.name') {
                                $query =  $query->orWhere((new StudyAcademicYears())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');
                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudyAcademicYears)->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                    }
                                }
                            } elseif ($value['data'] == 'study_semester.name') {
                                $query =  $query->orWhere((new StudySemesters())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');
                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudySemesters)->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
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
        $validator          = Validator::make(request()->all(), FormStudyCourseSchedule::rulesField(), FormStudyCourseSchedule::customMessages(), FormStudyCourseSchedule::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $exists = StudyCourseSchedule::existsToTable();
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
                    $add = StudyCourseSchedule::insertGetId([
                        'institute_id'        => request('institute'),
                        'study_program_id'      => request('study_program'),
                        'study_course_id'        => request('study_course'),
                        'study_generation_id'    => request('study_generation'),
                        'study_academic_year_id' => request('study_academic_year'),
                        'study_semester_id'      => request('study_semester')
                    ]);
                    if ($add) {
                        $response       = array(
                            'success'   => true,
                            'data'      => StudyCourseSchedule::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormStudyCourseSchedule::rulesField(), FormStudyCourseSchedule::customMessages(), FormStudyCourseSchedule::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $update = StudyCourseSchedule::where('id', $id)->update([
                    'institute_id'        => request('institute'),
                    'study_program_id'      => request('study_program'),
                    'study_course_id'        => request('study_course'),
                    'study_generation_id'    => request('study_generation'),
                    'study_academic_year_id' => request('study_academic_year'),
                    'study_semester_id'      => request('study_semester')
                ]);
                if ($update) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => StudyCourseSchedule::getData($id),
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
        return StudyCourseSchedule::where('institute_id', request('institute'))
            ->where('study_course_id', request('study_course'))
            ->where('study_generation_id', request('study_generation'))
            ->where('study_academic_year_id', request('study_academic_year'))
            ->where('study_semester_id', request('study_semester'))
            ->first();
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudyCourseSchedule::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudyCourseSchedule::whereIn('id', $id)->delete();
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
