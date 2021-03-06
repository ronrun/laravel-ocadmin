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

    public function __construct(Request $request, UserService $userService)
    {
        //parent::__construct();
        $this->request = $request;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['list'] = $this->getList();
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');

        return view('ocadmin.system.user.user', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $queries = $this->request->query();
        $this->form_method = 'put';
        $this->form_action = route('lang.admin.system.user.users.update', array_merge([$id], $queries));

        return $this->getForm($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Language
        $langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $langs->$key = $value;
        }

        foreach (Lang::get('system/user/user') as $key => $value) {
            $langs->$key = $value;
        }

        $data['langs'] = $langs;

        $update_data = [];

        if($this->request->input('name')){
            $update_data['name'] = $this->request->input('name');
        }

        if($this->request->input('email')){
            $update_data['email'] = $this->request->input('email');
        }

        if($this->request->input('password')){
            $update_data['password'] = bcrypt($this->request->input('password'));
        }

        if($this->request->input('status')){
            $update_data['status'] = $this->request->input('status');
        }

        $this->userService->updateByKey('id', $id, $update_data);
 
        return response()->json([
            'success' => $langs->text_success,
        ]);
    }

    public function list()
    {
        // Language
        $langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $langs->$key = $value;
        }

        foreach (Lang::get('system/user/user') as $key => $value) {
            $langs->$key = $value;
        }

        $data['langs'] = $langs;
        //end Language
        
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
        // Language
        $langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $langs->$key = $value;
        }

        foreach (Lang::get('system/user/user') as $key => $value) {
            $langs->$key = $value;
        }

        $data['langs'] = $langs;
        // End Language

        // Breadcomb
        $data['breadcumbs'][] = array(
            'text' => $langs->text_home,
            'href' => route('lang.home'),
        );
        
        $data['breadcumbs'][] = array(
            'text' => $langs->heading_title,
            'href' => null,
        );

        //???????????????????????????????????????
        $queries = [];
        $strFilters = '';
        foreach($this->request->query() as $key => $value) {
            if(stripos($key , 'filter_')===0){
                $queries[] = $key.'='.$value;
            }
        }
        $strFilters = implode('&', $queries);

        if(!empty($this->request->query('limit'))){
            $queries['limit'] = $this->request->query('limit');
        }  

        if(!empty($this->request->query())){
            $strFilters .= '&page='.$this->request->query('page');
        }
        
        //?????? $order, ??????????????????
        $order = $this->request->query('order');
        $order = ($order == 'DESC') ? 'ASC' : 'DESC';
        
        //?????????????????????
        $locale = app()->getLocale();
        $backend = env('FOLDER_ADMIN');
        $data['sort_name'] = "/$locale/$backend/system/user/users?sort=name&order=$order&$strFilters";
        $data['sort_username'] = "/$locale/$backend/system/user/users?sort=username&order=$order&$strFilters";
        $data['sort_email'] = "/$locale/$backend/system/user/users?sort=email&order=$order&$strFilters";

        $requestData = $this->request->query();
        $requestData['url'] = $this->request->url();
        $requestData['limit'] = $this->request->query('limit');

        $users = $this->userService->getRows($requestData);
        $users->withPath(route('lang.admin.system.user.users.list'));
        $data['users'] = $users;

        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        $data['menus'] = $this->getMenus();
        $data['form_action'] = route('lang.admin.system.user.users.list');

        return view('ocadmin.system.user.user_list', $data);
    }

    public function getForm($id = null)
    {
        //Language
        $langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $langs->$key = $value;
        }

        foreach (Lang::get('system/user/user') as $key => $value) {
            $langs->$key = $value;
        }

        $data['langs'] = $langs;
  
        //Breadcomb
        $data['breadcumbs'][] = array(
            'text' => $langs->text_home,
            'href' => route('lang.home'),
        );
        
        $data['breadcumbs'][] = array(
            'text' => $langs->heading_title,
            'href' => null,
        );

        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
  
        $user = $this->userService->findIdOrNew($id);
        $data['user'] = $user;
        
        //$data['breadcumbs'] = $this->breadcumbs;
        $data['text_form'] = !isset($id) ? '????????????' : '????????????';
        //$data['previous_url'] = $this->previous_url;

        $data['form_action'] = $this->form_action;
        $data['form_method'] = $this->form_method;
        
        return view('ocadmin.system.user.user_form', $data);
    }
}
