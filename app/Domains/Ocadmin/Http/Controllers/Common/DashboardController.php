<?php

namespace App\Domains\Ocadmin\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lang;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Language
        $lang = (object)[];
        $obj = Lang::get('ocadmin/common/common');

        if(!empty($obj) && is_array($obj)){
            foreach ($obj as $key => $value) {
                $lang->$key = $value;
            }
            $data['lang'] = $lang;
            
            
        }

        $data['sales_chart_url'] = '/ocadmin-asset/test/dashboard-chart-sales.html';

        return view('ocadmin.dashboard', $data);
    }

    public function setLanguage($lang_code)
    {
        $locale = \App::getLocale();
        $url = str_replace($locale, $lang_code, \URL::previous());
        //echo $url;
        return redirect($url);
    }
}
