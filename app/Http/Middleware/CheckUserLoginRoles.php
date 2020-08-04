<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Roles;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class CheckUserLoginRoles
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
        if (Auth::user()) {
            $actions = $request->route()->getAction();
            if ($actions['prefix'] == '/' . Users::role()) {
                if ($request->redirect) {
                    return redirect($request->redirect);
                } else {
                    return $next($request);
                }
            }

            if ($request->redirect) {
                return redirect($request->redirect);
            } else {
                return redirect('/' . Users::role());
            }
        }
        return redirect('/login');
    }
}
