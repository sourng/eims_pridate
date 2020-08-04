<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStudentsShortCourseRequest;

class StudentsShortCourseRequest extends Model
{
    public static $path = [
        'image'  => 'short-course-request',
        'url'    => 'short-course-request',
        'view'   => 'StudentsShortCourseRequest'
    ];

    public static function getData($id = null, $student_id = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Students::$path['url'] . '/'  . StudentsShortCourseRequest::$path['url'] . '/add?ref=' . request('ref')),
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

        $get = StudentsShortCourseRequest::select((new StudentsShortCourseRequest())->getTable() . '.*')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', (new StudentsShortCourseRequest())->getTable() . '.student_id')
            ->orderBy((new StudentsShortCourseRequest())->getTable() . '.id', $orderBy);



        if ($id) {
            $get = $get->whereIn((new StudentsShortCourseRequest())->getTable() . '.id', $id);
        } else {
            if (request('ref') == StudentsStudyShortCourse::$path['url']) {
                $get = $get->where('status', 0);
            }
            if ($student_id) {
                $get = $get->where('student_id', $student_id);
            }
            if (Auth::user()->role_id == 2) {
                $get = $get->where('institute_id', Auth::user()->institute_id);
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
                $status = StudentsStudyShortCourse::where('stu_sh_c_request_id', $row['id'])->get()->first();
                if ($status) {
                    StudentsShortCourseRequest::updateStatus($row['id'], 1);
                } else {
                    StudentsShortCourseRequest::updateStatus($row['id'], 0);
                }
                $student = Students::where('id', $row['student_id'])->first(['first_name_km', 'last_name_km', 'first_name_en', 'last_name_en', 'email', 'phone', 'photo'])->toArray();

                $action = [
                    'edit'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'] . '/edit/' . $row['id']),
                    'view'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'] . '/view/' . $row['id']),
                    'approve'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/add?studRequestId=' . $row['id']),
                    'delete'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'] . '/delete/' . $row['id']),
                ];
                if (request('ref') == Students::$path['url'] . '-' . StudentsShortCourseRequest::$path['url']) {
                    $action['view'] = str_replace(Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'], 'study' . '/' . StudentsShortCourseRequest::$path['url'], $action['view']);
                    $action['edit'] = str_replace(Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'], 'study' . '/' . StudentsShortCourseRequest::$path['url'], $action['edit']);
                    $action['delete'] = str_replace(Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'], 'study' . '/' . StudentsShortCourseRequest::$path['url'], $action['delete']);
                }

                $data[$key]         = array(
                    'id'              => $row['id'],
                    'name'              => $student['first_name_km'] . ' ' . $student['last_name_km'] . ' - ' . $student['first_name_en'] . ' ' . $student['last_name_en'],
                    'email'             => $student['email'],
                    'phone'             => $student['phone'],
                    'institute'            => Institute::getData($row['institute_id'])['data'][0],
                    'study_subject'       => StudySubjects::getData($row['study_subject_id'])['data'][0],
                    'study_session'       => StudySession::getData($row['study_session_id'])['data'][0],
                    'description'   => $row['description'],
                    'status'        => $status ? Translator::phrase('approved') : Translator::phrase('requesting'),
                    'photo'         => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsShortCourseRequest::$path['image'], $row['photo'])) : ImageHelper::site(Students::$path['image'], $student['photo']),
                    'action'        => $action
                );

                if (request('ref') == StudentsStudyShortCourse::$path['url']) {
                    $data[$key]['name'] .= ' - (' . $data[$key]['study_subject']['name'] . ')';
                    $data[$key]['name'] .= ' (' . $data[$key]['study_session']['name'] . ')';
                }


                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => $data[$key]['photo'],
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

    public static function getDataTable($student_id = null)
    {

        $model = StudentsShortCourseRequest::select((new StudentsShortCourseRequest())->getTable() . '.*')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', (new StudentsShortCourseRequest())->getTable() . '.student_id');

        return DataTables::eloquent($model)
            ->filter(function ($query)  use ($student_id) {

                if (Auth::user()->role_id == 2) {
                    $query =  $query->where((new StudentsShortCourseRequest())->getTable() . '.institute_id', Auth::user()->institute_id);
                }

                if ($student_id) {
                    $query =  $query->where((new StudentsShortCourseRequest())->getTable() . '.student_id', $student_id);
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
                $status = StudentsStudyShortCourse::where('stu_sh_c_request_id', $row['id'])->get()->first();
                $student = Students::where('id', $row['student_id'])->first(['first_name_km', 'last_name_km', 'first_name_en', 'last_name_en', 'email', 'phone', 'photo'])->toArray();

                $action = [
                    'edit'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'] . '/edit/' . $row['id']),
                    'view'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'] . '/view/' . $row['id']),
                    'approve'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyShortCourse::$path['url'] . '/add?studRequestId=' . $row['id']),
                    'delete'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'] . '/delete/' . $row['id']),
                ];
                if (request('ref') == Students::$path['url'] . '-' . StudentsShortCourseRequest::$path['url']) {
                    $action['view'] = str_replace(Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'], 'study' . '/' .  StudentsShortCourseRequest::$path['url'], $action['view']);
                    $action['edit'] = str_replace(Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'], 'study' . '/' .  StudentsShortCourseRequest::$path['url'], $action['edit']);
                    $action['delete'] = str_replace(Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['url'], 'study' . '/' .  StudentsShortCourseRequest::$path['url'], $action['delete']);
                }

                return [
                    'id'              => $row['id'],
                    'name'                  => $student['first_name_km'] . ' ' . $student['last_name_km'] . ' - ' . $student['first_name_en'] . ' ' . $student['last_name_en'],
                    'email'         => $student['email'],
                    'phone'         => $student['phone'],
                    'institute'            => Institute::getData($row['institute_id'])['data'][0],
                    'study_subject'       => StudySubjects::getData($row['study_subject_id'])['data'][0],
                    'study_session'       => StudySession::getData($row['study_session_id'])['data'][0],
                    'description'   => $row['description'],
                    'status'        => $status ? Translator::phrase('approved') : Translator::phrase('requesting'),
                    'photo'         => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsShortCourseRequest::$path['image'], $row['photo'])) : ImageHelper::site(Students::$path['image'], $student['photo']),
                    'action'        => $action
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
        $validator          = Validator::make(request()->all(), FormStudentsShortCourseRequest::rulesField('.*'), FormStudentsShortCourseRequest::customMessages('.*'), FormStudentsShortCourseRequest::attributeField('.*'));

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {
                $sid      = '';
                $exists   = null;
                foreach (request('student', []) as $key => $id) {
                    $values = [
                        'added_by'       => Auth::user()->id,
                        'student_id'     => $id,
                        'institute_id'     => request('institute'),
                        'study_subject_id'     => request('study_subject'),
                        'study_session_id'     => request('study_session'),
                        'description' => request('description'),
                    ];

                    if (StudentsShortCourseRequest::existsToTable($id)) {
                        $exists   = true;
                    } else {
                        $add = StudentsShortCourseRequest::insertGetId($values);
                        if ($add) {
                            if (count(request('student')) == 1 && request()->hasFile('photo')) {
                                $image      = request()->file('photo');
                                StudentsShortCourseRequest::updateImageToTable($add, ImageHelper::uploadImage($image, Students::$path['image'] . '/' . StudentsShortCourseRequest::$path['image']));
                            }
                            $sid  .= $add . ',';
                        }
                    }
                }

                if ($sid) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => StudentsShortCourseRequest::getData($sid)['data'],
                        'message'   => array(
                            'title' => Translator::phrase('success'),
                            'text'  => Translator::phrase('add.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                } elseif ($exists) {
                    $response       = array(
                        'success'   => false,
                        'type'      => 'add',
                        'data'      => [],
                        'message'   => array(
                            'title' => Translator::phrase('error'),
                            'text'  => Translator::phrase('already_exists'),
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
        $validator          = Validator::make(request()->all(), FormStudentsShortCourseRequest::rulesField('.*'), FormStudentsShortCourseRequest::customMessages('.*'), FormStudentsShortCourseRequest::attributeField('.*'));

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {

                if (StudentsShortCourseRequest::where('id', $id)->first()->status == 1) {
                    $response       =  array(
                        'success'   => false,
                        'message'   => array(
                            'title' => Translator::phrase('error.!'),
                            'text'  => Translator::phrase('can_not.edit.or.delete') . PHP_EOL
                                . Translator::phrase('(.approved.)'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                } else {
                    $exists = StudentsShortCourseRequest::existsToTable($id);
                    if ($exists) {
                        $response       = array(
                            'success'   => false,
                            'type'      => 'update',
                            'data'      => [],
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
                        $update = StudentsShortCourseRequest::where('id', $id)->update([
                            'updated_by'       => Auth::user()->id,
                            'institute_id'     => request('institute'),
                            'study_subject_id'     => request('study_subject'),
                            'study_session_id'     => request('study_session'),
                            'description' => request('description'),
                        ]);
                        if ($update) {
                            if (request()->hasFile('photo')) {
                                $image      = request()->file('photo');
                                StudentsShortCourseRequest::updateImageToTable($id, ImageHelper::uploadImage($image, Students::$path['url'] . '/' . StudentsShortCourseRequest::$path['image']));
                            }
                            $response       = array(
                                'success'   => true,
                                'type'      => 'update',
                                'data'      => StudentsShortCourseRequest::getData($id)['data'],
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
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }
    public static function updateStatus($id, $status)
    {
        return StudentsShortCourseRequest::where('id', $id)->update([
            'updated_by'       => Auth::user()->id,
            'status' => $status
        ]);
    }


    public static function updateImageToTable($id, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  StudentsShortCourseRequest::where('id', $id)->update([
                    'photo'    => $image,
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

    public static function existsToTable($student_id)
    {
        return StudentsShortCourseRequest::where('student_id', $student_id)
            ->where('institute_id', request('institute'))
            ->where('study_subject_id', request('study_subject'))
            ->where('study_session_id', request('study_session'))
            ->get()->toArray();
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudentsShortCourseRequest::whereIn('id', $id)->get()->toArray()) {

                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudentsShortCourseRequest::whereIn('id', $id)->where('status', 0)->delete();
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
                        } else {

                            if (count($id) == 1) {

                                $response       =  array(
                                    'success'   => false,
                                    'message'   => array(
                                        'title' => Translator::phrase('error.!'),
                                        'text'  => Translator::phrase('can_not.edit.or.delete') . PHP_EOL
                                            . Translator::phrase('(.approved.)'),
                                        'button'   => array(
                                            'confirm' => Translator::phrase('ok'),
                                            'cancel'  => Translator::phrase('cancel'),
                                        ),
                                    ),
                                );
                            }
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
