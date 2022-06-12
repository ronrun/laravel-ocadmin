<?php

namespace App\Domains\Admin\Http\Controllers\System\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        return view('ocadmin.system.user.user_list', $data);
    }
}
