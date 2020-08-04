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

class CardFrames extends Model
{
    public static $path = [
        'image'  => 'card',
        'url'    => 'card',
        'view'   => 'Card'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/add/'),
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
        $get = CardFrames::orderBy('id', $orderBy);

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
                    'front'         => ImageHelper::site(CardFrames::$path['image'], $row['front']),
                    'front_o'         => ImageHelper::site(CardFrames::$path['image'], $row['front'], 'original'),
                    'background'    => ImageHelper::site(CardFrames::$path['image'], $row['background']),
                    'background_o'    => ImageHelper::site(CardFrames::$path['image'], $row['background'], 'original'),
                    'layout'        => $edit ? $row['layout'] : Translator::phrase($row['layout']),
                    'description'   => $row['description'],
                    'status'        => $row['status'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'action'                   => [
                        'set' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/set/' . $row['id']), //?id
                        'edit' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/delete/' . $row['id']), //?id
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
        $model = CardFrames::query();
        $i = 1;
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {

                $row = $row->toArray();
                return [
                    'id'            => $row['id'],
                    'type'          => Translator::phrase($row['type']),
                    'name'          => $row['name'],
                    'front'         => ImageHelper::site(CardFrames::$path['image'], $row['front']),
                    'front_o'         => ImageHelper::site(CardFrames::$path['image'], $row['front'], 'original'),
                    'background'    => ImageHelper::site(CardFrames::$path['image'], $row['background']),
                    'background_o'    => ImageHelper::site(CardFrames::$path['image'], $row['background'], 'original'),
                    'layout'        => Translator::phrase($row['layout']),
                    'description'   => $row['description'],
                    'status'        => $row['status'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'action'                   => [
                        'set' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/set/' . $row['id']), //?id
                        'edit' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/edit/' . $row['id']), //?id
                        'view' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/view/' . $row['id']), //?id
                        'delete' => url(Users::role() . '/' . Students::$path['url'] . '/' . CardFrames::$path['url'] . '/delete/' . $row['id']), //?id
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
        $response           = array();

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
        if (!request()->hasFile('background')) {
            return array(
                'success'   => false,
                'type'      => 'add',
                'message'   => array(
                    'title' => Translator::phrase('error'),
                    'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL
                        . Translator::phrase('( .frame_background. ) .empty'),
                    'button'   => array(
                        'confirm' => Translator::phrase('ok'),
                        'cancel'  => Translator::phrase('cancel'),
                    ),
                ),
            );
        }

        $validator          = Validator::make(request()->all(), FormCard::rulesField(), FormCard::customMessages(), FormCard::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $values['institute_id'] = request('institute');
                $values['name']        = trim(request('name'));
                $values['type']        = trim(request('type'));
                $values['layout']     = trim(request('layout'));
                $values['description'] = trim(request('description'));
                $values['status'] = 0;


                $add = CardFrames::insertGetId($values);

                if ($add) {

                    if (request()->hasFile('front')) {
                        $image      = request()->file('front');
                        CardFrames::updateImageToTable($add, ImageHelper::uploadImage($image, CardFrames::$path['image']), 'front');
                    }
                    if (request()->hasFile('background')) {
                        $image      = request()->file('background');
                        CardFrames::updateImageToTable($add, ImageHelper::uploadImage($image, CardFrames::$path['image']), 'background');
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => CardFrames::getData($add),
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

                $values['institute_id'] = request('institute');
                $values['name']        = trim(request('name'));
                $values['type']        = trim(request('type'));
                $values['layout']     = trim(request('layout'));
                $values['description'] = trim(request('description'));


                $update = CardFrames::where('id', $id)->update($values);
                if ($update) {
                    if (request()->hasFile('front')) {
                        $image      = request()->file('front');
                        CardFrames::updateImageToTable($id, ImageHelper::uploadImage($image, CardFrames::$path['image']), 'front');
                    }
                    if (request()->hasFile('background')) {
                        $image      = request()->file('background');
                        CardFrames::updateImageToTable($id, ImageHelper::uploadImage($image, CardFrames::$path['image']), 'background');
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => CardFrames::getData($id),
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
                $update =  CardFrames::where('id', $id)->update([
                    $column    => $image,
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
                'qrcode'       => Translator::phrase('qrcode'),
                'gender'       => Translator::phrase('gender'),
                'course'       => Translator::phrase('course'),
            );
        } else if ($get == 'selected') {
            $get = array(
                'id'           => Translator::phrase('id'),
                'fullname'     => Translator::phrase('fullname'),
                '_fullname'    => Translator::phrase('fullname.as.en'),
                'photo'        => Translator::phrase('photo'),
                'qrcode'       => Translator::phrase('qrcode'),
                'gender'       => Translator::phrase('gender'),
                'course'       => Translator::phrase('course'),
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
                    CardFrames::where('status', 1)->update([
                        'status' => 0,
                    ]);
                    $update = CardFrames::where('id', $id)->update([
                        'status' => 1,
                    ]);
                    if ($update) {
                        $response       = array(
                            'success'   => true,
                            'data'      => CardFrames::getData($id, true)['data'][0],
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
            if (CardFrames::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = CardFrames::whereIn('id', $id)->delete();
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
