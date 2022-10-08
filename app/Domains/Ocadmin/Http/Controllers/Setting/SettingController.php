<?php

namespace App\Domains\Ocadmin\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Ocadmin\Services\Setting\SettingService;
use App\Domains\Ocadmin\Services\Member\OrganizationService;
use App\Libraries\TranslationLibrary;

class SettingController extends Controller
{

    public function __construct(Request $request, SettingService $settingService, OrganizationService $organizationService)
    {
        $this->request = $request;
        $this->settingService = $settingService;
        $this->organizationService = $organizationService;

        // Translations
        $groups = [
            'ocadmin/common/common',
            'ocadmin/common/column_left',
            'ocadmin/setting/setting',
        ];
        $this->translib = new TranslationLibrary();
        $this->lang = $this->translib->getTranslations($groups);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Language
        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];
        
        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => null,
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $filter_data = [
            'filter_group' => 'config',
            'no_pagination' => true,
            
        ];

        $settings = $this->settingService->getSettings($filter_data);
        foreach ($settings as $key => $value) {
            $arr[$key] = $value;
        }
        $data['settings'] = (object)$arr;
        
        $data['save'] = route('lang.admin.system.setting.settings.save');
        
        return view('ocadmin.setting.setting', $data);
    }

    public function save()
    {
        $post = $this->request->post();

        //if (!$this->user->hasPermission('modify', 'setting/setting')) {
        if (0){
            $json['error']['warning'] = $this->language->get('error_permission');
        }

        if (empty($json)) {
            foreach($post as $key => $value) {
                if(strpos($key, 'config_') === 0){
                    $data[] = [
                        'organization_id' => 0,
                        'group' => 'config',
                        'key' => $key,
                        'value' => $value,
                    ];
                }
            }
            $where = ['organization_id','group','key'];
            
            $this->settingService->editSettings($data, $where, ['value']);

			$json['success'] = $this->lang->text_success;
		}
        
        return response(json_encode($json))->header('Content-Type','application/json');
    }












}
