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

        //parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getList();
    }

    /**
     * Show the list table.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getList()
    {

        //Language
        foreach (Lang::get('common/common') as $key => $value) {
            $arr[$key] = $value;
        }

        foreach (Lang::get('user/user') as $key => $value) {
            $arr[$key] = $value;
        }
        
        $langs = (object)$arr;

        $data['langs'] = (object)$arr;

        //Breadcomb
        $data['breadcumbs'][] = array(
            'text' => $langs->text_home,
            'href' => route('lang.home'),
        );
        
        $data['breadcumbs'][] = array(
            'text' => $langs->heading_title,
            'href' => null,
        );

        //準備資料列排序連結的參數
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
        
        //轉換 $order, 用於排序連結
        $order = $this->request->query('order');
        $order = ($order == 'DESC') ? 'ASC' : 'DESC';
        
        //資料列排序連結
        $locale = app()->getLocale();
        $backend = env('FOLDER_ADMIN');
        $data['sort_name'] = "/$locale/$backend/system/user/users?sort=name&order=$order&$strFilters";
        $data['sort_username'] = "/$locale/$backend/system/user/users?sort=username&order=$order&$strFilters";
        $data['sort_email'] = "/$locale/$backend/system/user/users?sort=email&order=$order&$strFilters";
        
        

        $requestData = $this->request->query();
        $requestData['url'] = $this->request->url();
        $requestData['limit'] = $this->request->query('limit');

        $users = $this->userService->getRows($requestData);
        $data['users'] = $users;

        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');

        return view('ocadmin.system.user.user_list', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
