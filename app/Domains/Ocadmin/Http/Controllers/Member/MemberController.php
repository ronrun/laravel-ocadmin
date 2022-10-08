<?php

namespace App\Domains\Ocadmin\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Ocadmin\Services\Member\MemberService;
use App\Domains\Ocadmin\Services\Member\OrganizationService;
use App\Domains\Ocadmin\Services\Localization\CountryService;
use App\Libraries\TranslationLibrary;

class MemberController extends Controller
{

    public function __construct(Request $request, MemberService $memberService
        , OrganizationService $organizationService, CountryService $countryService)
    {
        $this->request = $request;
        $this->memberService = $memberService;
        $this->organizationService = $organizationService;
        $this->countryService = $countryService;

        // Translations
        $groups = [
            'ocadmin/common/common',
            'ocadmin/common/column_left',
            'ocadmin/member/member',
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
            'text' => $this->lang->text_member,
            'href' => 'javaScript:void(0)',
        ];
        
        $breadcumbs[] = (object)[
            'text' => $this->lang->heading_title,
            'href' => route('lang.admin.member.members.index'),
        ];

        $data['breadcumbs'] = (object)$breadcumbs;
        
        $data['list'] = $this->getList();

        return view('ocadmin.member.member', $data);
    }

    public function list()
    {
        $data['lang'] = $this->lang;
        
        $data['form_action'] = route('lang.admin.member.members.list');

        return $this->getList();
    }

    /**
     * Show the list table.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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

        //$data['action'] = route('lang.admin.member.members.massDelete');

        // Rows
        $members = $this->memberService->getMembers($queries);
        $data['members'] = $members->withPath(route('lang.admin.member.members.list'))->appends($queries);

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
        $route = route('lang.admin.member.members.list');
        $data['sort_name'] = $route . "?sort=name&order=$order" .$url;
        $data['sort_sohrt_name'] = $route . "?sort=sohrt_name&order=$order" .$url;
        $data['sort_email'] = $route . "?sort=email&order=$order" .$url;
        $data['sort_mobile'] = $route . "?sort=mobile&order=$order" .$url;
        $data['sort_date_added'] = $route . "?sort=created_at&order=$order" .$url;

        return view('ocadmin.member.member_list', $data);
    }


    public function form($member_id = null)
    {
        $data['lang'] = $this->lang;
  
        $this->lang->text_form = empty($member_id) ? $this->lang->text_add : $this->lang->text_edit;

        // Breadcomb
        $data['breadcumbs'] = [];

        $data['breadcumbs'][] = (object)array(
            'text' => $this->lang->text_home,
            'href' => route('lang.admin.dashboard'),
        );
        
        $data['breadcumbs'][] = (object)array(
            'text' => $this->lang->heading_title,
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

		$data['save'] = route('lang.admin.member.members.save');
		$data['back'] = route('lang.admin.member.members.index', $queries);

        // Sale Orders
		if (!empty($member_id)) {
			//$data['orders'] = $this->url->link('sale/order', 'user_token=' . $this->session->data['user_token'] . '&filter_customer_id=' . $this->request->get['customer_id']);
			$data['orders'] = '';
		} else {
			$data['orders'] = '';
		}

        // Get Record
		// if (!empty($this->request->query('member_id'))) {
		// 	$member = $this->memberService->find($this->request->query('member_id'));
		// }
		$member = $this->memberService->findIdOrNew($member_id);
        //echo "<pre>", print_r($member, 1), "</pre>"; exit;
        $data['member']  = $member;

        //$data['regions'] = $this->regionService->getRows(['limit' => 0]);

        if(!empty($member_id) && $member_id == $member->id){
            $data['member_id'] = $member_id;
        }else{
            $data['member_id'] = null;
        }
        
        // if(!empty($member_id)){
        //     $data['ip'] = $this->getIp($member_id);
        // }else{
        //     $data['ip'] = '';
        // }

        if(!empty($member_id)){
            //$datap['form_action'] = route('lang.admin.member.members.form');
        }else{
            //$member_id = 0;
        }

        

        $data['addresses'] = [];
        
        //echo "<pre>", print_r(999, 1), "</pre>"; exit;
        $data['countries'] = $this->countryService->getCountries();
        

        return view('ocadmin.member.member_form', $data);

    }

    public function autocomplete()
    {
        $json = [];

        //存在名稱但長度不足
        if(isset($this->request->filter_name) && mb_strlen('$this->request->filter_name', 'utf-8') < 3)
        {
            return false;
        }

        $filter_data = array(
            'filter_full_name'   => $this->request->filter_full_name,
            'filter_first_name'   => $this->request->filter_first_name,
            'filter_last_name'   => $this->request->filter_last_name,
            'filter_email'   => $this->request->filter_email,
        );

        if (!empty($this->request->sort)) {
            if($this->request->sort == 'member_id'){
                $filter_data['sort'] = '.id';
            } else if($this->request->sort =='full_name'){
                $filter_data['sort'] = '.full_name';
            } else if($this->request->sort =='first_name'){
                $filter_data['sort'] = '.first_name';
            } else if($this->request->sort =='last_name'){
                $filter_data['sort'] = '.last_name';
            } else if($this->request->sort =='email'){
                $filter_data['sort'] = '.email';
            }

            if(!empty($this->request->order) && $this->request->order == 'ASC'){
                $filter_data['order'] = 'ASC';
            }else{
                $filter_data['order'] = 'DESC';
            }
        }

        $rows = $this->memberService->getMembers($filter_data);

        foreach ($rows as $row) {
            $json[] = array(
                'member_id' => $row->id,
                'name' => $row->full_name,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'email' => $row->email,
                //'ip' => $row->ip,
            );
        }

        return response(json_encode($json))->header('Content-Type','application/json');
    }
    public function save()
    {
        // Language
        $data['lang'] = $this->lang;
        
		$json = [];

		// if (!$this->user->hasPermission('modify', 'customer/customer')) {
		// 	$json['error']['warning'] = $this->lang->error_permission;
		// }

		if ((mb_strlen($this->request->post('first_name')) < 1) || (mb_strlen($this->request->post('first_name')) > 32)) {
			$json['error']['first_name'] = $lang->error_first_name;
		}

		if ((mb_strlen($this->request->post('last_name')) < 1) || (mb_strlen($this->request->post('last_name')) > 32)) {
			$json['error']['last_name'] = $lang->error_last_name;
		}

		if ((mb_strlen($this->request->post('email')) > 96) || !filter_var($this->request->post('email'), FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = $lang->error_email;
		}
        
        $member = $this->memberService->findFirst('email', '=',$this->request->post('email'));

        // Edit but no member id
		if (!$this->request->post('member_id')) {
			if ($member) {
				$json['error']['warning'] = $this->lang->error_exists;
			}
		}
        //Add but member with same email already exists
        else {
			if ($member && ($this->request->post('member_id') != $member->id)) {
				$json['error']['warning'] = $this->lang->error_exists;
			}
		}

		//if (config('app.config_mobile_required') && (mb_strlen($this->request->post('mobile') < 9) || (mb_strlen($this->request->post['mobile']) > 20)) {
        if (config('app.config_mobile_required') && (mb_strlen($this->request->post('mobile') < 9) || mb_strlen($this->request->post('mobile') > 20))) {
                $json['error']['mobile'] = $this->lang->get('error_mobile');
        }

        /*
        if ((mb_strlen($this->request->input('telephone')) < 3) || (mb_strlen($this->request->input('telephone')) > 20)) {
			$json['error']['telephone'] = $this->lang->error_telephone;
		}
        */

        // If create, password must be checked. If edit, password can be ignored.
		// if ($this->request->post('password') || (empty($this->request->post('member_id')))) {
		// 	if ((mb_strlen(html_entity_decode($this->request->post('password'), ENT_QUOTES, 'UTF-8')) < 4) || (mb_strlen(html_entity_decode($this->request->input('password'), ENT_QUOTES, 'UTF-8')) > 20)) {
		// 		$json['error']['password'] = $this->lang->error_password;
		// 	}

		// 	if ($this->request->post('password') != $this->request->post('confirm')) {
		// 		$json['error']['confirm'] = $this->lang->error_confirm;
		// 	}
		// }
        
		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->lang->error_warning;
		}

		if (!$json) {
			if (!$this->request->post('member_id')) {
				$member_id = $this->memberService->addMember($this->request->post());
                $json['member_id'] = $member_id;
			} else {
				$this->memberService->editMember($this->request->post('member_id'), $this->request->post());
			}

			$json['success'] = $this->lang->text_success;
		}
        
        return response(json_encode($json))->header('Content-Type','application/json');
    }


}