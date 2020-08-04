<?php

namespace App\Http\Controllers;

use App\Models\SocialAuth;
use Exception;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller
{
    public function index($param1 = null, $param2 = null)
    {
        if ($param1 && env(strtoupper($param1) . '_ENABLED')) {
            if ($param2 == 'callback') {
                return SocialAuth::checkUser($param1);
            } else {
                return Socialite::driver($param1)->redirect();
            }
        }
    }
}
