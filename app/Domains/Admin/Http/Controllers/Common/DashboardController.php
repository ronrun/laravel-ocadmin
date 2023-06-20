<?php

namespace App\Domains\Admin\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\TranslationLibrary;
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
        $data['lang'] = (new TranslationLibrary())->getTranslations(['ocadmin/common/common',]);

        // $data['sales_chart_url'] = 'ocadmin-asset/test/dashboard-chart-sales.html';

        return view('ocadmin.common.dashboard', $data);
    }

    public function setLanguage($lang_code)
    {
        // $locale = \App::getLocale();
        // $url = str_replace($locale, $lang_code, \URL::previous());
        // //echo $url;
        // return redirect($url);
    }
}
