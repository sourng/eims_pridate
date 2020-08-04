<?php

namespace App\Models;

use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;

class ThemesColor extends Model
{
    public static $path = [
        'image'  => 'theme-color',
        'url'    => 'theme-color',
        'view'   => 'ThemesColor'
    ];

    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . ThemesColor::$path['url'] . '/add/'),
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
            $get = ThemesColor::orderBy('id', $orderBy);
        } else {
            $get = ThemesColor::orderBy('id', 'DESC');
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
                    'image'         => $row['image'] ? (ImageHelper::site(ThemesColor::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'color'         => $row['color'],
                    'color_name'    => $row['name'],
                    'action'        => [
                        'edit' => url(Users::role() . '/' . ThemesColor::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . ThemesColor::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . ThemesColor::$path['url'] . '/delete/' . $row['id']),
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
}
