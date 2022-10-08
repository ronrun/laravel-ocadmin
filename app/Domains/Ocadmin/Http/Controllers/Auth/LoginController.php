<?php

namespace App\Domains\Ocadmin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Libraries\TranslationLibrary;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = 'redirectTo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // Translations
        $groups = [
            'ocadmin/common/common',
            'ocadmin/common/login',
        ];
        $this->translib = new TranslationLibrary();
        $this->lang = $this->translib->getTranslations($groups);
    }

    public function redirectTo()
    {
        return 'redirectTo';
    }
    
    /** 
     * Overwrite 
     */ 
    protected function authenticated(Request $request, $user)
    {
        return redirect(route('lang.admin.dashboard'));
    }
    
    /** 
     * Overwrite 
     */ 
    protected function username()
    {
        $field = (filter_var(request()->email, FILTER_VALIDATE_EMAIL) || !request()->email) ? 'email' : 'mobile';
        request()->merge([$field => request()->email]);
        return $field;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
            'password'=> [trans('auth.failed')],
        ]);
    }

    /** 
     * Overwrite 
     */ 
    public function showLoginForm() 
    {
        $data['lang'] = $this->lang;

        $data['refresh_token_url'] = route('getToken');

        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        return view('ocadmin.login', $data); 
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

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect(route('lang.admin.login'));
    }
}
