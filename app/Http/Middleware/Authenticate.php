<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //後台
        if(isAdminPanel($request)){
            return $request->expectsJson() ? null : route('lang.admin.login');
        }

        //前台
        return $request->expectsJson() ? null : route('lang.login');
    }
}
