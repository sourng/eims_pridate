<?php

namespace App\Models;

use App\Models\App;
use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\FormFeatureSlider;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FeatureSlider extends Model
{
    public static $path = [
        'image'  => 'feature',
        'url'    => 'feature',
        'view'   => 'FeatureSlider'
    ];

    public static function getData($id = null, $paginate = null, $random = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . App::$path['url'] . '/' .  FeatureSlider::$path['url'] . '/add/'),
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
            $get = FeatureSlider::orderBy('id', $orderBy);
        }
        if ($random) {
            $get = FeatureSlider::orderByRaw('RAND()');
        } else {
            $get = FeatureSlider::orderBy('id', $orderBy);
        }

        if ($id) {
            $get = $get->whereIn('id', $id);
        }else{
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
                $data[$key]         = array(
                    'id'            => $row['id'],
                    'title'         => $row['title'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(FeatureSlider::$path['image'], $row['image'])) : ImageHelper::prefix(),                    'status'        => $key == 0 ? 'active' : '',
                    'action'        => [
                        'edit' => url(Users::role() . '/' . App::$path['url'] . '/' . FeatureSlider::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . App::$path['url'] . '/' . FeatureSlider::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . App::$path['url'] . '/' . FeatureSlider::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
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
        $model = FeatureSlider::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'            => $row['id'],
                    'title'         => $row['title'],
                    'institute'     => Institute::getData($row['institute_id'])['data'][0],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(FeatureSlider::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'        => [
                        'edit' => url(Users::role() . '/' . App::$path['url'] . '/' . FeatureSlider::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . App::$path['url'] . '/' . FeatureSlider::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . App::$path['url'] . '/' . FeatureSlider::$path['url'] . '/delete/' . $row['id']),

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
                            if ($value['data'] == 'title') {
                                $query =  $query->where(function ($q) {
                                    $q->where('title', 'LIKE', '%' . request('search.value') . '%');
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
        $validator          = Validator::make(request()->all(), FormFeatureSlider::rulesField(), FormFeatureSlider::customMessages(), FormFeatureSlider::attributeField());

        if (!request()->hasFile('image')) {
            return array(
                'success'   => false,
                'type'      => 'add',
                'message'   => array(
                    'title' => Translator::phrase('error'),
                    'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL
                        . Translator::phrase('( .image. ) .empty'),
                    'button'   => array(
                        'confirm' => Translator::phrase('ok'),
                        'cancel'  => Translator::phrase('cancel'),
                    ),
                ),
            );
        }
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {

                $values['institute_id']  = request('institute');
                $values['title']         = trim(request('title'));
                $values['description']   = trim(request('description'));
                $values['image']         = null;

                $add = FeatureSlider::insertGetId($values);

                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        FeatureSlider::updateImageToTable($add, ImageHelper::uploadImage($image, FeatureSlider::$path['image'], null, null, true));
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => FeatureSlider::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormFeatureSlider::rulesField(), FormFeatureSlider::customMessages(), FormFeatureSlider::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['institute_id']  = request('institute');
                $values['title']         = trim(request('title'));
                $values['description']   = trim(request('description'));
                $update = FeatureSlider::where('id', $id)->update($values);

                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        FeatureSlider::updateImageToTable($id, ImageHelper::uploadImage($image, FeatureSlider::$path['image'], null, null, true));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => FeatureSlider::getData($id),
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
                $update =  FeatureSlider::where('id', $id)->update([
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
            if (FeatureSlider::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = FeatureSlider::whereIn('id', $id)->delete();
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
