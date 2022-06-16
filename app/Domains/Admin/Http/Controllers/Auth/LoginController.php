<?php

namespace App\Domains\Admin\Http\Controllers\Auth;

use App\Domains\Admin\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Overwrite
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Overwrite
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Overwrite
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Overwrite
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect(route('admin.dashboard'));
    }

    /**
     * Overwrite
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        if (!Auth::guard('web')->check() && !Auth::guard('admin')->check()){
            $request->session()->invalidate();
        }

        return redirect(route('admin.login'));
    }
}
