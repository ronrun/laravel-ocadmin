<?php

namespace App\Domains\Admin\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Domains\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Domains\Admin\Services\User\PermissionService;

class PermissionController extends AdminController
{
    private $permission;

    public function __construct(protected Request $request, protected PermissionService $PermissionService)
    {
        parent::__construct();
        
        $this->getLang(['admin/common/common','admin/permission/permission','admin/permission/permission']);
    }

    public function index()
    {
        $data['lang'] = $this->lang;

        $query_data = $this->getQueries($this->request->query());

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_permission,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.user.permissions.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['list'] = $this->getList();
        
        $data['list_url']   =  route('lang.admin.user.permissions.list');
        $data['add_url']    = route('lang.admin.user.permissions.form');
        $data['delete_url'] = route('lang.admin.user.permissions.destroy');
        
        //Filters
        $data['filter_keyname'] = $query_data['filter_keyname'] ?? '';
        $data['filter_phone'] = $query_data['filter_phone'] ?? '';
        $data['equal_is_admin'] = $query_data['equal_is_admin'] ?? 1;
        $data['equal_is_active'] = $query_data['equal_is_active'] ?? 1;

        return view('admin.user.permission', $data);
    }

    public function list()
    {
        $data['lang'] = $this->lang;

        $data['form_action'] = route('lang.admin.user.permissions.list');

        return $this->getList();
    }

    /**
     * Show the list table.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function getList()
    {
        $data['lang'] = $this->lang;

        // Prepare queries for records
        $query_data = $this->getQueries($this->request->query());

        if(isset($query_data['equal_is_admin']) && $query_data['equal_is_admin'] == 0){
            $query_data['whereDoesntHave']['metas'] = ['is_admin' => 1];
            unset($query_data['equal_is_admin']);
        }


        // Rows
        $permissions = $this->PermissionService->getPermissions($query_data);

        if(!empty($permissions)){
            foreach ($permissions as $row) {
                $row->edit_url = route('lang.admin.user.permissions.form', array_merge([$row->id], $query_data));
            }
        }

        $data['permissions'] = $permissions->withPath(route('lang.admin.user.permissions.list'))->appends($query_data);


        // Prepare links for list table's header
        if($query_data['order'] == 'ASC'){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }
        
        $data['sort'] = strtolower($query_data['sort']);
        $data['order'] = strtolower($order);

        unset($query_data['sort']);
        unset($query_data['order']);
        unset($query_data['with']);
        unset($query_data['whereDoesntHave']);

        $url = '';

        foreach($query_data as $key => $value){
            $url .= "&$key=$value";
        }

        //link of table header for sorting
        $route = route('lang.admin.user.permissions.list');

        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_code'] = $route . "?sort=code&order=$order" .$url;
        $data['sort_created_at'] = $route . "?sort=created_at&order=$order" .$url;
        
        $data['list_url'] = route('lang.admin.user.permissions.list');

        return view('admin.user.permission_list', $data);
    }
}