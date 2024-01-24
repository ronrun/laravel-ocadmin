<?php

namespace App\Domains\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Libraries\TranslationLibrary;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

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

    private $lang;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/bbb';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->lang = (new TranslationLibrary())->getTranslations(['admin/common/common','admin/common/login',]);
    }

    public function redirectTo()
    {
        return '/ccc';
    }

    /**
     * Overwrite
     */
    protected function authenticated(Request $request, $user)
    {
        $user->last_seen_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();

        $prev_url = url()->previous();
        $query = parse_url($prev_url, PHP_URL_QUERY);
        parse_str($query, $params);
        if(!empty($params['prev_url']) ){
            return redirect($params['prev_url']);
        }

        return redirect(route('lang.admin.dashboard'));
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
        return view('admin.login', $data);
    }

    /**
     * Overwrite
     */
    public function logout(Request $request)
    {
        $this->middleware('guest')->except('lang.admin.logout');

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
