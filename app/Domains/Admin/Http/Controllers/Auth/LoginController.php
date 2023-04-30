<?php

namespace App\Domains\Admin\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Libraries\TranslationLibrary;
use Redirect;

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
    protected $redirectTo = 'redirectTo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        $data['base'] = env('APP_URL') . '/' . env('APP_BACKEND_FOLDER');
        return view('ocadmin.common.login', $data); 
    }

    /** 
     * Overwrite 
     */ 
    protected function username()
    {
        $field = (filter_var(request()->email, FILTER_VALIDATE_EMAIL) || !request()->email) ? 'email' : 'username';
        request()->merge([$field => request()->email]);
        return $field;
    }

    /** 
     * Overwrite 
     */ 
    protected function authenticated(Request $request, $user)
    {
        $user->last_login = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();

        $prev_url = url()->previous();
        $query = parse_url($prev_url, PHP_URL_QUERY);
        parse_str($query, $params);
        if(!empty($params['prev_url']) ){
            return redirect($params['prev_url']);
        }       
        
        return redirect('http://laravel.test/admin/dashboard');
    }

    /** 
     * Overwrite 
     */ 
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return redirect(route('admin.login'));

        // return $request->wantsJson()
        //     ? new JsonResponse([], 204)
        //     : redirect(route('admin.login'));
    }
}
