<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Http\Requests\FormCommune;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Communes extends Model
{
    public static $path = [
        'image'  => 'commune',
        'url'    => 'commune',
        'view'   => 'commune'
    ];

    public static function getData($district_id = null, $id = null, $edit = null, $paginate = null, $search = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/general/' . Communes::$path['url'] . '/add/'),
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

        $get = Communes::select('communes.*')
            ->join('districts', 'districts.id', '=', 'communes.district_id')
            ->orderBy('communes.id', $orderBy);


        if ($id) {
            $get = $get->whereIn('communes.id', $id);
        }

        if ($district_id) {
            $get = $get->where('district_id', $district_id);
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
                $district = Districts::getData(null, $row['district_id'])['data'][0];
                $data[$key]         = array(
                    'id'            => $row['id'],
                    'province'      => $district['province'],
                    'district'      => $district,
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(Communes::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'        => [

                        'edit'      => url(Users::role() . '/general/' . Communes::$path['url'] . '/edit/' . $row['id']),
                        'view'      => url(Users::role() . '/general/' . Communes::$path['url'] . '/view/' . $row['id']),
                        'delete'    => url(Users::role() . '/general/' . Communes::$path['url'] . '/delete/' . $row['id']),
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
        $model = Communes::select((new Communes())->getTable() . '.*')
            ->join((new Districts())->getTable(), (new Districts())->getTable() . '.id', (new Communes())->getTable() . '.district_id')
            ->join((new Provinces())->getTable(), (new Provinces())->getTable() . '.id', (new Districts())->getTable() . '.province_id');

        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                $district = Districts::getData(null, $row['district_id'])['data'][0];
                return [
                    'id'            => $row['id'],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'province'      => $district['province'],
                    'district'      => $district,
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(Communes::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'        => [
                        'edit' => url(Users::role() . '/general/' . Communes::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/general/' . Communes::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/general/' . Communes::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {

                if (request('provinceId')) {
                    $query =  $query->where('province_id', request('provinceId'));
                }

                if (request('districtId')) {
                    $query =  $query->where('district_id', request('districtId'));
                }


                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'name') {
                                $query =  $query->where(function ($q) {
                                    $q->where((new Communes())->getTable() . '.name', 'LIKE', '%' . request('search.value') . '%');
                                    if (config('app.languages')) {
                                        foreach (config('app.languages') as $lang) {
                                            $q->orWhere((new Communes())->getTable() . '.' . $lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                        }
                                    }
                                });
                            } elseif ($value['data'] == 'description') {
                                $query->orWhere((new Communes())->getTable() . '.description', 'LIKE', '%' . request('search.value') . '%');
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
        $validator          = Validator::make(request()->all(), FormCommune::rulesField(), FormCommune::customMessages(), FormCommune::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['district_id'] = request('district');
                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));
                $values['image']       = null;

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }

                $add = Communes::insertGetId($values);

                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        Communes::updateImageToTable($add, ImageHelper::uploadImage($image, Communes::$path['image']));
                    } else {
                        ImageHelper::uploadImage(false, Communes::$path['image'], Communes::$path['image'], public_path('/assets/img/icons/image.jpg'), null, true);
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => Communes::getData(null, $add)['data'],
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
        $validator          = Validator::make(request()->all(), FormCommune::rulesField(), FormCommune::customMessages(), FormCommune::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['district_id'] = request('district');
                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }

                $update = Communes::where('id', $id)->update($values);

                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        Communes::updateImageToTable($id, ImageHelper::uploadImage($image, Communes::$path['image']));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => Communes::getData($id),
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
                $update =  Communes::where('id', $id)->update([
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
            if (Communes::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = Communes::whereIn('id', $id)->delete();
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
