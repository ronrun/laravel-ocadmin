<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Admin\Services\Common\MenuService;

class AdminController extends Controller
{
    use MenuService;

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');

    }
}