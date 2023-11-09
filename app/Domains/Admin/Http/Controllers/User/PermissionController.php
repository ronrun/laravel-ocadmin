<?php

namespace App\Domains\Admin\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Admin\Http\Controllers\BackendController;
use App\Libraries\TranslationLibrary;
use App\Domains\Admin\Services\User\PermissionService;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Classes\UrlHelper;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PermissionController extends BackendController
{
    protected $lang;

    public function __construct(private Request $request, private PermissionService $PermissionService)
    {
        parent::__construct();
        $this->getLang(['ocadmin/common/common','ocadmin/user/permission']);
    }


    public function index()
    {
        $data['lang'] = $this->lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_menu_system,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_menu_system_user,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.system.user.permissions.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['add_url'] = route('lang.admin.system.user.permissions.form');
        $data['list_url'] = route('lang.admin.system.user.permissions.list');
        $data['delete_url'] = route('lang.admin.system.user.permissions.delete');
        
        $data['list'] = $this->getList();

        return view('ocadmin.user.permission', $data);
    }

    public function list()
    {
        $data['lang'] = $this->lang;

        $data['form_action'] = route('lang.admin.system.user.permissions.list');

        return $this->getList();
    }


    public function getList()
    {
        $data['lang'] = $this->lang;

        $queries = $this->request->query();

        // Prepare query_data for records
        $query_data = UrlHelper::getUrlQueries($queries);
        
        // Rows
        $permissions = $this->PermissionService->getPermissions($query_data);

        if(!empty($permissions)){
            foreach ($permissions as $row) {
                $row->edit_url = route('lang.admin.system.user.permissions.form', array_merge([$row->id], $queries));
            }
        }

        $data['permissions'] = $permissions->withPath(route('lang.admin.system.user.permissions.list'))->appends($queries);

        $data['save_url'] = route('lang.admin.common.terms.save');
        $data['back_url'] = route('lang.admin.common.terms.index', $queries);
        $data['list_url'] = route('lang.admin.common.terms.list');


        // Prepare links for list table's header
        if($query_data['order'] == 'ASC'){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }
        
        $data['sort'] = strtolower($query_data['sort']);
        $data['order'] = strtolower($order);

        $query_data = UrlHelper::unsetUrlQueryData($queries,['sort','order']);

        $url = '';

        foreach($query_data as $key => $value){
            $url .= "&$key=$value";
        }


        // link of table header for sorting        
        $route = route('lang.admin.system.user.permissions.list');

        $data['sort_id'] = $route . "?sort=id&order=$order" .$url;
        $data['sort_code'] = $route . "?sort=code&order=$order" .$url;
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_date_added'] = $route . "?sort=created_at&order=$order" .$url;
        
        return view('ocadmin.user.permission_list', $data);
    }


    public function form($permission_id = null)
    {
        $data['lang'] = $this->lang;

        $this->lang->text_form = empty($permission_id) ? $this->lang->trans('text_add') : $this->lang->trans('text_edit');

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->text_user,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.system.user.permissions.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        // Prepare link for save, back
        $queries = [];

        foreach($this->request->all() as $key => $value){
            if(strpos($key, 'filter_') !== false){
                $queries[$key] = $value;
            }
        }

        if(!empty($this->request->query('page'))){
            $queries['page'] = $this->request->query('page');
        }else{
            $queries['page'] = 1;
        }

        if(!empty($this->request->query('sort'))){
            $queries['sort'] = $this->request->query('sort');
        }else{
            $queries['sort'] = 'id';
        }

        if(!empty($this->request->query('order'))){
            $queries['order'] = $this->request->query('order');
        }else{
            $queries['order'] = 'DESC';
        }

        if(!empty($this->request->query('limit'))){
            $queries['limit'] = $this->request->query('limit');
        }

        $data['save_url'] = route('lang.admin.system.user.permissions.save');
        $data['back_url'] = route('lang.admin.system.user.permissions.index', $queries);

        // Get Record
        $permission = $this->PermissionService->findIdOrFailOrNew(id:$permission_id);

        $data['permission']  = $permission;
        $data['permission_id'] = $permission_id ?? null;

        $data['supportedLocales'] = LaravelLocalization::getLocalesOrder();

        return view('ocadmin.user.permission_form', $data);
    }


    public function save()
    {
        $post_data = $this->request->post();

        $json = [];

        // validator

        if(!$json) {
            $result = $this->PermissionService->savePermission($post_data);

            if(empty($result['error'])){

                $json['permission_'] = $result['data']['id'];
                $json['success'] = $this->lang->text_success;
                $json['replace_url'] = route('lang.admin.system.user.permissions.form', $result['data']['id']); // only change url
                // $json['redirect'] = ... // redirect to new page
                
            }else{
                if(config('app.debug')){
                    $json['error'] = $result['error'];
                }else{
                    $json['error'] = $this->lang->text_fail;
                }
            }
        }

       return response(json_encode($json))->header('Content-Type','application/json');

    }
}
