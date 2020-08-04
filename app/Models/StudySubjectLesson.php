<?php

namespace App\Models;

use Embed\Embed;
use DomainException;
use App\Helpers\Exception;
use App\Helpers\FileHelper;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormStudySubjectLesson;

class StudySubjectLesson extends Model
{
    public static $path = [
        'image'   => 'study-subject-lesson',
        'file'   => 'study-subject-lesson',
        'url'    => 'subject-lesson',
        'view'   => 'StudySubjectLesson'
    ];

    public static function getData($id = null, $staff_teach_subject_id = null, $paginate = null, $groupByStaffTeachSubjectId = true)
    {


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
            $get = StudySubjectLesson::orderBy('id', $orderBy);
        } else {
            $get = StudySubjectLesson::orderBy('id', 'DESC');
        }


        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            if ($staff_teach_subject_id) {
                $get = $get->where('staff_teach_subject_id', $staff_teach_subject_id);
            }
        }


        $pages = [];
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
                    'staff_teach_subject'      => StaffTeachSubject::getData($row['staff_teach_subject_id'])['data'][0],
                    'title'                    => $row['title'],
                    'source_file'              => FileHelper::site(StudySubjectLesson::$path['file'], $row['source_file']),
                    'source_file_info'         => FileHelper::getFileInfo(StudySubjectLesson::$path['file'], $row['source_file']),
                    'source_link'              => $row['source_link'] ? json_decode($row['source_link'], true) : [],
                    'image'                   => $row['image'] ? (ImageHelper::site(StudySubjectLesson::$path['image'], $row['image'])) : asset('/assets/img/icons/pdf.png'),
                    'action'                   => [
                        'edit' => url(Users::role() . '/teaching/' . StudySubjectLesson::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/teaching/' . StudySubjectLesson::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/teaching/' . StudySubjectLesson::$path['url'] . '/delete/' . $row['id']), //?id
                    ]
                );
                if ($data[$key]['source_link']['facebook']) {
                    $fb =  Embed::create($data[$key]['source_link']['facebook']);
                    $data[$key]['source_link']['facebook'] = [
                        'iframe' => $fb->getCode(),
                        'url' => $fb->getUrl(),
                    ];
                }

                if ($data[$key]['source_link']['youtube']) {
                    $yt =  Embed::create($data[$key]['source_link']['youtube']);
                    $data[$key]['source_link']['youtube'] = [
                        'iframe' => $yt->getCode(),
                        'url' => $yt->getUrl(),
                    ];
                }


                if (request('ref') == StudySubjectLesson::$path['url']) {
                    $data[$key]['action'] = [
                        'edit' => url(Users::role() . '/study/' . StudySubjectLesson::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/study/' . StudySubjectLesson::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/study/' . StudySubjectLesson::$path['url'] . '/delete/' . $row['id']), //?id
                    ];
                }
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['title'],
                    'image'  => $data[$key]['image'],
                    'action' => $data[$key]['action'],

                );
            }



            $response       = array(
                'success'   => true,
                'data'      => $data,
                'pages'      => $pages,

            );
        } else {
            $response = array(
                'success'   => false,
                'data'      => [],
                'pages'      => $pages,
                'message'   => Translator::phrase('no_data'),
            );
        }

        return $response;
    }

    public static function getDataTable()
    {

        $model = StudySubjectLesson::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $action = [
                    'edit' => url(Users::role() . '/teaching/' . StudySubjectLesson::$path['url'] . '/edit/' . $row['id']), //?id
                    'view' => url(Users::role() . '/teaching/' . StudySubjectLesson::$path['url'] . '/view/' . $row['id']), //?id
                    'delete' => url(Users::role() . '/teaching/' . StudySubjectLesson::$path['url'] . '/delete/' . $row['id']), //?id
                ];

                if (request('ref') == StudySubjectLesson::$path['url']) {
                    $action['edit'] = str_replace('teaching', 'study', $action['edit']);
                    $action['view'] = str_replace('teaching', 'study', $action['view']);
                    $action['delete'] = str_replace('teaching', 'study', $action['delete']);
                }
                return [
                    'id'                       => $row['id'],
                    'staff_teach_subject'      => StaffTeachSubject::getData($row['staff_teach_subject_id'])['data'][0],
                    'title'                    => $row['title'],
                    'source_file'              => FileHelper::site(StudySubjectLesson::$path['file'], $row['source_file']),
                    'source_file_info'         => FileHelper::getFileInfo(StudySubjectLesson::$path['file'], $row['source_file']),
                    'source_link'              => $row['source_link'] ? json_decode($row['source_link'], true) : [],
                    'image'                   => $row['image'] ? (ImageHelper::site(StudySubjectLesson::$path['image'], $row['image'])) : asset('/assets/img/icons/pdf.png'),
                    'action'                   => $action,

                ];
            })
            ->filter(function ($query) {

                if (request('t-subjectId')) {
                    $query =  $query->where('staff_teach_subject_id', request('t-subjectId'));
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

        if (!request()->hasFile('source_file')) {
            return array(
                'success'   => false,
                'type'      => 'add',
                'message'   => array(
                    'title' => Translator::phrase('error'),
                    'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL
                        . Translator::phrase('( .File. ) .empty'),
                    'button'   => array(
                        'confirm' => Translator::phrase('ok'),
                        'cancel'  => Translator::phrase('cancel'),
                    ),
                ),
            );
        }

        $response           = array();
        $validator          = Validator::make(request()->all(), FormStudySubjectLesson::rulesField(), FormStudySubjectLesson::customMessages(), FormStudySubjectLesson::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $values['title']                    = trim(request('title'));
                $values['staff_teach_subject_id']    =  request('staff_teach_subject');
                $values['source_link']         = json_encode([
                    'youtube'   => request('source_link_youtube'),
                    'facebook'   => request('source_link_facebook'),
                ]);

                $add = StudySubjectLesson::insertGetId($values);
                if ($add) {
                    if (request()->hasFile('source_file')) {
                        $file      = request()->file('source_file');
                        StudySubjectLesson::updateFileToTable($add, FileHelper::uploadFile($file, StudySubjectLesson::$path['file']));
                    }
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        StudySubjectLesson::updateImageToTable($add, ImageHelper::uploadImage($image, StudySubjectLesson::$path['image']));
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => StudySubjectLesson::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormStudySubjectLesson::rulesField(), FormStudySubjectLesson::customMessages(), FormStudySubjectLesson::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['title']               = trim(request('title'));
                $values['staff_teach_subject_id']    =  request('staff_teach_subject');
                $values['source_link']         = json_encode([
                    'youtube'   => request('source_link_youtube'),
                    'facebook'   => request('source_link_facebook'),
                ]);
                $update = StudySubjectLesson::where('id', $id)->update($values);
                if ($update) {
                    if (request()->hasFile('source_file')) {
                        $file      = request()->file('source_file');
                        StudySubjectLesson::updateFileToTable($id, FileHelper::uploadFile($file, StudySubjectLesson::$path['file']));
                    }
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        StudySubjectLesson::updateImageToTable($id, ImageHelper::uploadImage($image, StudySubjectLesson::$path['image']));
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

    public static function updateFileToTable($id, $source_file)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($source_file) {
            try {
                $update =  StudySubjectLesson::where('id', $id)->update([
                    'source_file'    => $source_file,
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

    public static function updateImageToTable($id, $image)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  StudySubjectLesson::where('id', $id)->update([
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
            if (StudySubjectLesson::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = StudySubjectLesson::whereIn('id', $id)->delete();
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
