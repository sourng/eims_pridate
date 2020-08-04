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
use App\Http\Requests\FormStudentsRequest;

class StudentsRequest extends Model
{
    public static $path = [
        'image'  => 'request',
        'url'    => 'request',
        'view'   => 'StudentsRequest'
    ];

    public static function getData($id = null, $student_id = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Students::$path['url'] . '/'  . StudentsRequest::$path['url'] . '/add?ref='.request('ref')),
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

        $get = StudentsRequest::orderBy('id', $orderBy);


        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            if (request('ref') == StudentsStudyCourse::$path['url']) {
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
                $status = StudentsStudyCourse::where('student_request_id', $row['id'])->get()->first();
                if ($status) {
                    StudentsRequest::updateStatus($row['id'], 1);
                } else {
                    StudentsRequest::updateStatus($row['id'], 0);
                }
                $student = Students::getData($row['student_id'])['data'][0];
                $data[$key]         = array(
                    'id'              => $row['id'],
                    'name'            => $student['first_name'] . ' ' . $student['last_name'],
                    'student'         => $student,
                    'institute'            => Institute::getData($row['institute_id'])['data'][0],
                    'study_program'        => StudyPrograms::getData($row['study_program_id'])['data'][0],
                    'study_course'         => StudyCourse::getData($row['study_course_id'])['data'][0],
                    'study_generation'     => StudyGeneration::getData($row['study_generation_id'])['data'][0],
                    'study_academic_year'  => StudyAcademicYears::getData($row['study_academic_year_id'])['data'][0],
                    'study_semester'       => StudySemesters::getData($row['study_semester_id'])['data'][0],
                    'study_session'       => StudySession::getData($row['study_session_id'])['data'][0],
                    'description'   => $row['description'],
                    'status'        => $status ? Translator::phrase('approved') : Translator::phrase('requesting'),
                    'photo'         => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsRequest::$path['image'], $row['photo'])) : $student['photo'],
                    'action'        => [
                        'edit'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsRequest::$path['url'] . '/edit/' . $row['id']),
                        'view'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsRequest::$path['url'] . '/view/' . $row['id']),
                    ]
                );
                // if (class_basename($getCallMethods['class']) == class_basename('StudentController')) {
                //     $data[$key]['action'] = [
                //         'edit'           => url(Users::role() . '/study/' . StudentsRequest::$path['url'] . '/edit/' . $row['id']),
                //         'view'           => url(Users::role() . '/study/' . StudentsRequest::$path['url'] . '/view/' . $row['id']),
                //     ];
                // }

                if (request('ref') == StudentsStudyCourse::$path['url']) {
                    $data[$key]['name'] .= ' - ' . $data[$key]['study_course']['name'];
                    $data[$key]['name'] .= ' ( ' . $data[$key]['study_generation']['name'];
                    $data[$key]['name'] .= ' - ' . $data[$key]['study_academic_year']['name'];
                    $data[$key]['name'] .= ' - ' . $data[$key]['study_semester']['name'];
                    $data[$key]['name'] .= ' - ' . $data[$key]['study_session']['name'] . ')';
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

    public static function getDataTable()
    {
        $model = StudentsRequest::select((new StudentsRequest())->getTable() . '.*')
            ->join((new Students())->getTable(), (new Students())->getTable() . '.id', (new StudentsRequest())->getTable() . '.student_id');

        return DataTables::eloquent($model)
            ->filter(function ($query) {

                if (Auth::user()->role_id == 2) {
                    $query =  $query->where((new StudentsRequest())->getTable() . '.institute_id', Auth::user()->institute_id);
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
                $status = StudentsStudyCourse::where('student_request_id', $row['id'])->get()->first();
                $student = Students::where('id', $row['student_id'])->first()->toArray();
                return [
                    'id'              => $row['id'],
                    'name'                  => $student['first_name_km'] . ' ' . $student['last_name_km'] . ' - ' . $student['first_name_en'] . ' ' . $student['last_name_en'],
                    'institute'            => Institute::getData($row['institute_id'])['data'][0],
                    'study_program'        => StudyPrograms::getData($row['study_program_id'])['data'][0],
                    'study_course'         => StudyCourse::getData($row['study_course_id'])['data'][0],
                    'study_generation'     => StudyGeneration::getData($row['study_generation_id'])['data'][0],
                    'study_academic_year'  => StudyAcademicYears::getData($row['study_academic_year_id'])['data'][0],
                    'study_semester'       => StudySemesters::getData($row['study_semester_id'])['data'][0],
                    'study_session'       => StudySession::getData($row['study_session_id'])['data'][0],
                    'description'   => $row['description'],
                    'status'        => $status ? Translator::phrase('approved') : Translator::phrase('requesting'),
                    'photo'         => $row['photo'] ? (ImageHelper::site(Students::$path['image'] . '/' . StudentsRequest::$path['image'], $row['photo'])) : $student['photo'],
                    'action'        => [
                        'edit'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsRequest::$path['url'] . '/edit/' . $row['id']),
                        'view'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsRequest::$path['url'] . '/view/' . $row['id']),
                        'approve'           => url(Users::role() . '/' . Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/add?studRequestId=' . $row['id']),
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
        $validator          = Validator::make(request()->all(), FormStudentsRequest::rulesField(), FormStudentsRequest::customMessages(), FormStudentsRequest::attributeField());

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
                        'student_id'     => $id,
                        'institute_id'     => request('institute'),
                        'study_program_id'     => request('study_program'),
                        'study_course_id'     => request('study_course'),
                        'study_generation_id'     => request('study_generation'),
                        'study_academic_year_id'     => request('study_academic_year'),
                        'study_semester_id'     => request('study_semester'),
                        'study_session_id'     => request('study_session'),
                        'description' => request('description'),
                    ];

                    if (StudentsRequest::existsToTable($id)) {
                        $exists   = true;
                    } else {
                        $add = StudentsRequest::insertGetId($values);
                        if ($add) {
                            if (count(request('student')) == 1 && request()->hasFile('photo')) {
                                $image      = request()->file('photo');
                                StudentsRequest::updateImageToTable($add, ImageHelper::uploadImage($image, Students::$path['image'] . '/' . StudentsRequest::$path['image']));
                            }
                            $sid  .= $add . ',';
                        }
                    }
                }

                if ($sid) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => StudentsRequest::getData($sid)['data'],
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
        $validator          = Validator::make(request()->all(), FormStudentsRequest::rulesField(), FormStudentsRequest::customMessages(), FormStudentsRequest::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {
            try {

                if (StudentsRequest::where('id', $id)->first()->status == 1) {
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
                    $exists = StudentsRequest::existsToTable($id);
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
                        $update = StudentsRequest::where('id', $id)->update([
                            'institute_id'     => request('institute'),
                            'study_program_id'     => request('study_program'),
                            'study_course_id'     => request('study_course'),
                            'study_generation_id'     => request('study_generation'),
                            'study_academic_year_id'   => request('study_academic_year'),
                            'study_semester_id'     => request('study_semester'),
                            'study_session_id'     => request('study_session'),
                            'description' => request('description'),
                        ]);
                        if ($update) {
                            if (request()->hasFile('photo')) {
                                $image      = request()->file('photo');
                                StudentsRequest::updateImageToTable($id, ImageHelper::uploadImage($image, Students::$path['url'] . '/' . StudentsRequest::$path['image']));
                            }
                            $response       = array(
                                'success'   => true,
                                'type'      => 'update',
                                'data'      => StudentsRequest::getData($id)['data'],
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
        return StudentsRequest::where('id', $id)->update([
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
                $update =  StudentsRequest::where('id', $id)->update([
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
        return StudentsRequest::where('student_id', $student_id)
            ->where('institute_id', request('institute'))
            ->where('study_program_id', request('study_program'))
            ->where('study_course_id', request('study_course'))
            ->where('study_generation_id', request('study_generation'))
            ->where('study_academic_year_id', request('study_academic_year'))
            ->where('study_semester_id', request('study_semester'))
            ->where('study_session_id', request('study_session'))
            ->get()->toArray();
    }

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudentsRequest::whereIn('id', $id)->get()->toArray()) {

                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudentsRequest::whereIn('id', $id)->where('status', 0)->delete();
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
