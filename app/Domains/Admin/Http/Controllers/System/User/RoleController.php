<?php

namespace App\Domains\Admin\Http\Controllers\System\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getList();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getList()
    {
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        
        return view('ocadmin.system.role.role_list', $data);
    }
}
