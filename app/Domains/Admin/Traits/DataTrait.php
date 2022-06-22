<?php

namespace App\Domains\Admin\Traits;

use Illuminate\Http\Request;

trait DataTrait 
{

    private function newModel()
    {
      return new $this->modelName;
    }

    public function findIdOrNew($id = null)
    {
        if(empty($id)){
            $row = new $this->modelName;
        }else{
            $row = $this->model->find($id);
        }
        return false;      
    }

    public function findByKey($key, $value)
    {
        $model = new $this->modelName;
        $row = $model->where($key, $value)->first();
        return $row;
    }

    public function getRows($data = array(), $debug = 0)
    {
        $query = $this->newModel()->query();

        $defineFilters = $this->defineFilters();
        
        if(!empty($data['filter_ids'])){
            $query->whereIn('id', $data['filter_ids']);
        }

        if(!empty($data['filter_codes'])){
            $query->whereIn('code', $data['filter_codes']);
        }

        $strFilters = array_keys($defineFilters['string']); // ['filete_name', 'fileter_email'...]
        $intFilters = array_keys($defineFilters['number']);
        
        // Where
        foreach ($data as $key => $value) {

            if(in_array($key, $strFilters)){
                $field = $defineFilters['string'][$key];
                // Multiple spaces trim to one space, then explode.
                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $value)));

                foreach ($words as $word) {
                    $query->where($field, 'like', "%{$word}%");
                }
            }
        }

        $sort = $data['sort'] ?? 'id';

        // If order provided
        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $order = 'ASC';
        }
        // Any other situations, use DESC
        else{
            $order = 'DESC';
        }

        // If sort field provided
        if (!empty($data['sort'])) {
            $sort = $this->table . '.' . $data['sort'];
            $query->orderBy($sort, $order);
        }
        // If no sort field provided, use id and DESC
        else{
            $query->orderBy($this->table .'.id', 'DESC');
        }

        if(!empty($data['_with'])){
            foreach($data['_with'] as $with){
                $query->with($with);
            }             
        }

        // see the sql statement
        if(0){
            $debugData['sql'] = $query->toSql();
            $debugData ['bidings'] = $query->getBindings();
            echo "<pre>".print_r($debugData , 1)."</pre>"; exit;
        }

        if (isset($data['limit'])) {
            $rows = $query->paginate($data['limit']);
        }else if(config('settings.paginate_limit')){
            $rows = $query->paginate(config('settings.paginate_limit'));
        }else{
            $rows = $query->paginate(10);
        }

        return $rows;
    }

    public function create($data)
    {
        $row = new $this->modelName;

        foreach ($data as $field => $value) {
            $row->$field = $data[$field];
        }
  
        return $this->checkSqlExecution($row->save(), $row);
    }

    public function updateById($data, $id)
    {
        $row = $this->model->find($id);

        foreach ($data as $field => $content) {
            $row->$field = $content;
        }

        return $this->checkSqlExecution($row->save(), $row);
    }

    public function updateByKey($key, $value, $data)
    {
        $row = $this->model->where($key, $value)->first();

        foreach ($data as $field => $content) {
            $row->$field = $content;
        }
        
        return $this->checkSqlExecution($row->save(), $row);
    }

    // Should be overwrite in controller
    public function defineFilters(){
        $result['number'] = [
            'filter_id' => 'id',
            'filter_code' => 'code',
        ];

        $result['string'] = [
            'filter_name' => 'name',
            'filter_email' => 'email',
        ];

        return $result;
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