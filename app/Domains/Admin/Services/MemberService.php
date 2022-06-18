<?php

namespace App\Domains\Admin\Services;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Domains\Admin\Traits\DataTrait;
use DB;

class MemberService
{
    use DataTrait;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->modelName = "\App\Models\Member";
        $this->model = new $this->modelName;
        $this->table = $this->model->getTable();
    }

    public function defineFilters()
    {
        $result['number'] = [
            'filter_id' => 'id',
            'filter_code' => 'code',
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


		//$query = $this->db->query("SELECT `ip`, `store_id`, `country`, `date_added` FROM `" . DB_PREFIX . "customer_ip` WHERE `customer_id` = '" . (int)$customer_id . "' ORDER BY `date_added` DESC LIMIT " . (int)$start . "," . (int)$limit);

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

}