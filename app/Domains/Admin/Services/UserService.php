<?php

namespace App\Domains\Admin\Services;

use App\Domains\Admin\Traits\DataTrait;
use App\Models\User;

class UserService
{
	use DataTrait;

    public $modelName = "\App\Models\User";

    public function __construct()
    {
        $this->model = new $this->modelName;
        $this->table = $this->model->getTable();
    }

	public function addUser($data)
	{
		$row = $this->newModel();
		
		$row->username 		= $data['username'];
		$row->email 		= $data['email'];
		$row->name          = $data['name'];
		$row->status = (isset($data['status']) && $data['status']==1) ? 1 : 0;

		if(!empty($data['password'])){
			$row->password = bcrypt($data['password']);
		}
	  
		return $this->checkSqlExecution($row->save(), $row, 'id');
	}

	public function editUser($member_id, $data)
	{
        $row = $this->model->find($member_id);

        $row->name          = $data['name'];
        $row->email         = $data['email'];
		$row->status = (isset($data['status']) && $data['status']==1) ? 1 : 0;

        if(!empty($data['password'])){
            $row->password = bcrypt($data['password']);
        }

		return $this->checkSqlExecution($row->save(), $row, 'id');
    }
}