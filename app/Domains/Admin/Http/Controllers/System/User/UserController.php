<?php

namespace App\Domains\Admin\Http\Controllers\System\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\Admin\Traits\MenuTrait;
use App\Domains\Admin\Services\UserService;
use Lang;

class UserController extends Controller
{
    use MenuTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;

        $this->lang = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $this->lang->$key = $value;
        }

        foreach (Lang::get('system/user/user') as $key => $value) {
            $this->lang->$key = $value;
        }
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
        
        $data['list'] = $this->getList();
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');

        return view('ocadmin.system.user.user', $data);
    }

    public function list()
    {
        // Language
        $data['lang'] = $this->lang;
        
        $data['form_action'] = route('lang.admin.system.user.users.list');

        return $this->getList();
    }

    /**
     * Show the list table.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getList()
    {
        $data['lang'] = $lang = $this->lang;

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

        // Rows
        $users = $this->userService->getRows($queries);

        if(!empty($users)){
            foreach ($users as $row) {
                $row->url_edit = route('lang.admin.system.user.users.form', array_merge([$row->id], $queries));
                $row->status = ($row->status) ? $this->lang->text_enabled : $this->lang->text_disabled;
            }
        }

        $data['users'] = $users->withPath(route('lang.admin.system.user.users.list'))->appends($queries);

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
        $route = route('lang.admin.system.user.users.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_email'] = $route . "?sort=email&order=$order" .$url;
        $data['sort_username'] = $route . "?sort=username&order=$order" .$url;
        $data['sort_status'] = $route . "?sort=status&order=$order" .$url;
        $data['sort_created_at'] = $route . "?sort=created_at&order=$order" .$url;
        
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        $data['menus'] = $this->getMenus();
       // $data['form_action'] = route('lang.admin.system.user.users.list');

        return view('ocadmin.system.user.user_list', $data);
    }


    public function form($user_id = null)
    {
        // Language
        $lang = (object)[];

        foreach (Lang::get('common/common') as $key => $value) {
            $lang->$key = $value;
        }

        foreach (Lang::get('system/user/user') as $key => $value) {
            $lang->$key = $value;
        }

        $lang->text_form = empty($user_id) ? $lang->text_add : $lang->text_edit;

        $data['lang'] = $this->lang = $lang;
  
        // Breadcomb
        $data['breadcumbs'] = [];

        $data['breadcumbs'][] = (object)array(
            'text' => $lang->text_home,
            'href' => route('lang.admin.dashboard'),
        );
        
        $data['breadcumbs'][] = (object)array(
            'text' => $lang->heading_title,
            'href' => null,
        );

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

        if(!empty($user_id)){
            $data['user_id'] = $user_id;
        }else{
            $data['user_id'] = null;
        }

		$data['save'] = route('lang.admin.system.user.users.save');
		$data['back'] = route('lang.admin.system.user.users.index', $queries);

        // Sale Orders
		if (!empty($user_id)) {
			//$data['orders'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&filter_customer_id=' . $this->request->get['customer_id']);
			$data['orders'] = '';
		} else {
			$data['orders'] = '';
		}

		$data['user'] = $this->userService->findIdOrNew($user_id);
        
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');

        return view('ocadmin.system.user.user_form', $data);

    }


    public function save()
    {
        //Language
        $lang = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $lang->$key = $value;
        }

        foreach (Lang::get('system/user/user') as $key => $value) {
            $lang->$key = $value;
        }

        $data = $this->request->post();

		$json = [];

		// if (!$this->user->hasPermission('modify', 'customer/customer')) {
		// 	$json['error']['warning'] = $this->lang->error_permission;
		// }

		if ((utf8_strlen($this->request->post('username')) <2) || (utf8_strlen($this->request->post('username')) > 20)) {
			$json['error']['username'] = $lang->error_username;
		}

		if ((utf8_strlen($this->request->post('name')) <2) || (utf8_strlen($this->request->post('name')) > 32)) {
			$json['error']['name'] = $lang->error_name;
		}

		if ((utf8_strlen($this->request->post('email')) > 96) || !filter_var($this->request->post('email'), FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = $lang->error_email;
		}
        
        $user = $this->userService->findKey('email', $this->request->post('email'));
        
		if (!$this->request->post('user_id')) {
			if ($user) {
				$json['error']['warning'] = $lang->error_username_exists;
			}
		} else {
			if ($user && ($this->request->post('user_id') != $user->id)) {
				$json['error']['warning'] = $lang->error_username_exists;
			}
		}

        // If create, password must be checked. If edit, password can be ignored.
		if ($this->request->post('password') || (empty($this->request->post('user_id')))) {
			if ((utf8_strlen(html_entity_decode($this->request->post('password'), ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->input('password'), ENT_QUOTES, 'UTF-8')) > 20)) {
				$json['error']['password'] = $lang->error_password;
			}

			if ($this->request->post('password') != $this->request->post('confirm')) {
				$json['error']['confirm'] = $lang->error_confirm;
			}
		}

		if (!$json) {
			if (!$this->request->post('user_id')) {
                $json['user_id'] = $this->userService->addUser($data);
			} else {
				$this->userService->editUser($this->request->post('user_id'), $data);
			}

			$json['success'] = $lang->text_success;
		}

        //return response()->json($json);
        return response(json_encode($json))->header('Content-Type','application/json');
    }
}
