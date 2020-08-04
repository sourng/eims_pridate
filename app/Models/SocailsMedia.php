<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Http\Requests\FormSocailsMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class SocailsMedia extends Model
{
    public static $path = [
        'image'  => 'socail-media',
        'url'    => 'socail-media',
        'view'   => 'SocailsMedia'
    ];

    public static function setConfig()
    {
        $app = SocailsMedia::where('app_id', config('app.id'))->get()->toArray();
        foreach ($app as $value) {
            config()->set('app.socail.' . $value['name'], $value);
        }
    }
    public static function getData($id = null, $edit = null, $paginate = null)
    {
        $pages['form'] = array(
            'action'  => array(
                'add'    => url(Users::role() . '/' . SocailsMedia::$path['url'] . '/add/'),
            ),
        );


        $data = array();
        $orderBy = 'DESC';
        if ($id) {
            $id  = explode(',', $id);
            $sorted = array_values($id);
            sort($sorted);
            if ($id === $sorted) {
                $orderBy = 'ASC';
            } else {
                $orderBy = 'DESC';
            }
        }
        $get = SocailsMedia::orderBy('id', $orderBy);

        if ($id) {
            $get = $get->whereIn('id', $id);
        } else {
            if (request('appId')) {
                $get = $get->where('app_id', request('appId'));
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
                    'app_id'        => $row['app_id'],
                    'name'          => Translator::phrase($row['name']),
                    'link'          => $row['link'],
                    'icon'          => $row['icon'],
                    'description'   => $row['description'],
                    'image'         => $row['image'] ? (ImageHelper::site(SocailsMedia::$path['image'], $row['image'])) : ImageHelper::prefix(),
                    'action'        => [
                        'edit' => url(Users::role() . '/' . SocailsMedia::$path['url'] . '/edit/' . $row['id']),
                        'view' => url(Users::role() . '/' . SocailsMedia::$path['url'] . '/view/' . $row['id']),
                        'delete' => url(Users::role() . '/' . SocailsMedia::$path['url'] . '/delete/' . $row['id']),
                    ]
                );
                $pages['listData'][] = array(
                    'id'     => $data[$key]['id'],
                    'name'   => $data[$key]['name'],
                    'image'  => null,
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

    public static function addToTable()
    {
    }

    public static function updateToTable($app_id)
    {
        $response           = array();
        $validator          = Validator::make(request()->all(), FormSocailsMedia::rulesField(), FormSocailsMedia::customMessages(), FormSocailsMedia::attributeField());
        if ($validator->fails()) {
            $response       = array(
                'success'   => false,
                'errors'    => $validator->getMessageBag(),
            );
        } else {

            try {
                foreach (config('app.socail') as $key => $value) {
                    $update = SocailsMedia::where('app_id', $app_id)->where('id', $value['id'])->update([
                        'link'  => trim(request($value['name']))
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
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }
        return $response;
    }
}
