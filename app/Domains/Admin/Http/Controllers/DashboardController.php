<?php

namespace App\Domains\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Admin\Traits\MenuTrait;

class DashboardController extends Controller
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
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        $data['menus'] = $this->getMenus();
        return view('ocadmin.dashboard', $data);
    }
}
