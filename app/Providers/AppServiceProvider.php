<?php

namespace App\Providers;

use App\Models\App;
use App\Models\ThemesColor;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('only_string', function ($attribute, $value, $parameters, $validator) {
            if ($value) {
                $result = false;
                $character = array();
                $not_allow_special = ["'", '"', '@', '#', '&', '*', '!', '%', '$', '^', '*', '(', ')', '{', '}', '_', '-', '+', '=', '/', '\\', '|', '`', '~', '?', '.', ',', ';', ':', '៛', 'ៗ', '៚', '៙', '€'];

                $not_allow_number = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩', '០'];

                preg_match_all('/./u', $value, $character);
                foreach ($character[0] as $key => $char) {
                    if (!in_array($char, $not_allow_number, true)) {
                        if (!in_array($char, $not_allow_special, true)) {
                            $result = true;
                            continue;
                        } else {
                            $result = false;
                            break;
                        }
                    } else {
                        $result = false;
                        break;
                    }
                }
            }
            return $result;
        });

        Validator::extend('only_khmer_character', function ($attribute, $value, $parameters, $validator) {
            if ($value) {
                $character = array();
                $result = false;
                $allow = [32];
                $from  = 6016;
                $to = 6099;

                for ($i = $from; $i <= $to; $i++) {
                    $allow[] = $i;
                }

                preg_match_all('/./u', $value, $character);
                foreach ($character[0] as $key => $char) {
                    $k = mb_convert_encoding(trim($char), 'UCS-2LE', 'UTF-8');
                    $k1 = ord(substr($k, 0, 1));
                    $k2 = ord(substr($k, 1, 1));

                    if (in_array(($k2 * 256 + $k1), $allow)) {
                        $result = true;
                        continue;
                    } else {
                        $result = false;
                        break;
                    }
                }
                return $result;
            }
        });
    }
}
