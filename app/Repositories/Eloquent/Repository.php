<?php

namespace App\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ChineseChacracterConvert as ZhConvert;
//use ZhConvert;
use DB;

class Repository
{
    protected $modelName;

    public function __construct()
    {
        $this->model = new $this->modelName;
        $this->table = $this->model->getTable();
        $this->table_columns = $this->getTableColumns($this->table);
        $query = DB::table($this->table);
    }

    public function getNewModel()
    {
        return new $this->modelName;        
    }

    public function all($columns = ['*'], $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    public function find($id, $columns = ['*'], $relations = [], $appends = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->findOrFail($id)->append($appends);
    }

    public function getWhereFirst($column, $value, $columns = ['*'], $relations = [])
    {
        return $this->model->select($columns)->where($column, $value)->first()->with($relations);
    }

    public function getWhere($column, $value, $columns = ['*'], $relations = [])
    {
        return $this->model->select($columns)->where($column, $value)->with($relations)->get();
    }

    // 以上從網路複製而來。未使用過。
    // 以下自創。

    private function getWhereQuery($query, $column, $value)
    {
        $value = str_replace(' ', '*', trim($value));

        $operators = ['=','<','>', '*'];

        $has_operator = false;
        foreach ($operators as $operator) { 
            if(strpos($value, $operator) !== false){
                $has_operator = true;
                break;
            }
        }

        if($has_operator == false || preg_match("/^[\d\w\-\.]+$/", $value)){
            $query->where($column, 'LIKE', "%$value%");
        }else{
            if($value === '='){ // = :Empty or null
                $query->where(function ($query) use($column) {
                    $query->orWhereNull($column);
                    $query->orWhere($column, '=', '');
                });
            }
            else if(strpos($value, '=') === 0 && strlen($value) > 1){ // =something : Completely Equal
                $value = substr($value,1);
                $query->where($column, '=', $value);
            }
            else if($value === '<>'){ // <> :Not empty or not null
                $query->where(function ($query) use($column) {
                    $query->orWhereNotNull($column);
                    $query->orWhere($column, '<>', '');
                });
            }
            else if(strpos($value, '<>') === 0 && strlen($value) > 2){ // <>something :Not equal something
                $value = substr($value,2);
                $query->where($column, '<>', $value);
            }
            else if(strpos($value, '<') === 0 && strlen($value) > 1){ // <something :Smaller than something
                $value = substr($value,1);
                $query->where($column, '<', $value);
            }
            else if(strpos($value, '>') === 0 && strlen($value) > 1){ // >something :Bigger than something
                $value = substr($value,1);
                $query->where($column, '>', $value);
            }else{
                $zhtw = str_replace('*', '(.*)', ZhConvert::ChsToCht($value));
                $zhcn = str_replace('*', '(.*)', ZhConvert::ChtToChs($value));

                if(substr($value,0, 1) == '*' && substr($value,-1) != '*'){
                    $query->where(function ($query) use($column, $zhtw, $zhcn) {
                        $query->orWhere($column, 'REGEXP', $zhtw.'$');
                        $query->orWhere($column, 'REGEXP', $zhcn.'$');
                    });
                }else if(substr($value,0, 1) != '*' && substr($value,-1) == '*'){
                    $query->where(function ($query) use($column, $zhtw, $zhcn) {
                        $query->orWhere($column, 'REGEXP', '^'.$zhtw);
                        $query->orWhere($column, 'REGEXP', '^'.$zhcn);
                    });
                }else{
                    $query->where(function ($query) use($column, $zhtw, $zhcn) {
                        $query->orWhere($column, 'REGEXP', $zhtw);
                        $query->orWhere($column, 'REGEXP', $zhcn);
                    });
                }
            }
        }

        return $query;
    }

    private function getOrWhereQuery($query, $column, $value)
    {
        $value = str_replace(' ', '*', trim($value));

        $operators = ['=','<','>', '*'];

        $has_operator = false;
        foreach ($operators as $operator) { 
            if(strpos($value, $operator) !== false){
                $has_operator = true;
                break;
            }
        }

        if($has_operator == false || preg_match("/^[\d\w\-\.]+$/", $value)){
            $query->orWhere($column, 'LIKE', "%$value%");
        }else{
            if($value === '='){ // = :Empty or null
                $query->orWhere(function ($query) use($column, $zhtw, $zhcn) {
                    $query->orWhereNull($column);
                    $query->orWhere($column, '=', '');
                });
            }
            else if(strpos($value, '=') === 0 && strlen($value) > 1){ // =something : Completely Equal
                $value = substr($value,1);
                $query->orWhere($column, '=', $value);
            }
            else if($value === '<>'){ // <> :Not empty or not null
                $query->orWhere(function ($query) use($column) {
                    $query->orWhereNotNull($column);
                    $query->orWhere($column, '<>', '');
                });
            }
            else if(strpos($value, '<>') === 0 && strlen($value) > 2){ // <>something :Not equal something
                $value = substr($value,2);
                $query->orWhere($column, '<>', $value);
            }
            else if(strpos($value, '<') === 0 && strlen($value) > 1){ // <something :Smaller than something
                $value = substr($value,1);
                $query->orWhere($column, '<', $value);
            }
            else if(strpos($value, '>') === 0 && strlen($value) > 1){ // >something :Bigger than something
                $value = substr($value,1);
                $query->orWhere($column, '>', $value);
            }else{
                if(substr($value,0, 1) == '*' && substr($value,-1) != '*'){
                    $query->orWhere(function ($query) use($column, $zhtw, $zhcn) {
                        $query->orWhere($column, 'REGEXP', $zhtw.'$');
                        $query->orWhere($column, 'REGEXP', $zhcn.'$');
                    });
                }else if(substr($value,0, 1) != '*' && substr($value,-1) == '*'){
                    $query->orWhere(function ($query) use($column, $zhtw, $zhcn) {
                        $query->orWhere($column, 'REGEXP', '^'.$zhtw);
                        $query->orWhere($column, 'REGEXP', '^'.$zhcn);
                    });
                }else{
                    $query->orWhere(function ($query) use($column, $zhtw, $zhcn) {
                        $query->orWhere($column, 'REGEXP', $zhtw);
                        $query->orWhere($column, 'REGEXP', $zhcn);
                    });
                }
            }
        }

        return $query;
    }


    public function getRows($data, $columns = '*')
    {
        $query = $this->getNewModel()->query();

        // Special conditions
        if(!empty($data['_orWhere'])){
            $query->where(function ($query) use($data) {
                foreach ($data['_orWhere'] as $orWhere) {
                    $query->where(function ($query) use($orWhere) {
                        $value = $orWhere['value'];
                        foreach ($orWhere['columns'] as $column) {
                            $query = $this->getOrWhereQuery($query, $column, $value);
                        }
                    });
                }
            });
        }

        if(!empty($data['_relation_orWhere'])){
            foreach ($data['_relation_orWhere'] as $relation => $sets) {
                $query->with($relation, function ($query) use ($sets) {
                    $query->where(function ($query) use ($sets){
                        foreach ($sets as $set) {
                            $value = $set['value'];
                            foreach ($set['columns'] as $column) {
                                $query = $this->getOrWhereQuery($query, $column, $value);
                            }
                        }
                    });
                });
            }
        }
        // Special conditions End

        //filters_
        foreach ($data as $key => $value) {
            $column = null;

            // Has to start with filter_
            if(strpos($key, 'filter_') === 0 ){
                $column = str_replace('filter_', '', $key);
                $value = str_replace(' ', '*', trim($value));
            }else{
                continue;
            }

            // Has to be the table's columns
            if(!in_array($column, $this->table_columns)){
                return false;
            }
            
            $query = $this->getWhereQuery($query, $column, $value);
        }
        
        // _and_OrWhere
        if(!empty($data['_and_OrWhere'])){
            $query->where(function ($query) use($data) {
                foreach ($data['_and_OrWhere'] as $orWhere) {
                    $column = $this->stripFilterStr($orWhere[0]);
                    $value = $orWhere[1];
                    $query = $this->getOrWhereQuery($query, $column, $value);
                }
            });
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
        
        // If sort column provided
        if (!empty($data['sort'])) {
            $this->table = $this->model->getTable();
            $sort = $this->table . '.' . $data['sort'];
            $query->orderBy($sort, $order);
        }
        // If no sort column provided, use id and DESC
        else{
            $query->orderBy($this->table .'.id', 'DESC');
        }
        
        if($columns !== '*'){
            $query->select($columns);
        }

        // see the sql statement
        if(isset($data['_debug']) && $data['_debug'] == 1){
            $debugData['sql'] = $query->toSql();
            $debugData ['bidings'] = $query->getBindings();
            echo "<pre>".print_r($debugData , 1)."</pre>";
        }

        if(empty($data['no_pagination'])){        
            if(isset($data['limit'])){
                $limit = (int)$data['limit'];
            }else if(config('settings.paginate_limit')){
                $limit = config('settings.paginate_limit');
            }else{
                $limit = 10;
            }
    
            $pagination = true;
            if(isset($data['pagination'])){
                $pagination = (boolean)$data['pagination'];
            }
    
            if($limit !== 0 && $pagination === true){  // Get some rows per page
                $rows = $query->paginate($limit);
            }else if($limit !== 0 && $pagination === false){ // Get some rows from beginning without pagination
                $rows = $query->limit($limit)->get();
            }else if($limit === 0 && $pagination === false){ // Get all rows without pagination
                $rows = $query->get();
            }else{
                return false;
            }
        }else{
            $rows = $query->get();
        }

        return $rows;
    }

    
    public function updateOrCreate($wheres, $data, $force)
    {
        $query = $this->getNewModel()->query();
        $result = $query->updateOrCreate($wheres, $data);

        if(!empty($result)){
            return true;
        }

        return false;
    }


    public function upsert($allData, $whereColumns, $update)
    {
        $query = $this->getNewModel()->query();
        
        $query->upsert($allData, $whereColumns, $update); //updateOrCreate
    }

    
	public function getTableColumns($table)
	{
		return DB::getSchemaBuilder()->getColumnListing($table);
	}


    public function stripFilterStr($filterColumn)
    {
        if(strpos($filterColumn, 'filter_') === 0 ){
            $column = str_replace('filter_', '', $filterColumn);
        }else{
            $column = $filterColumn;
        }

        return $column;
    }
}