<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\FileHelper;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\FormStudySubjects;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StudySubjects extends Model
{
    public static $path = [
        'image'  => 'study-subject',
        'file'  => 'study-subject',
        'url'    => 'subject',
        'view'   => 'StudySubject'
    ];

    protected $fillable = [
        'name', 'image',
    ];


    public static function getData($id = null, $edit = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/add/'),
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
        $get = StudySubjects::orderBy('id', $orderBy);
        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            if (request('instituteId')) {
                $get = $get->where('institute_id', request('instituteId'));
            }
            if (request('courseTId')) {
                $get = $get->where('course_type_id', request('courseTId'));
            }
        }
        if ($search) {
            $get = $get->where('name', 'LIKE', '%' . $search . '%');
            if (config('app.languages')) {
                foreach (config('app.languages') as $lang) {
                    $get = $get->orWhere($lang['code_name'], 'LIKE', '%' . $search . '%');
                }
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
                $data[$key]                       = array(
                    'id'                       => $row['id'],
                    'name'                     => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'course_type'              => CourseTypes::getData($row['course_type_id'])['data'][0],
                    'full_mark_theory'         => $row['full_mark_theory'],
                    'pass_mark_theory'         => $row['pass_mark_theory'],
                    'full_mark_practical'      => $row['full_mark_practical'],
                    'pass_mark_practical'      => $row['pass_mark_practical'],
                    'credit_hour'              => $row['credit_hour'],
                    'description'              => $row['description'],
                    'file'                     => $row['file'] ? FileHelper::site(StudySubjects::$path['file'], $row['file']) : $row['file'],
                    'image'                    =>  $row['image'] ? (ImageHelper::site(StudySubjects::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'                   => [
                        'edit' => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/delete/' . $row['id']), //?id
                    ]
                );
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => $data[$key]['image'],
                    'action' => $data[$key]['action'],

                );
                if ($edit) {
                    $data[$key]['name'] =  $row['name'];
                    if (config('app.languages')) {
                        foreach (config('app.languages') as $lang) {
                            $data[$key][$lang['code_name']] = $row[$lang['code_name']];
                        }
                    }
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

    public static function getDataTable()
    {
        $model = StudySubjects::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'                       => $row['id'],
                    'name'                     => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'course_type'              => CourseTypes::getData($row['course_type_id'])['data'][0],
                    'full_mark_theory'         => $row['full_mark_theory'],
                    'pass_mark_theory'         => $row['pass_mark_theory'],
                    'full_mark_practical'      => $row['full_mark_practical'],
                    'pass_mark_practical'      => $row['pass_mark_practical'],
                    'credit_hour'              => $row['credit_hour'],
                    'description'              => $row['description'],
                    'image'                    => $row['image'] ? (ImageHelper::site(StudySubjects::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'file'                     => $row['file'] ? FileHelper::site(StudySubjects::$path['file'], $row['file']) : $row['file'],
                    'action'                   => [
                        'edit' => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/study/' . StudySubjects::$path['url'] . '/delete/' . $row['id']), //?id
                    ]

                ];
            })
            ->filter(function ($query) {

                if (request('instituteId')) {
                    $query = $query->where('institute_id', request('instituteId'));
                }
                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name') {
                                $query =  $query->where(function ($q) {
                                    $q->where('name', 'LIKE', '%' . request('search.value') . '%');
                                    if (config('app.languages')) {
                                        foreach (config('app.languages') as $lang) {
                                            $q->orWhere($lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                        }
                                    }
                                });
                            } elseif ($value['data'] == 'description') {
                                $query->orWhere('description', 'LIKE', '%' . request('search.value') . '%');
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
        $validator          = Validator::make(request()->all(), FormStudySubjects::rulesField(), FormStudySubjects::customMessages(), FormStudySubjects::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['institute_id']      = request('institute');
                $values['course_type_id']      = request('course_type');
                $values['name']                = trim(request('name'));
                $values['full_mark_theory']    =  request('full_mark_theory');
                $values['pass_mark_theory']    =  request('pass_mark_theory');
                $values['full_mark_practical'] =  request('full_mark_practical');
                $values['pass_mark_practical'] =  request('pass_mark_practical');
                $values['credit_hour']         =  request('credit_hour');
                $values['description']         = trim(request('description'));


                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                if (request()->hasFile('file')) {
                    $file      = request()->file('file');
                    $values['file'] = FileHelper::uploadFile($file, StudySubjects::$path['file']);
                }
                $add = StudySubjects::insertGetId($values);
                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        StudySubjects::updateImageToTable($add, ImageHelper::uploadImage($image, StudySubjects::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, StudySubjects::$path['image'], null, public_path('/assets/img/icons/image.jpg'));
                    }



                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => StudySubjects::getData($add)['data'],
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
        return $response;
    }


    public static function updateToTable($id)
    {

        $response           = array();
        $validator          = Validator::make(request()->all(), FormStudySubjects::rulesField(), FormStudySubjects::customMessages(), FormStudySubjects::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['institute_id']      = request('institute');
                $values['course_type_id']      = request('course_type');
                $values['name']                = trim(request('name'));
                $values['full_mark_theory']    =  request('full_mark_theory');
                $values['pass_mark_theory']    =  request('pass_mark_theory');
                $values['full_mark_practical'] =  request('full_mark_practical');
                $values['pass_mark_practical'] =  request('pass_mark_practical');
                $values['credit_hour']         =  request('credit_hour');
                $values['description']         = trim(request('description'));

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                if (request()->hasFile('file')) {
                    $file      = request()->file('file');
                    $values['file'] = FileHelper::uploadFile($file, StudySubjects::$path['file']);
                }
                $update = StudySubjects::where('id', $id)->update($values);
                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        StudySubjects::updateImageToTable($id, ImageHelper::uploadImage($image, StudySubjects::$path['image']));
                    }
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

    public static function updateImageToTable($id, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  StudySubjects::where('id', $id)->update([
                    'image'    => $image,
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

    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (StudySubjects::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudySubjects::whereIn('id', $id)->delete();
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
