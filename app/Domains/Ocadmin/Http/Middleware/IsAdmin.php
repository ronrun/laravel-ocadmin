<?php

namespace App\Domains\Ocadmin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //return $next($request);
        
        if(!empty(Auth::user()->is_admin) && Auth::user()->is_admin == 1){
            return $next($request);
        }

        return redirect(route('lang.login'))->with('error',"There is something wrong!!");
    }
}
