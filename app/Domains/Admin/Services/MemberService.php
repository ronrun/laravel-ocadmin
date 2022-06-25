<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Traits\DataTrait;
use App\Models\Member;
use DB;

class MemberService
{
	use DataTrait;

    private $modelName = "\App\Models\Member";

	public function __construct()
	{
		$this->model = new $this->modelName;
		$this->table = $this->model->getTable();
	}

	public function defineFilters()
	{
		$result['number'] = [
			'filter_id' => 'id',
			'filter_code' => 'code',
			'filter_status' => 'status',
		];

		$result['string'] = [
			'filter_name' => 'name',
			'filter_email' => 'email',
			'filter_ip' => 'ip',
		];

		return $result;
	}

	public function getIps(int $member_id, int $start = 0, int $limit = 10): object 
	{
		if ($start < 0) {
			$start = 0;
		}
		if ($limit < 1) {
			$limit = 10;
		}
		$rows = DB::table('member_ips')->where('member_id', $member_id)->orderBy('created_at')->skip($start)->take(10)->get();

		return $rows;
	}

	public function getTotalCustomersByIp(string $ip): int {
		$row = DB::table('member_ips')->select(DB::raw('COUNT(DISTINCT `member_id`) AS `total`'))->where('ip', $ip)->first();

		return (int)$row->total;
	}

	public function getTotalIpsByCustomer(int $member_id): int 
	{
		$row = DB::table('member_ips')->select(DB::raw('COUNT(*) AS `total`'))->where('member_id', $member_id)->first();

		return (int)$row->total;
	}

	public function getTotalRegisteredCustomersByIp(string $ip): int 
	{
		$row = DB::table('members')->select(DB::raw('COUNT(DISTINCT `id`) AS `total`'))->where('ip', $ip)->first();

		return (int)$row->total;
	}

	public function getMemberGroups($data = [])
	{

	}

	public function addMember($data)
	{
		$row = $this->newModel();

		$row->firstname 	= $data['firstname'];
		$row->lastname 		= $data['lastname'];

		if(empty($data['name'])){
			$row->name		= $data['firstname'] . ' ' . $data['lastname'];
		}else{
			$row->name		= $data['name'];
		}

		$row->email 		= $data['email'];
		$row->member_group_id = $data['member_group_id'];
		$row->status = (isset($data['status']) && $data['status']==1) ? 1 : 0;

		if(!empty($data['password'])){
			$row->password = bcrypt($data['password']);
		}
	  
		return $this->checkSqlExecution($row->save(), $row, 'id');
	}

	public function editMember($member_id, $data)
	{
		$row = $this->newModel()->find($member_id);

		$row->firstname		= $data['firstname'];
		$row->lastname		= $data['lastname'];

		if(empty($data['name'])){
			$row->name		= $data['firstname'] . ' ' . $data['lastname'];
		}else{
			$row->name		= $data['name'];
		}
		
		$row->email			= $data['email'];
		$row->member_group_id = $data['member_group_id'];
		$row->status = (isset($data['status']) && $data['status']==1) ? 1 : 0;

		$row->telephone		= $data['telephone'];
		if(!empty($data['password'])){
			$row->password = bcrypt($data['password']);
		}

		return $this->checkSqlExecution($row->save(), $row, 'id');
	}
}