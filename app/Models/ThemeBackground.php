<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FormThemeBackground;

class ThemeBackground extends Model
{
    public static $path = [
        'image'  => 'theme-background',
        'url'    => 'theme-background',
        'view'   => 'ThemeBackground'
    ];

    public static function getData($id = null, $edit = null, $paginate = null, $random = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . App::$path['url'] . '/'  . ThemeBackground::$path['url'] . '/add/'),
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
            $get = ThemeBackground::orderBy('id', $orderBy);
        }
        if ($random) {
            $get = ThemeBackground::orderByRaw('RAND()');
        } else {
            $get = ThemeBackground::orderBy('id', $orderBy);
        }

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

                $data[$key]         = array(
                    'id'            => $row['id'],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(ThemeBackground::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'status'        => $row['status'],
                    'action'        => [
                        'set' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/set/' . $row['id']),
                        'edit' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/delete/' . $row['id']),
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
        $model = ThemeBackground::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return [
                    'id'            => $row['id'],
                    'name'          => $row[app()->getLocale()] ? $row[app()->getLocale()] : $row['name'],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(ThemeBackground::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'status'        => $row['status'],
                    'action'        => [
                        'set' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/set/' . $row['id']),
                        'edit' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/delete/' . $row['id']),
                    ]

                ];
            })
            ->filter(function ($query) {

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
        $validator          = Validator::make(request()->all(), FormThemeBackground::rulesField(), FormThemeBackground::customMessages(), FormThemeBackground::attributeField());

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
        } else {
            $image      = request()->file('image');
            if (!in_array($image->getMimeType(), ImageHelper::$path['mime'])) {
                return array(
                    'success'   => false,
                    'type'      => 'add',
                    'message'   => array(
                        'title' => Translator::phrase('error'),
                        'text'  => Translator::phrase('add.unsuccessful') . PHP_EOL
                            . Translator::phrase('( .image. ) .allow. ') . ' ( ' . str_replace('image/', '', implode(',', ImageHelper::$path['mime'])) . ' )',
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            }
        }

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));
                $values['image']       = null;

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }

                $add = ThemeBackground::insertGetId($values);

                if ($add) {

                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        ThemeBackground::updateImageToTable($add, ImageHelper::uploadImage($image, ThemeBackground::$path['image']));
                    }

                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => ThemeBackground::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormThemeBackground::rulesField(), FormThemeBackground::customMessages(), FormThemeBackground::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['name']        = trim(request('name'));
                $values['description'] = trim(request('description'));

                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }

                $update = ThemeBackground::where('id', $id)->update($values);

                if ($update) {
                    if (request()->hasFile('image')) {
                        $image      = request()->file('image');
                        ThemeBackground::updateImageToTable($id, ImageHelper::uploadImage($image, ThemeBackground::$path['image']));
                    }
                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => ThemeBackground::getData($id),
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
                $update =  ThemeBackground::where('id', $id)->update([
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
    public static function setToTable($id)
    {
        $response = array(
            'success'   => false,
            'message'   => Translator::phrase('update.failed'),
        );
        if ($id && request()->ajax()) {
            if (request()->method() == 'POST') {
                try {
                    ThemeBackground::where('status', 1)->update([
                        'status' => 0,
                    ]);
                    $update = ThemeBackground::where('id', $id)->update([
                        'status' => 1,
                    ]);
                    if ($update) {
                        $response       = array(
                            'success'   => true,
                            'data'      => ThemeBackground::getData($id, true)['data'][0],
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
            if (ThemeBackground::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = ThemeBackground::whereIn('id', $id)->delete();
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
