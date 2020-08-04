<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FormStudyCourse;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StudyCourse extends Model
{
    public static $path = [
        'image'  => 'study-course',
        'url'    => 'course',
        'view'   => 'StudyCourse'
    ];



    public static function getData($id = null, $edit = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/add/'),
            ),
        );
        $data = array();


        $type   = request('typeId');
        $program   = request('programId');
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
        $get = StudyCourse::orderBy('id', $orderBy);
        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            
            

            if ($program) {
                $get = $get->where('study_program_id', $program);
            }

            if(request('instituteId')){
                $get = $get->where('institute_id',request('instituteId'));
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
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                foreach ($get as $key => $row) {
                    $data[$key] = [
                        'id'                      => $row['id'],
                        '_name'                   => $row['en'],
                        'name'                    => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                        'study_program'           => $row['study_program_id'] == null ? null : StudyPrograms::getData($row['study_program_id'])['data'][0],
                        'study_generation'        => $row['study_generation_id'] == null ? null : StudyGeneration::getData($row['study_generation_id'])['data'][0],
                        'image'         =>  $row['image'] ? (ImageHelper::site(StudyCourse::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    ];

                    if (request('ref') != StudentsStudyCourse::$path['image'] . '-certificate') {
                        if ($data[$key]['study_program']) {
                            $data[$key]['_name'] =  $data[$key]['_name'] . ' - ' . $data[$key]['study_program']['name'];
                        }

                        $data[$key]['name'] = $data[$key]['_name'];
                    }
                }
            } else {

                foreach ($get as $key => $row) {
                    $data[$key]                   = array(
                        'id'                      => $row['id'],
                        'name'                    => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                        '_name'                   => $row['en'],
                        'description'             => $row['description'],
                        'institute'               => $row['institute_id'] == null ? null : Institute::getData($row['institute_id'])['data'][0],
                        'study_faculty'           => $row['study_faculty_id'] == null ? null : StudyFaculty::getData($row['study_faculty_id'])['data'][0],
                        'course_type'             => $row['course_type_id'] == null ? null : CourseTypes::getData($row['course_type_id'])['data'][0],
                        'study_modality'          => $row['study_modality_id'] == null ? null : StudyModality::getData($row['study_modality_id'])['data'][0],
                        'study_program'           => $row['study_program_id'] == null ? null : StudyPrograms::getData($row['study_program_id'])['data'][0],
                        'study_overall_fund'      => $row['study_overall_fund_id'] == null ? null : StudyOverallFund::getData($row['study_overall_fund_id'])['data'][0],
                        'curriculum_author'       => $row['curriculum_author_id'] == null ? null : CurriculumAuthor::getData($row['curriculum_author_id'])['data'][0],
                        'curriculum_endorsement'  => $row['curriculum_endorsement_id'] == null ? null : CurriculumEndorsement::getData($row['curriculum_endorsement_id'])['data'][0],

                        'image'         =>  $row['image'] ? (ImageHelper::site(StudyCourse::$path['image'], $row['image'])) : ImageHelper::prefix(),
                        'action'                   => [
                            'edit' => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/edit/' . $row['id']), //?id
                            'view' => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/view/' . $row['id']), //?id
                            'delete' => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/delete/' . $row['id']), //?id
                        ]
                    );

                    if (request('ref') != StudentsStudyCourse::$path['image'] . '-certificate') {
                        if ($data[$key]['study_program']) {
                            $data[$key]['_name'] =  $data[$key]['_name'] . ' - ' . $data[$key]['study_program']['name'];
                        }
                    }
                    if (request('ref') == Students::$path['url'] . '-' . StudentsRequest::$path['url']) {
                        $data[$key]['name'] = $data[$key]['_name'];
                    }

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
        $model = StudyCourse::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'                      => $row['id'],
                    'name'                    => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    '_name'                   => $row['en'],
                    'description'             => $row['description'],
                    'institute'               => $row['institute_id'] == null ? null : Institute::getData($row['institute_id'])['data'][0],
                    'study_faculty'           => $row['study_faculty_id'] == null ? null : StudyFaculty::getData($row['study_faculty_id'])['data'][0],
                    'course_type'             => $row['course_type_id'] == null ? null : CourseTypes::getData($row['course_type_id'])['data'][0],
                    'study_modality'          => $row['study_modality_id'] == null ? null : StudyModality::getData($row['study_modality_id'])['data'][0],
                    'study_program'           => $row['study_program_id'] == null ? null : StudyPrograms::getData($row['study_program_id'])['data'][0],
                    'study_overall_fund'      => $row['study_overall_fund_id'] == null ? null : StudyOverallFund::getData($row['study_overall_fund_id'])['data'][0],
                    'curriculum_author'       => $row['curriculum_author_id'] == null ? null : CurriculumAuthor::getData($row['curriculum_author_id'])['data'][0],
                    'curriculum_endorsement'  => $row['curriculum_endorsement_id'] == null ? null : CurriculumEndorsement::getData($row['curriculum_endorsement_id'])['data'][0],

                    'image'         =>  $row['image'] ? (ImageHelper::site(StudyCourse::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'                   => [
                        'edit' => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/study/' . StudyCourse::$path['url'] . '/delete/' . $row['id']), //?id
                    ]

                ];
            })
            ->filter(function ($query) {

                if(request('instituteId')){
                    $query = $query->where('institute_id',request('instituteId'));
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
        $validator          = Validator::make(request()->all(), FormStudyCourse::rulesField(), FormStudyCourse::customMessages(), FormStudyCourse::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['institute_id']                 = request('institute');
                $values['name']                         = trim(request('name'));
                $values['study_faculty_id']             = request('study_faculty');
                $values['course_type_id']               = request('course_type');
                $values['study_modality_id']            = request('study_modality');
                $values['study_program_id']             = request('study_program');
                $values['study_overall_fund_id']        = request('study_overall_fund');
                $values['curriculum_author_id']         = request('curriculum_author');
                $values['curriculum_endorsement_id']    = request('curriculum_endorsement');
                $values['description']                  = trim(request('description'));
                $values['image']                        = null;

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                $add = StudyCourse::insertGetId($values);
                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        StudyCourse::updateImageToTable($add, ImageHelper::uploadImage($image, StudyCourse::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, StudyCourse::$path['image'], StudyCourse::$path['image'], public_path('/assets/img/icons/image.jpg', null, true));
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => StudyCourse::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormStudyCourse::rulesField(), FormStudyCourse::customMessages(), FormStudyCourse::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['institute_id']                 = request('institute');
                $values['name']                         = trim(request('name'));
                $values['study_faculty_id']             = request('study_faculty');
                $values['course_type_id']               = request('course_type');
                $values['study_modality_id']            = request('study_modality');
                $values['study_program_id']             = request('study_program');
                $values['study_overall_fund_id']        = request('study_overall_fund');
                $values['curriculum_author_id']         = request('curriculum_author');
                $values['curriculum_endorsement_id']    = request('curriculum_endorsement');
                $values['description']                  = trim(request('description'));

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                $update = StudyCourse::where('id', $id)->update($values);
                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        StudyCourse::updateImageToTable($id, ImageHelper::uploadImage($image, StudyCourse::$path['image']));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => StudyCourse::getData($id),
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

    public static function updateImageToTable($id, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  StudyCourse::where('id', $id)->update([
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
            if (StudyCourse::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudyCourse::whereIn('id', $id)->delete();
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
