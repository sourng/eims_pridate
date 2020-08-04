<?php

namespace App\Http\Middleware;

use App\Models\Users;
use Laravel\Telescope\Telescope;

class Administrator
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {

       if(Users::role('id') == 1){
            return Telescope::check($request) ? $next($request) : abort(403);
       }else{
           abort(404);
       }

    }
}
