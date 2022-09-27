<?php

namespace App\Domains\Ocadmin\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lang;

class SettingController extends Controller
{
    protected $controller_key = 'system/settings';

    public function __construct(Request $request)
    {
        $this->request = $request;

        $this->lang = (object)[];
        foreach (Lang::get('ocadmin/common/common') as $key => $value) {
            $this->lang->$key = $value;
        }

        foreach (Lang::get('ocadmin/setting/setting') as $key => $value) {
            $this->lang->$key = $value;
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['test'] = 123;
        return view('ocadmin.setting.setting', $data);
    }
}
