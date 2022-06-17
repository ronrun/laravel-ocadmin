<?php

namespace App\Domains\Admin\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tiptop\TTGEM;

class UserService
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->modelName = "\App\Models\User";
        $this->model = new $this->modelName;
        $this->table = $this->model->getTable();

    }

    private function newModel()
    {
      return new $this->modelName;
    }

    public function create($data)
    {
        $row= new $this->modelName;
        $row->username = $data['username'];
        $row->password = bcrypt($data['password']);
        $row->name = $data['name'] ?? '';
        $row->email = $data['email'] ?? '';
  
        return $this->checkSqlExecution($row->save(), $row);
    }

    public function getRows($data = array(), $debug = 0)
    {
        $query = $this->newModel()->query();

        if(!empty($data['_with'])){
            foreach($data['_with'] as $with){
                $query->with($with);
            }             
        }

        if(!empty($data['filter_ids'])){
            $query->whereIn('id', $data['filter_ids']);
        }

        if(!empty($data['filter_name'])){
            $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

            $query->where(function ($query) use($words) {
                $query->orWhere(function ($query2) use($words) {
                    foreach ($words as $word) {
                        $query2->where('name', 'like', "%{$word}%");
                    }
                });
            });
        }

        if(!empty($data['filter_email'])){
            $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_email'])));

            $query->where(function ($query) use($words) {
                $query->orWhere(function ($query2) use($words) {
                    foreach ($words as $word) {
                        $query2->where('email', 'like', "%{$word}%");
                    }
                });
            });
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $order = 'ASC';
        }else{
            $order = 'DESC';
        }

        if (isset($data['sort'])) {
            if($data['sort'] == 'user_id'){
                $sort = $this->table . '.id';
            } else if($data['sort'] =='user_name'){
                $sort = $this->table . '.name';
            } else if($data['sort'] =='user_username'){
                $sort = $this->table . '.username';
            } else if($data['sort'] =='user_email'){
                $sort = $this->table . '.email';
            }
            $query->orderBy($sort, $order);

        }else{
            $query->orderBy($this->table .'.id', $order);
        }

        if (isset($data['limit'])) {
            $rows = $query->paginate($data['limit']);
        }else{
            $rows = $query->paginate(10);
        }

        foreach ($rows as $row) {
            $row->url_edit = route('lang.admin.system.user.users.edit', $row->id);
        }

        return $rows;
    }

    public function findIdOrNew($id = null)
    {
        if(empty($id)){
            $row = new $this->modelName;
        }else{
            $row = $this->model->find($id);
        }

        if (is_subclass_of($row, 'Illuminate\Database\Eloquent\Model')) {
            return $row;
        }
        return false;      
    }

    public function updateById($data, $id)
    {
        $row = $this->model->find($id);

        if(!empty($data['password'])){
            $row->password = bcrypt($data['password']);
        }
        $row->name = $data['name'] ?? '';
        $row->email = $data['email'] ?? '';
        $row->mobilephone = $data['mobilephone'] ?? '';

        return $this->checkSqlExecution($row->save(), $row);
    }

    public function updateByKey($key, $value, $data)
    {
        $row = $this->model->where($key, $value)->first();

        $row->name = $data['name'] ?? null;
        $row->username  = $data['username'];
        $row->email = $data['email'] ?? null;
        $row->password = !empty($data['password']) ? bcrypt($data['password']) : $row->password;
        $row->status = $data['status'] ?? null;
  
        return $this->checkSqlExecution($row->save(), $row);
    }

    public function checkSqlExecution($status, $object)
    {
        if($status){
            return $object;
        }else{
            return false;
        }
    }

}