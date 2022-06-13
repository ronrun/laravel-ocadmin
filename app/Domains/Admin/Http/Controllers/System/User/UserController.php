<?php

namespace App\Domains\Admin\Http\Controllers\System\User;

use App\Http\Controllers\Controller;
//use App\Domains\Admin\Http\Controllers\AdminController;
use App\Domains\Admin\Traits\MenuTrait;
use Illuminate\Http\Request;

class UserController extends Controller
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

        //parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        
        return view('ocadmin.system.user.user_list', $data);
    }
}
