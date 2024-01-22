<?php

namespace App\Domains\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['lang'] = (new TranslationLibrary())->getTranslations(['admin/common/common']);

        $data['sales_chart_url'] = asset('assets-admin/ocadmin/view4024/dashboard-chart-sales.html');

        return view('admin.dashboard', $data);
    }
    
}
