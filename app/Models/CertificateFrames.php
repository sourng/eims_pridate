<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Http\Requests\FormCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CertificateFrames extends Model
{
    public static $path = [
        'image'  => 'certificate',
        'url'    => 'certificate',
        'view'   => 'Certificate'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/add/'),
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
        $get = CertificateFrames::orderBy('id', $orderBy);
        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
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
                $data[$key] = array(
                    'id'            => $row['id'],
                    'type'          => $edit ? $row['type'] : Translator::phrase($row['type']),
                    'name'          => $row['name'],
                    'front'         => ImageHelper::site(CertificateFrames::$path['image'], $row['front']),
                    'front_o'         => ImageHelper::site(CertificateFrames::$path['image'], $row['front'], 'original'),
                    'background'    => ImageHelper::site(CertificateFrames::$path['image'], $row['background']),
                    'layout'        => $edit ? $row['layout'] : Translator::phrase($row['layout']),
                    'description'   => $row['description'],
                    'status'        => $row['status'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'action'                   => [
                        'set' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/set/' . $row['id']), //?id
                        'edit' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/delete/' . $row['id']), //?id
                    ]
                );
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => $data[$key]['front'],
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
        $model = CertificateFrames::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {

                $row = $row->toArray();
                return [
                    'id'            => $row['id'],
                    'type'          => Translator::phrase($row['type']),
                    'name'          => $row['name'],
                    'front'         => ImageHelper::site(CertificateFrames::$path['image'], $row['front']),
                    'front_o'         => ImageHelper::site(CertificateFrames::$path['image'], $row['front'], 'original'),
                    'background'    => ImageHelper::site(CertificateFrames::$path['image'], $row['background']),
                    'layout'        => Translator::phrase($row['layout']),
                    'description'   => $row['description'],
                    'status'        => $row['status'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'action'                   => [
                        'set' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/set/' . $row['id']), //?id
                        'edit' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . CertificateFrames::$path['url'] . '/delete/' . $row['id']), //?id
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
                                });
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

        if (!request()->hasFile('front')) {
            return array(
                'success'   => false,
                'type'      => 'add',
                'message'   => array(
                    'title' => Translator::phrase('error'),
                    'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL
                        . Translator::phrase('( .frame_front. ) .empty'),
                    'button'   => array(
                        'confirm' => Translator::phrase('ok'),
                        'cancel'  => Translator::phrase('cancel'),
                    ),
                ),
            );
        }
        $response           = array();
        $validator          = Validator::make(request()->all(), FormCard::rulesField(), FormCard::customMessages(), FormCard::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));



                $add = CertificateFrames::insertGetId($values);
                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        CertificateFrames::updateImageToTable($add, ImageHelper::uploadImage($image, CertificateFrames::$path['image']), 'front');
                    } else {
                        ImageHelper::uploadImage(false, CertificateFrames::$path['image'], CertificateFrames::$path['image'], public_path('/assets/img/icons/image.jpg'));
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => CertificateFrames::getData($add),
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
        $validator          = Validator::make(request()->all(), FormCard::rulesField(), FormCard::customMessages(), FormCard::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));

                $update = CertificateFrames::where('id', $id)->update($values);
                if ($update) {
                    if (request()->hasFile('front')) {
                        $image      = request()->file('front');
                        CertificateFrames::updateImageToTable($id, ImageHelper::uploadImage($image, CertificateFrames::$path['image']), 'front');
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => CertificateFrames::getData($id),
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

    public static function updateImageToTable($id, $image, $column)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($image) {
            try {
                $update =  CertificateFrames::where('id', $id)->update([
                    $column   => $image,
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


    public static function frameData($get = 'all')
    {
        if ($get == 'all') {
            $get = array(
                'id'           => Translator::phrase('id'),
                'fullname'     => Translator::phrase('fullname'),
                '_fullname'    => Translator::phrase('fullname.as.en'),
                'photo'        => Translator::phrase('photo'),
                'program'       => Translator::phrase('study_program'),
                '_program'       => Translator::phrase('study_program.as.en'),
                'course'       => Translator::phrase('course'),
                '_course'       => Translator::phrase('course.as.en'),
                'dob'       => Translator::phrase('dob'),
                '_dob'       => Translator::phrase('dob.as.en'),
            );
        } else if ($get == 'selected') {
            $get = array(
                'id'           => Translator::phrase('id'),
                'fullname'     => Translator::phrase('fullname'),
                '_fullname'    => Translator::phrase('fullname.en'),
                'photo'        => Translator::phrase('photo'),
                'program'       => Translator::phrase('study_program'),
                '_program'       => Translator::phrase('study_program.as.en'),
                'course'       => Translator::phrase('course'),
                '_course'       => Translator::phrase('course.as.en'),
                'dob'       => Translator::phrase('dob'),
                '_dob'       => Translator::phrase('dob.as.en'),

            );
        } else {
            $get = [];
        }
        return $get;
    }

    public static function setToTable($id)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($id && request()->ajax()) {
            if (request()->method() == 'POST') {
                try {
                    CertificateFrames::where('status', 1)->update([
                        'status' => 0,
                    ]);
                    $update = CertificateFrames::where('id', $id)->update([
                        'status' => 1,
                    ]);
                    if ($update) {
                        $response       = array(
                            'success'   => true,
                            'data'      => CertificateFrames::getData($id, true)['data'][0],
                            'message'   => array(
                                'title' => Translator::phrase('success'),
                                'text'  => Translator::phrase('set.as.default.successfully'),
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
    public static function deleteFromTable($id)
    {
        if ($id) {
            $id  = explode(',', $id);
            if (CertificateFrames::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = CertificateFrames::whereIn('id', $id)->delete();
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
