<?php

namespace App\Models;

use App\Models\Staff;
use App\Models\Students;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Qrcode extends Model
{
    public static $path = [
        'url'   => 'qrcode',
    ];
    public static function getData($id = null)
    {
        $response = array(
            'success'   => false,
            'data'      => array(),
            'message'   => Translator::phrase('no_data'),
        );

        if ($id) {
            $id = decrypt($id, true);
            $get = Qrcode::where('id', $id)->get()->toArray();
        } else {
            $get = Qrcode::get()->toArray();
        }


        if ($get) {
            $data = array();
            foreach ($get as $key => $row) {
                $data[$key] = array(
                    'id' => $row['id'],
                    'code' => $row['code'],
                );

                if ($row['node_type']  == Students::$path['role']) {
                    $data[$key]['node'] = Students::getData($row['node_id']);
                } elseif ($row['node_type']  == Staff::$path['role']) {
                    $data[$key]['node'] = Staff::getData($row['node_id']);
                }
            }


            $response = array(
                'success'   => true,
                'type'      => 'qrcode',
                'data'      => $data,
            );
        }
        return $response;
    }

    public static function addToTable(array $node)
    {
        if($node){

            $add = Qrcode::insertGetId([
                'node_id'   => $node['id'],
                'node_type' => $node['type'],
                'create_by' => json_encode([
                    'node_id'   => Auth::user()->id,
                    'node_type'   => Users::role(),
                ]),
            ]);

            return $add;
        }
    }

    public static function encryptQrcode($code)
    {
        $encrypt        = base64_encode(gettype($code) ? json_encode($code) : $code);
        $qrCodeWithUrl  = url(Qrcode::$path['url'].'?c=' . $encrypt);
        return $qrCodeWithUrl;
    }

    public static function decryptQrcode($codeUrl , $unserialize = false)
    {
        $query_str = parse_url($codeUrl, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        if($unserialize){
            $decrypt = json_decode(base64_decode($query_params['c']) , true);
        }else{
            $decrypt = $query_params['c'];
        }
        return $decrypt;
    }

}
