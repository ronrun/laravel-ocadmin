<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        /*
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
        */

        $backend = env('FOLDER_ADMIN');

        //default backend segment is 1, if locale exists,2
        if($request->segment(1) == $backend || $request->segment(2) == $backend){
            if(Auth::guard('admin')->check()){
                return redirect(route('lang.admin.dashboard'));
            }
        }

        if($request->segment(1) != $backend && $request->segment(2) != $backend){
            if(Auth::guard('web')->check()){
                return redirect(route('lang.home'));
            }
        }

        return $next($request);
    }
}
