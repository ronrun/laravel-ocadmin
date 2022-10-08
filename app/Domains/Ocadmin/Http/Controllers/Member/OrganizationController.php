<?php

namespace App\Domains\Ocadmin\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Ocadmin\Services\Member\MemberService;
use App\Domains\Ocadmin\Services\Member\OrganizationService;
use Lang;

class OrganizationController extends Controller
{

    public function __construct(Request $request, MemberService $memberService, OrganizationService $organizationService)
    {
        $this->request = $request;
        $this->memberService = $memberService;
        $this->organizationService = $organizationService;

        // Translations
        $groups = [
            'ocadmin/common/common',
            'ocadmin/common/column_left',
            'ocadmin/member/organization',
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
        /*
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

    */

}