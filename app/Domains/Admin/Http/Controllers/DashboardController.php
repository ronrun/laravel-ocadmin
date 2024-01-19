<?php

namespace App\Domains\Admin\Http\Controllers;

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
        $data['lang'] = $this->lang;

        $data['sales_chart_url'] = asset('assets-admin/ocadmin/view4024/dashboard-chart-sales.html');

        return view('admin.dashboard', $data);
    }
    
}
