<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\ImageHelper;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStaffTeachSubject;
use Illuminate\Support\Facades\Auth;

class StaffTeachSubject extends Model
{
    public static $path = [
        'url'    => 'teach-subject',
        'view'   => 'StaffTeachSubject'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {

        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/add/'),
            ),
        );



        $orderBy = 'DESC';
        $data = array();
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
        $get = StaffTeachSubject::orderBy('id', $orderBy);

        if ($id) {
            $get = $get->whereIn('id', $id);
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
                $staff = Staff::getData($row['staff_id'])['data'][0];

                $action = [
                    'edit' => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/edit/' . $row['id']),
                    'view' => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/view/' . $row['id']),
                    'delete' => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/delete/' . $row['id']),
                ];
                if (Auth::user()->role_id == 10) {
                    $action['edit'] =  str_replace(Staff::$path['url'], 'teaching', $action['edit']);
                    $action['view'] =  str_replace(Staff::$path['url'], 'teaching', $action['view']);
                    $action['delete'] =  str_replace(Staff::$path['url'], 'teaching', $action['delete']);
                }

                $data[$key]         = array(
                    'id'            => $row['id'],
                    'name'          => $staff['first_name'] . ' ' . $staff['last_name'],
                    'staff'         => $staff,
                    'study_subject' => StudySubjects::getData($row['study_subject_id'])['data'][0],
                    'year'          => $row['year'],
                    'image'         => $staff['photo'],
                    'action'        => $action,
                );
                if (request('ref') == StudySubjectLesson::$path['url']) {
                    $data[$key]['name'] = $data[$key]['name'] . ' - ' . $data[$key]['study_subject']['name'] . ' - ' . $data[$key]['year'];
                }

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
                'pages'     => $pages,
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

        $model = StaffTeachSubject::select([(new StaffTeachSubject())->getTable() . '.*', (new StaffInstitutes())->getTable() . '.institute_id'])
            ->join((new Staff())->getTable(), (new Staff())->getTable() . '.id', (new StaffTeachSubject())->getTable() . '.staff_id')
            ->join((new StaffInstitutes())->getTable(), (new Staff())->getTable() . '.id', (new StaffInstitutes())->getTable() . '.staff_id')
            ->join((new StudySubjects())->getTable(), (new StudySubjects())->getTable() . '.id', (new StaffTeachSubject())->getTable() . '.study_subject_id');

        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $staff = Staff::where('id', $row['staff_id'])->first(['first_name_' . app()->getLocale() . ' as first_name', 'last_name_' . app()->getLocale() . ' as last_name', 'photo']);
                $study_subject = StudySubjects::where('id', $row['study_subject_id'])->first([app()->getLocale() . ' as name', 'image']);
                $action = [
                    'edit' => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/edit/' . $row['id']),
                    'view' => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/view/' . $row['id']),
                    'delete' => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/delete/' . $row['id']),
                ];
                if (Auth::user()->role_id == 10) {
                    $action['edit'] =  str_replace(Staff::$path['url'], 'teaching', $action['edit']);
                    $action['view'] =  str_replace(Staff::$path['url'], 'teaching', $action['view']);
                    $action['delete'] =  str_replace(Staff::$path['url'], 'teaching', $action['delete']);
                }

                return [
                    'id'            => $row['id'],
                    'name'          => $staff->first_name . ' ' . $staff->last_name,
                    'institute'     => Institute::where('id', $row['institute_id'])->pluck(app()->getLocale()),
                    'study_subject' => [
                        'name'  => $study_subject->name,
                        'image'  => $study_subject->image ? (ImageHelper::site(StudySubjects::$path['image'], $study_subject->image)) : ImageHelper::prefix(),
                    ],
                    'year'          => $row['year'],
                    'image'         => ImageHelper::site(Staff::$path['image'], $staff->photo),
                    'action'        => $action,

                ];
            })
            ->filter(function ($query) {

                if (Auth::user()->role_id == 2) {
                    $query =  $query->where((new StaffInstitutes())->getTable() . '.institute_id', Auth::user()->institute_id);
                }


                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name') {
                                $query =  Staff::searchName($query, request('search.value'));
                            } elseif ($value['data'] == 'study_subject.name') {
                                $query = $query->orWhere((new StudySubjects())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');
                                if (config('app.languages')) {
                                    foreach (config('app.languages') as $lang) {
                                        $query->orWhere((new StudySubjects())->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                    }
                                }
                            } elseif ($value['data'] == 'year') {
                                $query->orWhere('year', 'LIKE', '%' . request('search.value') . '%');
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

    public static function getTeachSubjects($id = null, $staff_id = null, $study_subject_id = null, $paginate = null, $groupByYear = true, $year = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/teaching/' . StaffTeachSubject::$path['url'] . '/add/'),
            ),
        );

        $getCallMethods = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        if (class_basename($getCallMethods['class']) == class_basename('StaffTeachSubjectController')) {
            $pages['form']['action']['add'] = str_replace('teaching', 'study', $pages['form']['action']['add']);
        }

        $get = StaffTeachSubject::groupBy('year')
            ->groupBy('study_subject_id')
            ->orderBy('year', 'DESC');

        if ($id) {
            $get = $get->where('id', $id);
        } else {

            if ($staff_id) {
                $get = $get->where('staff_id', $staff_id);
            }

            if ($study_subject_id) {
                $get = $get->where('study_subject_id', $study_subject_id);
            }
            if ($year) {
                $get = $get->where('year', $year);
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
        //dd($get);
        if ($get) {
            $data = [];

            foreach ($get as $key => $row) {

                $study_subject = StudySubjects::getData($row['study_subject_id'])['data'][0];
                if ($groupByYear) {
                    $data[$row['year']][$key] = [
                        'id'    => $row['id'],
                        'staff'  => Staff::getData($row['staff_id'])['data'][0],
                        'study_subject' => $study_subject,
                        'lesson_count'    => StudySubjectLesson::where('staff_teach_subject_id', $row['id'])->count(),
                        'action'        => [
                            'link' => url(Users::role() . '/teaching/' . StudySubjectLesson::$path['url'] . '/list?t-subjectId=' . $row['id']), //?id
                        ],
                    ];
                    if (class_basename($getCallMethods['class']) == class_basename('StaffTeachSubjectController')) {
                        $data[$row['year']][$key]['action']['link'] = str_replace('teaching', 'study', $data[$row['year']][$key]['action']['link']);
                    }
                } else {
                    $data[$key] = [
                        'id'    => $row['id'],
                        'name'   => $study_subject['name'] . ' - (' . $row['year'] . ')',
                        'image'  => $study_subject['image'],
                    ];
                }
            }


            $response       = array(
                'success'   => true,
                'data'      => $data,
                'pages'     => $pages,
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


    public static function addToTable()
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormStaffTeachSubject::rulesField(), FormStaffTeachSubject::customMessages(), FormStaffTeachSubject::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            $exists = StaffTeachSubject::existsToTable(request('staff'), request('study_subject'), request('year'));
            if ($exists) {
                $response       = array(
                    'success'   => false,
                    'type'      => 'add',
                    'data'      => StaffTeachSubject::getData($exists->id)['data'],
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL .
                            Translator::phrase('already_exists'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            } else {
                try {

                    $values['staff_id']        = request('staff');
                    $values['study_subject_id'] = request('study_subject');
                    $values['year']       = trim(request('year'));
                    $add = StaffTeachSubject::insertGetId($values);
                    if ($add) {
                        $response       = array(
                            'success'   => true,
                            'type'      => 'add',
                            'data'      => StaffTeachSubject::getData($add)['data'],
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
                } catch (DomainException $e) {
                    $response       = Exception::exception($e);
                }
            }
        }
        return $response;
    }

    public static function updateToTable($id)
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormStaffTeachSubject::rulesField(), FormStaffTeachSubject::customMessages(), FormStaffTeachSubject::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            $exists = StaffTeachSubject::existsToTable(request('staff'), request('study_subject'), request('year'));
            if ($exists) {
                $response       = array(
                    'success'   => false,
                    'type'      => 'update',
                    'data'      => StaffTeachSubject::getData($exists->id)['data'],
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('update.unsuccessful') . PHP_EOL .
                            Translator::phrase('already_exists'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            } else {

                try {
                    $values['staff_id']        = request('staff');
                    $values['study_subject_id'] = request('study_subject');
                    $values['year']       = trim(request('year'));

                    $update = StaffTeachSubject::where('id', $id)->update($values);
                    if ($update) {

                        $response       = array(
                            'success'   => true,
                            'type'      => 'update',
                            'data'      => StaffTeachSubject::getData($id),
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

    public static function existsToTable($staff_id, $study_subject_id, $year)
    {
        return StaffTeachSubject::where('staff_id', $staff_id)
            ->where('study_subject_id', $study_subject_id)
            ->where('year', $year)
            ->first();
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StaffTeachSubject::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StaffTeachSubject::whereIn('id', $id)->delete();
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
