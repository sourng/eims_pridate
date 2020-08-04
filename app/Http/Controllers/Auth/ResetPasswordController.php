<?php

namespace App\Http\Controllers\Auth;

use App\Models\App;
use App\Models\Users;
use App\Models\Languages;
use App\Models\SocailsMedia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
        $this->middleware('guest');
    }

    protected function authenticated($request,$user)
    {
        if( $user){
          return redirect(Users::role());
        }
    }
}
