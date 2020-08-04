<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Contracts\Encryption\DecryptException;
class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language  = explode(',', $request->server('HTTP_ACCEPT_LANGUAGE'));
        $locale    = array();
        foreach ($language  as $lang) {
            $locale[] = substr($lang, 0, 2);
        }
        if (Cookie::has('locale')) {
            $locale = Cookie::get('locale');
            try {
                $decrypted = Crypt::decryptString($locale);
                App::setLocale($decrypted);
            } catch (DecryptException $e) {
                //
            }

        } else {
            if (in_array('km', $locale, true)) {
                App::setLocale('km');
            } else {
                App::setLocale(app()->getLocale());
            }
        }
        return $next($request);
    }
}
