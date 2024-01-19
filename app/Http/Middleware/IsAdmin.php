<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $is_admin = 0;

        if($user){
            $is_admin = $user->metas()
                ->where('meta_key', 'is_admin')
                ->where('meta_value', 1)
                ->exists();
        }

        if($is_admin){
            return $next($request);
        }else{
            $route = route('lang.home');
            return redirect($route)->with('error_warning',"您沒有後台權限");
        }
    }
}
