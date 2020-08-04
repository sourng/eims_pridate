<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Http\Requests\FormTranslates;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class Translates extends Model
{
    public static $path = [
        'image'  => 'translate',
        'url'    => 'translate',
        'view'   => 'Translate'
    ];

    public static function getData($id = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . Translates::$path['url'] . '/add/'),
            ),
        );

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
            $get = Translates::orderBy('id', $orderBy);
        } else {
            $get = Translates::orderBy('id', 'DESC');
        }

        if ($id) {
            $get = $get->whereIn('id', $id);
        }



        if ($paginate) {
            $get = $get->paginate(20)->toArray();
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
            $data = array();
            foreach ($get as $key => $row) {

                $data[$key] = $row;
                $data[$key]['action'] = [
                    'edit'    => url(Users::role() . '/' . App::$path['url'] . '/' . Translates::$path['url'] . '/edit/' . $row['id']),
                    'view'    => url(Users::role() . '/' . App::$path['url'] . '/' . Translates::$path['url'] . '/view/' . $row['id']),
                    'delete'  => url(Users::role() . '/' . App::$path['url'] . '/' . Translates::$path['url'] . '/delete/' . $row['id']),
                ];
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['phrase'],
                    'image'  => null,
                    'action' => $data[$key]['action'],

                );
            }

            $response = array(
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
        $model = Translates::query();
        return DataTables::eloquent($model)
            ->setTransformer(function ($row) {
                $row = $row->toArray();
                return $row + [
                    'action'        => [
                        'edit'    => url(Users::role() . '/' . App::$path['url'] . '/' . Translates::$path['url'] . '/edit/' . $row['id']),
                        'view'    => url(Users::role() . '/' . App::$path['url'] . '/' . Translates::$path['url'] . '/view/' . $row['id']),
                        'delete'  => url(Users::role() . '/' . App::$path['url'] . '/' . Translates::$path['url'] . '/delete/' . $row['id']),
                    ]
                ];
            })
            ->filter(function ($query) {

                if (request('search.value')) {
                    foreach (request('columns') as $i => $value) {
                        if ($value['searchable']) {
                            if ($value['data'] == 'phrase') {
                                $query =  $query->where(function ($q) {
                                    $q->where('phrase', 'LIKE', '%' . request('search.value') . '%');
                                    if (config('app.languages')) {
                                        foreach (config('app.languages') as $lang) {
                                            $q->orWhere($lang['code_name'], 'LIKE', '%' . request('search.value') . '%');
                                        }
                                    }
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
        $validator          = Validator::make(request()->all(), FormTranslates::rulesField(), FormTranslates::customMessages(), FormTranslates::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['phrase']        = trim(request('phrase'));
                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                $add = Translates::insertGetId($values);

                if ($add) {
                    $response       = array(
                        'success'   => true,
                        'type'      => 'add',
                        'data'      => Translates::getData($add)['data'],
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
        $validator          = Validator::make(request()->all(), FormTranslates::rulesField(), FormTranslates::customMessages(), FormTranslates::attributeField());

        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                $values['phrase']        = trim(request('phrase'));
                if (config('app.languages')) {
                    foreach (config('app.languages') as $lang) {
                        $values[$lang['code_name']] = trim(request($lang['code_name']));
                    }
                }
                $update = Translates::where('id', $id)->update($values);

                if ($update) {

                    $response       = array(
                        'success'   => true,
                        'type'      => 'update',
                        'data'      => Translates::getData($id),
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
            if (Translates::whereIn('id', $id)->get()->toArray()) {
                if (request()->method() === 'POST') {
                    try {
                        $delete    = Translates::whereIn('id', $id)->delete();
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
