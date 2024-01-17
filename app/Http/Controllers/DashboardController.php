<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return 'This is Dashboard';
    }

    public function setLanguage($lang_code)
    {
        $locale = \App::getLocale();
        $url = str_replace($locale, $lang_code, \URL::previous());
        //echo $url;
        return redirect($url);
    }
}
