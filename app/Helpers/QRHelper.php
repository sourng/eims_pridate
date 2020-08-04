<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRHelper
{
    public static $path = [
        "image"  => "qrcode",
        "url"    => "qrcode",
        "view"   => "Qrcode",
    ];
    public static function make(array $object, $encode = null)
    {
        $defaults = array(
            "type"  => "png",
            "color" => array(
                "red" => 38,
                "green" => 38,
                "blue" => 38,
                "alpha" => 0.85
            ),
            "backgroundColor" => array(
                "red" => 255,
                "green" => 255,
                "blue" => 255,
                "alpha" => 0.82
            ),
            "size" => 100,
            "center" => array(
                "image" => null,
                "percentage" => .19
            ),
            "code"  => null
        );


        $object = array_merge($defaults, $object);
        $QRErrorCorrectLevel =[
            'L' => 'L',//  1,
            'M' => 'M',//  0,
            'Q' => 'Q',//  3,
            'H' => 'H',//  2
        ];

        $qr = QrCode::format($object["type"])
            //->encoding('UTF-8')
            ->errorCorrection($QRErrorCorrectLevel['L'])
            ->color($object["color"]["red"], $object["color"]["green"], $object["color"]["blue"], $object["color"]["alpha"])
            ->backgroundColor($object["backgroundColor"]["red"], $object["backgroundColor"]["green"], $object["backgroundColor"]["blue"], $object["backgroundColor"]["alpha"])
            ->size($object["size"]);



        if ($object["center"]["image"]) {
            $qr->merge($object["center"]["image"], $object["center"]["percentage"], true);
        }

        if ($encode) {
            return (string) Image::make($qr->generate($object["code"]))->encode('data-url');
        }

        return (Image::make($qr->generate($object["code"]))->response());
    }

    public static function encrypt($code, $query_string = "?fc")
    {
        $encrypt        = Encryption::encode($code);
        $qrCodeWithUrl  = url(QRHelper::$path['url'].$query_string.'=' . $encrypt);
        return $qrCodeWithUrl;
    }

    public static function decrypt($codeUrl , $query_string = "fc", $unserialize = false)
    {
        $query_str = parse_url($codeUrl, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        if($unserialize){
            $decrypt = Encryption::decode($query_params[$query_string]);
        }else{
            $decrypt = $query_params[$query_string];
        }
        return $decrypt;
    }
}
