<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    public static $path = [
        'image'  => 'year',
        'url'    => 'year',
        'view'   => 'Year'
    ];
    public static function now()
    {
        return date('Y');
    }
}
