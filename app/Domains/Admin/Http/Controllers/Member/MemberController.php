<?php

namespace App\Domains\Admin\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Admin\Traits\MenuTrait;
use App\Domains\Admin\Services\MemberService;
use App\Domains\Admin\Services\Localisation\CountryService;
use Lang;

class MemberController extends Controller
{
    use MenuTrait;

    public function __construct(Request $request, MemberService $memberService, CountryService $countryService)
    {
        $this->request = $request;
        $this->memberService = $memberService;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Language
        $lang = (object)[];

        foreach (Lang::get('common/common') as $key => $value) {
            $lang->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $lang->$key = $value;
        }

        $data['lang'] = $this->lang = $lang;

        // Breadcomb
        $breadcumbs[] = (object)[
            'text' => $lang->text_home,
            'href' => route('lang.admin.dashboard'),
        ];
        
        $breadcumbs[] = (object)[
            'text' => $lang->heading_title,
            'href' => null,
        ];

        $data['breadcumbs'] = (object)$breadcumbs;
        
        $data['list'] = $this->getList();
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');

        return view('ocadmin.member.member', $data);
    }


    public function form($member_id = null)
    {
        // Language
        $lang = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $lang->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $lang->$key = $value;
        }

        $lang->text_form = empty($member_id) ? $lang->text_add : $lang->text_edit;

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
		$data['member'] = $this->memberService->findIdOrNew($member_id);

        $data['countries'] = $this->countryService->getRows();

        if(!empty($member_id)){
            $data['member_id'] = $member_id;
        }else{
            $data['member_id'] = null;
        }
        
        if(!empty($member_id)){
            $data['ip'] = $this->getIp($member_id);
        }else{
            $data['ip'] = '';
        }

        if(!empty($member_id)){
            //$datap['form_action'] = route('lang.admin.member.members.form');
        }else{
            //$member_id = 0;
        }
        //echo "<pre>", print_r($data['form_action'], 1), "</pre>";exit;
        /*
		if (!empty($this->request->query('member_id'))) {
			$data['member_id'] = (int)$this->request->query('member_id');
		} else {
			$data['member_id'] = 0;
		}

        // Get all groups for select options
		//$data['customer_groups'] = $this->memberService->getCustomerGroups();


		if (!empty($member)) {
			$data['firstname'] = $member['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (!empty($member)) {
			$data['lastname'] = $member['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (!empty($member)) {
			$data['email'] = $member['email'];
		} else {
			$data['email'] = '';
		}

		if (!empty($member)) {
			$data['telephone'] = $member['telephone'];
		} else {
			$data['telephone'] = '';
		}

		$data['password'] = '';
		$data['confirm'] = '';

		if (!empty($member)) {
			$data['newsletter'] = $member['newsletter'];
		} else {
			$data['newsletter'] = 0;
		}

		if (!empty($member)) {
			$data['status'] = $member['status'];
		} else {
			$data['status'] = 1;
		}

        $data['countries'] = $this->countryService->getRows();

		// if (!empty($this->request->query('member_id'))) {
		// 	$data['addresses'] = $this->memberService->getAddresses((int)$this->request->query('member_id'));
		// } else {
		// 	$data['addresses'] = [];
		// }

		// $data['payment_method'] = $this->getPayment();
		// $data['history'] = $this->getHistory();
		// $data['transaction'] = $this->getTransaction();
		// $data['reward'] = $this->getReward();
		// $data['ip'] = $this->getIp();
        */

        

        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');

        return view('ocadmin.member.member_form', $data);

    }


    public function save()
    {
        //Language
        $lang = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $lang->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $lang->$key = $value;
        }

        $data = $this->request->post();

		$json = [];

		// if (!$this->user->hasPermission('modify', 'customer/customer')) {
		// 	$json['error']['warning'] = $this->lang->error_permission;
		// }

		if ((utf8_strlen($this->request->post('firstname')) < 1) || (utf8_strlen($this->request->post('firstname')) > 32)) {
			$json['error']['firstname'] = $lang->error_firstname;
		}

		if ((utf8_strlen($this->request->post('lastname')) < 1) || (utf8_strlen($this->request->post('lastname')) > 32)) {
			$json['error']['lastname'] = $lang->error_lastname;
		}

		if (empty($this->request->post('name'))){
			$data['name'] = $this->request->post('firstname') . ' ' . $this->request->post('lastname');
		}

		if ((utf8_strlen($this->request->post('email')) > 96) || !filter_var($this->request->post('email'), FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = $lang->error_email;
		}
        
        $member = $this->memberService->findKey('email', $this->request->post('email'));
 
		if (!$this->request->post('member_id')) {
			if ($member) {
				$json['error']['warning'] = $lang->error_exists;
			}
		} else {
			if ($member && ($this->request->post('member_id') != $member->id)) {
				$json['error']['warning'] = $lang->error_exists;
			}
		}

		//if ($this->config->get('config_telephone_required') && (utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
        /*
        if ((utf8_strlen($this->request->input('telephone')) < 3) || (utf8_strlen($this->request->input('telephone')) > 20)) {
			$json['error']['telephone'] = $this->lang->error_telephone;
		}
        */

        // If create, password must be checked. If edit, password can be ignored.
		if ($this->request->post('password') || (empty($this->request->post('member_id')))) {
			if ((utf8_strlen(html_entity_decode($this->request->post('password'), ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->input('password'), ENT_QUOTES, 'UTF-8')) > 20)) {
				$json['error']['password'] = $lang->error_password;
			}

			if ($this->request->post('password') != $this->request->post('confirm')) {
				$json['error']['confirm'] = $lang->error_confirm;
			}
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $lang->error_warning;
		}

		if (!$json) {
			if (!$this->request->post('member_id')) {
                $json['member_id'] = $this->memberService->addMember($data);
			} else {
				$this->memberService->editMember($this->request->post('member_id'), $data);
			}

			$json['success'] = $lang->text_success;
		}

        //return response()->json($json);
        return response(json_encode($json))->header('Content-Type','application/json');
    }

    public function list()
    {
        // Language
        $this->lang = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $this->lang->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $this->lang->$key = $value;
        }

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

        //$data['action'] = route('lang.admin.member.members.massDelete');

        // Rows
        $members = $this->memberService->getRows($queries);

        if(!empty($members)){
            foreach ($members as $row) {
                $row->url_edit = route('lang.admin.member.members.form', array_merge([$row->id], $queries));
                $row->status = ($row->status) ? $this->lang->text_enabled : $this->lang->text_disabled;
            }
        }

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
        $data['sort_email'] = $route . "?sort=email&order=$order" .$url;
        $data['sort_status'] = $route . "?sort=status&order=$order" .$url;
        $data['sort_created_at'] = $route . "?sort=created_at&order=$order" .$url;
        
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        $data['menus'] = $this->getMenus();
        $data['form_action'] = route('lang.admin.member.members.list');

        return view('ocadmin.member.member_list', $data);
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
            'filter_name'   => $this->request->filter_name,
            'filter_email'   => $this->request->filter_email,
            'filter_status'   => 'Y',
        );

        if (!empty($this->request->sort)) {
            if($data['sort'] == 'member_id'){
                $filter_data['sort'] = '.id';
            } else if($data['sort'] =='member_name'){
                $filter_data['sort'] = '.name';
            } else if($data['sort'] =='member_email'){
                $filter_data['sort'] = '.email';
            }

            if(!empty($this->request->order) && $this->request->order == 'ASC'){
                $filter_data['order'] = 'ASC';
            }else{
                $filter_data['order'] = 'DESC';
            }
        }

        $rows = $this->memberService->getRows($filter_data);

        foreach ($rows as $row) {
            $json[] = array(
                'member_id' => $row->id,
                'name' => $row->name,
                'email' => $row->email,
                'ip' => $row->ip,
            );
        }

        return response(json_encode($json))->header('Content-Type','application/json');
    }

	public function ip($member_id) 
    {
        //Language
        $this->lang = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $this->lang->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $this->lang->$key = $value;
        }

        return $this->getIp($member_id);
	}

	public function getIp($member_id) 
    {
        //Language
        $data['lang'] = $lang = $this->lang;

		if (!empty($member_id)) {
			$member_id = (int)$member_id;
		} else {
			$member_id = 0;
		}

		if (!empty($this->request->query('page'))) {
			$page = (int)$this->request->query('page');
		} else {
			$page = 1;
		}
		$data['ips'] = [];

		$results = $this->memberService->getIps($member_id, ($page - 1) * 10, 10);
        
		foreach ($results as $result) {
			$data['ips'][] = (object)[
				'ip'         => $result->ip,
				'account'    => $this->memberService->getTotalCustomersByIp($result->ip),
				'registered_accounts' => $this->memberService->getTotalRegisteredCustomersByIp($result->ip),
				'country'    => $result->country,
                'created_at' => $result->created_at,
				'filter_ip'  => route('lang.admin.member.members.index', ['filter_ip' => $result->ip])
			];
		}

		$ip_total = $this->memberService->getTotalIpsByCustomer($member_id);

        $pagination = $this->pagination([
			'total' => $ip_total,
			'page'  => $page,
			'limit' => 10,
			'url'   => route('lang.admin.member.members.ip', ['member_id'=>$member_id, 'page'=>'{page}']),
		]);

        $data['pagination'] = $pagination;

		$data['results'] = sprintf($lang->text_pagination, ($ip_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($ip_total - 10)) ? $ip_total : ((($page - 1) * 10) + 10), $ip_total, ceil($ip_total / 10));

		return view('ocadmin.member.member_ip', $data);
	}

    public function pagination($setting)
    {
        // Language
        $lang = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $lang->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $lang->$key = $value;
        }

        $setting['lang'] = $lang;
        // End Language

		if (isset($setting['total'])) {
			$total = $setting['total'];
		} else {
			$total = 0;
		}

		if (isset($setting['page']) && $setting['page'] > 0) {
			$page = (int)$setting['page'];
		} else {
			$page = 1;
		}

		if (isset($setting['limit'])) {
			$limit = (int)$setting['limit'];
		} else {
			$limit = 10;
		}

		if (isset($setting['url'])) {
			$url = str_replace('%7Bpage%7D', '{page}', (string)$setting['url']);
		} else {
			$url = '';
		}

		$num_links = 8;
		$num_pages = ceil($total / $limit);

		if ($url && $page > 1 && $num_pages < $page) {
			$back = true;
		} else {
			$back = false;
		}

		$data['page'] = $page;

		if ($page > 1) {
			$data['first'] = str_replace(['&amp;page={page}', '?page={page}', '&page={page}'], '', $url);

			if ($page - 1 === 1) {
				$data['prev'] = str_replace(['&amp;page={page}', '?page={page}', '&page={page}'], '', $url);
			} else {
				$data['prev'] = str_replace('{page}', $page - 1, $url);
			}
		} else {
			$data['first'] = '';
			$data['prev'] = '';
		}

		$data['links'] = [];

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			for ($i = $start; $i <= $end; $i++) {
				$data['links'][] = [
					'page' => $i,
					'href' => str_replace('{page}', $i, $url)
				];
			}
		}

		if ($num_pages > $page) {
			$data['next'] = str_replace('{page}', $page + 1, $url);
			$data['last'] = str_replace('{page}', $num_pages, $url);
		} else {
			$data['next'] = '';
			$data['last'] = '';
		}

		if ($num_pages > 1 || $back) {
			return view('ocadmin._partials.pagination', $data);
		} else {
			return '';
		}

    }

    // Maybe it's not good to do this.
    public function massDelete()
    {
        echo "<pre>", print_r('massDelete', 1), "</pre>";
    }
}
