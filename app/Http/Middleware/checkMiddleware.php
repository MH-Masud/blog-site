<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;

class checkMiddleware
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
        $logout=Session::get('logout');
        if ($logout != '' ) {
            return Redirect::to('/');
             
        }else{
           
           return $next($request);    
        }

    }
}
