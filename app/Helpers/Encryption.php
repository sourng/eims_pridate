<?php

namespace App\Helpers;

class Encryption
{
    public static  function encode($data, $serialize = true)
    {
        $data = $serialize ? json_encode($data) : $data;
        return strtr(base64_encode($data), '+/=', '___');
    }
    public static function decode($data , $serialize = true)
    {
        $data = $serialize ? json_decode(base64_decode(strtr($data, '___', '+/=')),true) : base64_decode(strtr($data, '-_,', '+/='));
        return $data;
    }
}
