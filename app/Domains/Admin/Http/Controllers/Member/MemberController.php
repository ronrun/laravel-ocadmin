<?php

namespace App\Domains\Admin\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domains\Admin\Traits\MenuTrait;
use App\Domains\Admin\Services\MemberService;
use Lang;

class MemberController extends Controller
{
    use MenuTrait;

    public function __construct(Request $request, MemberService $memberService)
    {
        //parent::__construct();
        $this->request = $request;
        $this->memberService = $memberService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Language
        $langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $langs->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $langs->$key = $value;
        }

        // Breadcomb
        $breadcumbs[] = (object)array(
            'text' => $langs->text_home,
            'href' => route('lang.admin.dashboard'),
        );
        
        $breadcumbs[] = (object)array(
            'text' => $langs->heading_title,
            'href' => null,
        );
        $data['breadcumbs'] = (object)$breadcumbs;

        $data['langs'] = $this->langs = $langs;
        
        $data['list'] = $this->getList();
        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');

        return view('ocadmin.member.member', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $this->form_action = route('lang.admin.member.members.update', array_merge([$id], $queries));

        return $this->getForm($id, 'edit');
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

        foreach (Lang::get('member/member') as $key => $value) {
            $langs->$key = $value;
        }

        $data['langs'] = $langs;

        // Check Email
		$member_info = $this->memberService->findByKey('email', $request->input('email'));

        if ($member_info && ($id != $member_info->id)) {
            $json['error']['warning'] = $langs->error_exists;
        }

        $update_data = [];
        
        if($this->request->input('name')){
            $update_data['name'] = $this->request->input('name');
        }

        if($this->request->input('firstname')){
            $update_data['firstname'] = $this->request->input('firstname');
        }

        if($this->request->input('lastname')){
            $update_data['lastname'] = $this->request->input('lastname');
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

		if (empty($json)) {
			if (!isset($id) || !is_numerric($id)) {
				//$json['member_id'] = $this->model_customer_customer->addCustomer($this->request->all());
                $json['error']['warning'] = 'id not correct.';
			} else if(is_numerric($id)) {
				$this->memberService->updateByKey('id', $id, $update_data);
			}

			$json['success'] = $this->language->get('text_success');
		}
 
        return response()->json($json);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list()
    {
        // Language
        $this->langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $this->langs->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $this->langs->$key = $value;
        }

        $data['langs'] = $this->langs;
        
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
        $data['langs'] = $langs = $this->langs;

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
                $row->url_edit = route('lang.admin.member.members.edit', array_merge([$row->id], $queries));
                $row->status = ($row->status) ? $this->langs->text_enabled : $this->langs->text_disabled;
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
        $locale = app()->getLocale();
        $backend = env('FOLDER_ADMIN');

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

    public function getForm($id, $action = null)
    {
        //Language
        $langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $langs->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $langs->$key = $value;
        }
        
        $langs->text_form = ($action == 'create') ? $langs->text_add : $langs->text_edit;


        $data['langs'] = $this->langs = $langs;
  
        // Breadcomb
        $breadcumbs[] = (object)array(
            'text' => $langs->text_home,
            'href' => route('lang.admin.dashboard'),
        );
        
        $breadcumbs[] = (object)array(
            'text' => $langs->heading_title,
            'href' => null,
        );
        $data['breadcumbs'] = (object)$breadcumbs;

        $data['menus'] = $this->getMenus();
        $data['base'] = env('APP_URL') . '/' . env('FOLDER_ADMIN');
        $data['form_action'] = $this->form_action;

        // create
        if($action == 'create'){ 
            $member = $this->memberService->newModel($id);
        }
        // edit
        else{
            if(!empty($id)){
                $member = $this->memberService->findByKey('id', $id);
            }else if(!empty($this->query('code'))){
                $member = $this->memberService->findByKey('code', $this->query('code'));
            }
        }

		$data['ip'] = $this->getIp($id); //return view so singular
        
        $data['member'] = $member;


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
        $this->langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $this->langs->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $this->langs->$key = $value;
        }

        return $this->getIp($member_id);
	}

	public function getIp($member_id) 
    {
        //Language
        $data['langs'] = $langs = $this->langs;

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

		$data['results'] = sprintf($langs->text_pagination, ($ip_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($ip_total - 10)) ? $ip_total : ((($page - 1) * 10) + 10), $ip_total, ceil($ip_total / 10));

		return view('ocadmin.member.member_ip', $data);
	}

    public function pagination($setting)
    {
        // Language
        $langs = (object)[];
        foreach (Lang::get('common/common') as $key => $value) {
            $langs->$key = $value;
        }

        foreach (Lang::get('member/member') as $key => $value) {
            $langs->$key = $value;
        }

        $setting['langs'] = $langs;
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
