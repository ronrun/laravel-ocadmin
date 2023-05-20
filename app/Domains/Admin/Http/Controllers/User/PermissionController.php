<?php

namespace App\Domains\Admin\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\TranslationLibrary;
use App\Domains\Admin\Services\User\PermissionService;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    private $lang;
    private $request;
    private $PermissionService;

    public function __construct(Request $request, PermissionService $PermissionService)
    {
        $this->request = $request;
        $this->PermissionService = $PermissionService;
        $this->lang = (new TranslationLibrary())->getTranslations(['ocadmin/common/common','ocadmin/user/permission']);
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
            'text' => $this->lang->text_users,
            'href' => 'javascript:void(0)',
            'cursor' => 'default',
        ];

        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.user.permission.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;

        $data['list'] = $this->getList();

        return view('ocadmin.user.permission', $data);
    }


    public function list()
    {
        $data['lang'] = $this->lang;

        $data['form_action'] = route('lang.admin.user.permission.list');

        return $this->getList();
    }


    public function getList()
    {
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

        //$data['action'] = route('lang.admin.user.permission.massDelete');

        // Rows
        $users = $this->PermissionService->getRecords($queries);

        if(!empty($users)){
            foreach ($users as $row) {
                $row->edit_url = route('lang.admin.user.permission.form', array_merge([$row->id], $queries));
            }
        }

        $data['records'] = $users->withPath(route('lang.admin.user.permission.list'))->appends($queries);

        // Prepare links for list table's header
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
        $route = route('lang.admin.user.permission.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_email'] = $route . "?sort=email&order=$order" .$url;
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
            'href' => route('lang.admin.user.permission.index'),
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

        $data['save'] = route('lang.admin.user.permission.save');
        $data['back'] = route('lang.admin.user.permission.index', $queries);

        // Get Record
        $permission = $this->PermissionService->findOrFailOrNew(id:$permission_id);

        $data['permission']  = $permission;
        $data['permission_id'] = $permission_id ?? null;

        return view('ocadmin.user.permission_form', $data);
    }


    public function save()
    {
        $data = $this->request->all();

        $json = [];

        // validator

        if(!$json) {
            $result = $this->PermissionService->updateOrCreate($data);

            if(empty($result['error'])){
                $json['permission_id'] = $result['data']['permission_id'];
                $json['success'] = $this->lang->text_success;
            }else{
                $user = Auth::user();

                $permission_id = auth()->user()->id;
                if($permission_id == 1){
                    $json['error'] = $result['error'];
                }else{
                    $json['error'] = $this->lang->text_fail;
                }
            }
        }

       return response(json_encode($json))->header('Content-Type','application/json');

    }
}
