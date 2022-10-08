<?php

namespace App\Domains\Ocadmin\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Ocadmin\Services\Member\OrganizationService;
use App\Libraries\TranslationLibrary;

class StoreController extends Controller
{

    public function __construct(Request $request, OrganizationService $organizationService)
    {
        $this->request = $request;
        $this->organizationService = $organizationService;

        // Translations
        $groups = [
            'ocadmin/common/common',
            'ocadmin/common/column_left',
            'ocadmin/setting/store',
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
        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];
        
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_system,
            'href' => 'javaScript:void(0)',
        ];
        
        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.system.setting.stores.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;
        
        $data['list'] = $this->getList();
        
        return view('ocadmin.setting.store', $data);
    }

    public function list()
    {
        // Language
        $data['lang'] = $this->lang;
        
        $data['form_action'] = route('lang.admin.system.setting.stores.list');

        return $this->getList();
    }

    public function getList()
    {
        // Language
        $data['lang'] = $this->lang;

        // Prepare link for action
        $queries = [];

        if(!empty($this->request->query('page'))){
            $page = $queries['page'] = $this->request->input('page');
        }else{
            $page = $queries['page'] = 1;
        }

        if(!empty($this->request->query('sort'))){
            $sort = $queries['sort'] = $this->request->input('sort');
        }else{
            $sort = $queries['sort'] = 'id';
        }

        if(!empty($this->request->query('order'))){
            $order = $queries['order'] = $this->request->query('order');
        }else{
            $order = $queries['order'] = 'DESC';
        }

        if(!empty($this->request->query('limit'))){
            $limit = $queries['limit'] = $this->request->query('limit');
        }

        foreach($this->request->all() as $key => $value){
            if(strpos($key, 'filter_') !== false){
                $queries[$key] = $value;
            }
        }


        // First 
        $data['organizations'][] = (object)[
            'id' => 0,
            'name' => $this->lang->text_default,
            'short_name' => $this->lang->text_default,
            'is_juridical_entity' => 0,
            'is_brand' => 0,
            'is_location' => 0,
            'edit_url' => route('lang.admin.system.setting.settings.index'),
        ];


        $filter_data = [
            'filter_is_ours' => '=1',
            '_and_OrWhere' => [
                ['filter_is_brand','=1'],
                ['filter_is_location','=1'],
            ],
        ];
        $rows = $this->organizationService->getOrganizations($filter_data);
        foreach ($rows as $row) {
            $row->edit = 'javascript:void(0)';
            $data['organizations'][] = $row;
        }

        // Prepare links for sort on list table's header
        if($order == 'ASC'){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }
        
        $data['sort'] = strtolower($sort);
        $data['order'] = strtolower($order);

        unset($queries['sort']);
        unset($queries['order']);

        $url = '';

        foreach($queries as $key => $value){
            $url .= "&$key=$value";
        }
        
        //link of table header for sorting
        $route = route('lang.admin.system.setting.stores.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_short_name'] = $route . "?sort=short_name&order=$order" .$url;
        
        
        return view('ocadmin.setting.store_list', $data);
    }

    public function form()
    {
        $data['xxx'] = 1;
        //echo "<pre>", print_r(333, 1), "</pre>"; exit;
        return view('ocadmin.setting.store_form', $data);
    }












}
