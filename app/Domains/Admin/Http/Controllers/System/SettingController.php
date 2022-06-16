<?php

namespace App\Domains\Admin\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Admin\Traits\MenuTrait;

class SettingController extends Controller
{
    use MenuTrait;

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
        echo "<pre>", print_r('SettingController', 1), "</pre>";
        // $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        // $data['menus'] = $this->getMenus();
        // return view('ocadmin.system.user.user_list', $data);
    }
}
