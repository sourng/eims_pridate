<?php
// Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\AttendancesType;
use App\Models\Days;
use App\Models\Translates;
use App\Models\Months;
use App\Models\Roles;
use Illuminate\Support\Facades\Lang;

class Translator
{

    public static function phrase($string = null, $lang = null, $getString = null)
    {
        if ($string) {
            $str = str_replace(" ", "_", $string);
            $str = str_replace("-", "_", $str);
            $str = str_replace("general_", "", $str);
            $stringArray  = explode('.', $str);
            $newString    = '';
            foreach ($stringArray as $key => $value) {
                $newString .= Translator::translate(trim($value), $lang) . ((app()->getLocale() === 'km') ? '' : ' ');
            }

            return str_replace("<s>", " ", $newString);
        }

        return $string;
    }

    public static function translate(string $string, $lang = null)
    {
        $string = strtolower($string);
        // Table translates
        if ($lang) {
            $phrases = Translates::select($lang)->where('phrase', $string)->first();
            if ($phrases) {
                $string =  $phrases[$lang] ?  $phrases[$lang] : str_replace('_', ' ', $string);
                return $string;
            } else {
                $string =  str_replace('_', ' ', $string);
                return $string;
            }
        } else {
            if (Lang::has('phrase.' . $string)) {
                return Lang::get('phrase.' . $string);
            } else {
                $string =  str_replace('_', ' ', $string);
                return ($string);
            }
            $phrases = Translates::where('phrase', $string)->first();
            if ($phrases) {
                $string =  $phrases[app()->getLocale()] ?  $phrases[app()->getLocale()] : $phrases["en"];
                return $string;
            } else {
                $string =  str_replace('_', ' ', $string);
                return $string;
            }
        }
    }
    public static function day(string $string, $lang = null, $getString = null)
    {
        if ($lang) {
            $phrases = Days::select($lang)->where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string = $phrases[$lang];
                if ($getString == "short") {
                    $string = $lang == "km" ? (Days::getKMShort($phrases["id"] - 1)) : substr($string, 0, 3);
                }
                return $string;
            }
        } else {
            $phrases = Days::where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string =  $phrases[app()->getLocale()] ?  $phrases[app()->getLocale()] : $phrases["name"];
                if ($getString == "short") {
                    $string =  app()->getLocale() == "km" ? (Days::getKMShort($phrases["id"] - 1)) : substr($string, 0, 3);
                }
                return $string;
            }
        }
    }

    public static function month($string, $lang = null, $getString = null)
    {

        if ($lang) {
            $phrases = Months::select($lang)->where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string = $phrases[$lang];
                return $string;
            }
        } else {
            $phrases = Months::where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string =  $phrases[app()->getLocale()] ?  $phrases[app()->getLocale()] : $phrases["name"];
                if ($getString == "short") {
                    // $string =  app()->getLocale() == "km" ? (Months::getKMShort($phrases["id"] - 1)) : substr($string,0,3);
                }
                return $string;
            }
        }
    }

    public static function attendance(string $string, $lang = null, $getString = null)
    {
        if ($lang) {
            $phrases = AttendancesType::select($lang)->where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string = $phrases[$lang];
                return $string;
            }
        } else {
            $phrases = AttendancesType::where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string =  $phrases[app()->getLocale()] ?  $phrases[app()->getLocale()] : $phrases["name"];

                return $string;
            }
        }
    }

    public static function role(string $string, $lang = null, $getString = null)
    {
        if ($lang) {
            $phrases = Roles::select($lang)->where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string = $phrases[$lang];
                return $string;
            }
        } else {
            $phrases = Roles::where('name', 'like', '%' .  $string . '%')->first();
            if ($phrases) {
                $string =  $phrases[app()->getLocale()] ?  $phrases[app()->getLocale()] : $phrases["name"];

                return $string;
            }
        }
    }
}
