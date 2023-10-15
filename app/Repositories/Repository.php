<?php

namespace App\Repositories;

use App\Helpers\EloquentHelper;
use App\Traits\EloquentNewTrait;
use Illuminate\Support\Facades\DB;

class Repository
{
    use EloquentNewTrait;

    protected $model_name;
    protected $model;
    protected $table;
    protected $connection;
    protected $table_columns;
    protected $locale;
    protected $is_mapping_zh_hant_hans;

    public function initialize($data = null)
    {
        $this->model = new $this->model_name;
        $this->table = $this->model->getTable();

        if(!empty($data['connection'])){
            $this->connection = $data['connection'];
        }else{
            $this->connection = DB::connection()->getName();
        }
        
        $this->table_columns = $this->getTableColumns($this->connection);

        $this->locale = app()->getLocale();

        $this->is_mapping_zh_hant_hans = false;

    }
}
