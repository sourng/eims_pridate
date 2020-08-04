<?php

namespace App;

use App\Models\Roles;
use App\Models\Institute;
use App\Models\SocialAuth;
use App\Helpers\ImageHelper;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use \HighIdeas\UsersOnline\Traits\UsersOnlineTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function profile()
    {
        $socail_auth = SocialAuth::getData(null, Auth::user()->id);
        $profile = null;
        if (Auth::user()->profile) {
            $profile = ImageHelper::site('profile', Auth::user()->profile);
        } elseif ($socail_auth) {
            $profile = $socail_auth['_avatar'];
        }

        return $profile;
    }
    public static function role($get = null)
    {
        if (Auth::user()) {
            $roles = Roles::where('id', Auth::user()->role_id)->get()->toArray();
            if ($get) {
                return $roles[0][$get];
            }
            return $roles[0]['name'];
        }
        return null;
    }
    public static function institute($get = null)
    {
        if (Auth::user()) {

            $data = Institute::getData(Auth::user()->institute_id)['data'][0];
            if ($get) {
                return $data[$get];
            }
            return $data['name'];
        }
        return null;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }
}
