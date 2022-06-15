<?php

namespace App\Domains\Admin\Http\Controllers\System\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Admin\Traits\MenuTrait;
use App\Domains\Admin\Services\UserService;

class UserController extends Controller
{
    use MenuTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, UserService $UserService)
    {
        $this->userService = $UserService;

        //parent::__construct();
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
     * Show the list table.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getList()
    {
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        
        return view('ocadmin.system.user.user_list', $data);
    }
}
