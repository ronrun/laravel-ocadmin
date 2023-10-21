<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Common\Taxonomy;

/**
 * $model_name
 */
trait EloquentNewTrait
{
    public function initialize($data = null)
    {
        if(isset($this->eloquent_trait_initialized) && $this->eloquent_trait_initialized == true){
            return;
        }

        $this->model = new $this->model_name;
        $this->table = $this->model->getTable();
        $this->table_columns = $this->getTableColumns();
        $this->translation_table = $this->model->getTranslationTable();
        $this->locale = app()->getLocale();
        $this->is_mapping_zh_hant_hans = false;
        $this->eloquent_trait_initialized = true;
    }

    public function newModel()
    {
        $model = new $this->model_name;

        if(empty($this->model)){
            $this->model = $model;
        }

        return $model;
    }

    public function findIdOrFailOrNew($id, $data = null, $debug = 0)
    {
        //find
        if(!empty(trim($id))){
            $query = $this->newModel()->where('id', $id);
            $row = $query->firstOrFail();
        }
        //new
        else{
            $row = $this->newModel();
        }

        return $row;
    }

    public function getRows($data = [], $debug = 0): mixed
    {
        $this->initialize();

        $query = $this->model->query();

        // is_active can only be: 1, 0, -1, *
        if(in_array('is_active', $this->table_columns)){
            
            // - 相容以前的舊寫法
            if(isset($data['filter_is_active'])){
                $data['equal_is_active'] = $data['filter_is_active'];
                unset($data['filter_is_active']);
            }

            // - 如果 equal_is_active 是 *, 或長度是 0 ，或值小於0，表示不做 is_active 判斷。
            if(isset($data['equal_is_active']) && ($data['equal_is_active'] == '*' || strlen($data['equal_is_active']) === 0 || $data['equal_is_active'] < 0)){
                unset($data['equal_is_active']);
            }

            // - 開始判斷
            if(isset($data['equal_is_active'])){
                $equal_is_active = $data['equal_is_active'];

                // -- 變數為值=0，表示不啟用。除了真的是0，把null也算在內。
                if($equal_is_active == 0){
                    $query->where('is_active', '<>', 1);
                    // $query->where(function ($query) use($equal_is_active) {
                    //     $query->orWhere('is_active', 0);
                    //     $query->orWhereNull('is_active');
                    // });
                }else if($equal_is_active == 1){
                    $query->where('is_active', 1);
                }

                unset($data['equal_is_active']);
            }
        }


        // Equals
        $query = $this->setEqualsQuery($query, $data);

        // Filters
        $query = $this->setFiltersQuery($query, $data);

        // Sort & Order
        //  - Order
        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $order = 'ASC';
        }
        else{
            $order = 'DESC';
        }

        //  - Sort
        if(!empty($this->model->translation_attributes) && in_array($data['sort'], $this->model->translation_attributes)){
            $translation_table = $this->getTranslationTable();
            $master_key = $this->getTranslationMasterKey();
            $sort = $data['sort'];

            $query->join($translation_table, function ($join) use ($translation_table, $master_key, $sort){
                $join->on("{$this->table}.id", '=', "{$translation_table}.{$master_key}")
                     ->where("{$translation_table}.locale", '=', $this->locale)
                     ->where("{$translation_table}.meta_key", '=', $sort);
            });

            $query->orderBy("{$translation_table}.meta_value", $order);

            $query->select("{$this->table}.*");
        }else{
            if(empty($data['sort']) || $data['sort'] == 'id'){
                $sort = $this->model->getTable() . '.id';
            }
            else{
                $sort = $data['sort'];
            }
            $query->orderBy($sort, $order);
        }


        // see the sql statement
        if(!empty($debug)){
            $this->getQueryDebug($query);
        }


        // get result

        // single row
        if(isset($data['first']) && $data['first'] = true){
            $row = $query->first();
            //$result = $this->getMetas($result);
            return $row;
        }
        // multi rows
        else{
            // Limit
            if(isset($data['limit'])){
                $limit = (int)$data['limit'];
            }else if(!empty(config('setting.config_admin_pagination_limit'))){
                $limit = (int)config('setting.config_admin_pagination_limit');
            }else{
                $limit = 10;
            }
    
            // Pagination
            if(isset($data['pagination']) ){
                $pagination = (boolean)$data['pagination'];
            }else{
                $pagination = true;
            }
    
            $rows = [];

            if($pagination == true && $limit != 0){
                $rows = $query->paginate($limit); // Get some rows per page
            }
            else if($pagination == false && $limit != 0){
                $rows = $query->limit($limit)->get(); // Get some rows without pagination
            }
            else if($pagination == false && $limit == 0){
                $rows = $query->get(); // Get all
            }

            // translation to rows
            foreach ($rows as $row) {
                foreach ($row->translation ?? [] as $translation) {
                    $row->{$translation->meta_key} = $translation->meta_value;
                    unset($row->translation);
                }
            }

            return $rows;
        }

    }

    public function getRow($data, $debug=0)
    {
        $data['first'] = true;
        $row = $this->getRows($data, $debug);
        return $row;
    }

    // Current Language
    public function setTranslationToRow($row, $columns = [])
    {
        foreach ($row->translation as $translation) {
            // 未指定欄位, 全抓
            if(empty($columns)){
                $row->{$translation->meta_key} = $translation->meta_value;
            }
            // 有指定欄位
            else{
                if(in_array($translation->meta_key, $columns)){
                    $row->{$translation->meta_key} = $translation->meta_value;
                }
            }
            
            $row->setRelation('translation',null);
        }

        return $row;
    }

    public function setTranslationToRows($rows, $columns = [])
    {
        foreach ($rows as $row) {
            $row = $this->setTranslationToRow($row, $columns);
        }

        return $rows;
    }

    // Multi Language
    public function setTranslationstoRow($row, $columns = [])
    {
        $formattedTranslations = [];

        foreach ($row->translations as $translation) {
            $locale = $translation->locale;
            $column = $translation->meta_key;
            $value = $translation->meta_value;
            $formattedTranslations[$locale][] = [$column => $value];
        }

        $row->setRelation('translations', collect($formattedTranslations));

        return $row;
    }

    public function setTranslationstoRows($rows)
    {
        $rows->load('translations');

        foreach ($rows as $row) {
            $row = $this->setTranslationstoRow($row);
        }

        return $rows;
    }

    /**
     * modified: 2023-10-21
     */
    public function saveRow($id, $post_data)
    {
        try{

            $modelInstance = $this->findIdOrFailOrNew($id);

            // save basic data
            $result = $this->saveRowBasicData($modelInstance, $post_data);

            if(!empty($result['error'])){
                throw new \Exception($result['error']);
            }

            //$modelInstance->refresh();
            $result = null;

            // save translation data
            if(!empty($post_data['translations'])){
                if (substr($this->model->translation_model_name, -4) === 'Meta') {
                    $result = $this->saveRowTranslationMetaData($modelInstance, $post_data['translations']);
                }else{
                    $result = $this->saveRowTranslationData($modelInstance, $post_data['translations']);
                }

                if(!empty($result['error'])){
                    throw new \Exception($result['error']);
                }
            }

            // save meta data
            $this->saveRowMetaData($modelInstance, $post_data);

            return ['data' =>['id' => $modelInstance->id]];
        } catch (\Exception $ex) {
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }

    }

    /**
     * modified: 2023-10-21
     */
    public function saveRowBasicData($modelInstance, $post_data)
    {
        $this->initialize();

        try{
            DB::beginTransaction();

            // If $model->fillable exists, save() then return
            if(!empty($modelInstance->getFillable())){
                $modelInstance->fill($post_data);
                $modelInstance->save();
                return $modelInstance->id;
            }
            
            // Save matched columns
            $table_columns = $this->table_columns;
            $form_columns = array_keys($post_data);

            foreach ($form_columns as $column) {
                if(!in_array($column, $table_columns)){
                    continue;
                }

                $modelInstance->$column = $post_data[$column];
            }

            $modelInstance->save();
            DB::commit();

            return $modelInstance->id;

        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

    /**
     * modified: 2023-10-21
     */
    public function saveRowTranslationMetaData($masterModelInstance, $translation_data)
    {
        $this->initialize();

        try {
            $translation_model = $this->model->getTranslationModel();

            // Keys
            $master_key = $translation_model->master_key ?? $masterModelInstance->getForeignKey();
            $master_key_value = $masterModelInstance->id;

            $upsert_data = [];
            
            foreach($translation_data as $locale => $row){
                $arr = [];
                foreach ($row as $column => $value) {
                    
                    if(!in_array($column, $this->model->translation_attributes)){
                        continue;
                    }
                    $arr[$master_key] = $master_key_value;
                    $arr['locale'] = $locale;
                    $arr['meta_key'] = $column;
                    $arr['meta_value'] = $value;
                    $upsert_data[] = $arr;
                }
            }

            DB::beginTransaction();
            $translation_model->upsert($upsert_data,[$master_key, 'locale', 'meta_key']);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

    /**
     * modified: 2023-10-21
     */
    public function saveRowTranslationData($masterModelInstance, $translation_data)
    {
        $this->initialize();

        try{
            $translation_model = $this->model->getTranslationModel();

            // master
            $master_key = $translation_model->master_key ?? $masterModelInstance->getForeignKey();
            $master_key_value = $masterModelInstance->id;

            foreach($translation_data as $locale => $value){
                $arr = [];
                if(!empty($value['id'])){
                    $arr['id'] = $value['id'];
                }
                $arr['locale'] = $locale;
                $arr[$master_key] = $master_key_value;
                foreach ($this->model->translation_attributes as $column) {
                    if(!empty($value[$column])){
                        $arr[$column] = $value[$column];
                    }
                }

                $arrs[] = $arr;
            }

            $this->translation_model->upsert($arrs,['id', $master_key, 'locale']);
        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }

    /**
     * modified: 2023-10-21
     */
    public function saveRowMetaData($masterModelInstance, $post_data)
    {
        $this->initialize();

        try {
            $meta_model = $this->model->getMetanModel();
            $meta_table = $meta_model->getTable();

            // Keys
            $master_key = $meta_model->master_key ?? $masterModelInstance->getForeignKey();
            $master_key_value = $masterModelInstance->id;

            $upsert_data = [];
            foreach($post_data as $column => $value){
                if(!in_array($column, $this->model->meta_attributes)){
                    continue;
                }

                $locale_is_nullable = Schema::getConnection()->getDoctrineColumn($meta_table, $column)->getNotnull() == false;

                $arr[$master_key] = $master_key_value;
                $arr['locale'] = $locale_is_nullable ? null : '';
                $arr['meta_key'] = $column;
                $arr['meta_value'] = $value;
                $upsert_data[] = $arr;
            }

            DB::beginTransaction();
            $meta_model->upsert($upsert_data,[$master_key, 'locale', 'meta_key']);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            $result['error'] = 'Error code: ' . $ex->getCode() . ', Message: ' . $ex->getMessage();
            return $result;
        }
    }


    // Private functions


    private function getConnection()
    {
        // if model file defines connection
        if(!empty($this->model->connection)){
            $connection =$this->model->connection;
        }
        // use default connection
        else{
            $connection  = $this->model->getConnectionName();
        }

        return $connection;
    }

    private function getTableColumns()
    {
        $table = $this->model->getTable();
        $connection_name = $this->model->getConnectionName(); // if default, this value is empty

        return DB::connection($connection_name)->getSchemaBuilder()->getColumnListing($table);
    }


    private function setFiltersQuery($query, $data, $debug = 0)
    {
        $translation_attributes = $this->model->translation_attributes ?? [];
        $meta_attributes = $this->model->meta_attributes ?? [];

        // self table
        foreach ($data as $key => $value) {
            // $key has prifix 'filter_'
            // $column is the name of database table's column

            $column = null;

            // Must Start with filter_
            if(str_starts_with($key, 'filter_')){
                $column = str_replace('filter_', '', $key);
            }else{
                continue;
            }

            // Skip emtpy value
            if($value == ''){
                continue;
            }

            // meta column is not processed here
            if(in_array($column, $translation_attributes) || in_array($column, $meta_attributes)){
                continue;
            }

            // Has to be the table's columns
            if(!in_array($column, $this->table_columns)){
                continue;
            }

            if(is_array($value)){ // Filter value can not be array
                continue;
            }

            $value = str_replace(' ', '*', trim($value));

            $query = $this->setWhereQuery($query, $column, $value, 'where');
        }

        // meta table
        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'filter_')){
                continue;
            }else{
                $column = str_replace('filter_', '', $key);
            }
            
            if(!in_array($column, $meta_attributes)){
                continue;
            }

            // not translation
            if(!in_array($column, $translation_attributes)){
                $data['whereHas']['metas'][] = [
                    'locale' => '=',
                    'meta_key' => '='.$column,
                    'meta_value' => $data[$key],
                ];
                unset($data[$key]);
            }

            // translation
            if(in_array($column, $translation_attributes)){
                $data['whereHas']['metas'][] = [
                    'locale' => '='.app()->getLocale(),
                    'meta_key' => '='.$column,
                    'meta_value' => $data[$key],
                ];
                unset($data[$key]);
            }
        }

        // whereHas
        if(!empty($data['whereHas'])){
            $this->setWhereHas($query, $data['whereHas']);
        }

        // sub query
        if(!empty($data['subAndWhere'])){
            foreach ($data['subAndWhere'] as $set) {
                $this->setSubAndWhereQuery($query, $set);
            }
        }
        if(!empty($data['subOrWhere'])){
            foreach ($data['subOrWhere'] as $set) {
                $this->setSubOrWhereQuery($query, $set);
            }
        }

        return $query;
    }

    private function setEqualsQuery($query, $data, $debug = 0)
    {
        $translation_attributes = $this->model->translation_attributes ?? [];
        $meta_attributes = $this->model->meta_attributes ?? [];

        // self table
        foreach ($data as $key => $value) {

            $column = null;
            
            if(str_starts_with($key, 'equal_')){ // Key must start with equal_
                $column = str_replace('equal_', '', $key);
            }else{
                continue;
            }

            if(is_array($value) || empty($value)){ // value can not be empty or array
                continue;
            }

            // Translated column is not processed here
            if(in_array($column, $translation_attributes)){
                continue;
            }

            // meta_attributes is not processed here
            if(in_array($column, $meta_attributes)){
                continue;
            }

            // Has to be the table's columns
            if(!in_array($column, $this->table_columns)){
                continue;
            }

            $value_array = explode('__or__', $value);
            if(count($value_array) > 1){
                $column = $this->table . '.' . $column;
                $query->whereIn($column, $value_array);
            }else{
                $column = $this->table . '.' . $column;
                $query->where($column, $value);
            }
        }

        // meta table for translation
        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'equal_')){
                continue;
            }else{
                $column = str_replace('equal_', '', $key);
            }

            if(in_array($column, $meta_attributes) && in_array($column, $translation_attributes)){
                $data['whereHas']['metas'][] = [
                    'locale' => '='.$this->locale,
                    'meta_key' => '='.$column,
                    'meta_value' => $data[$key],
                ];
                unset($data[$key]);
            }
        }

        // set meta whereHas
        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'equal_')){
                continue;
            }else{
                $column = str_replace('equal_', '', $key);
            }
            
            if(in_array($column, $meta_attributes) && !in_array($column, $translation_attributes)){
                $data['whereHas']['metas'][] = [
                    'meta_key' => '='.$column,
                    'meta_value' => $data[$key],
                ];
                unset($data[$key]);
            }
        }

        return $query;
    }

    private function getTranslationMasterKey()
    {
        $translationModel = $this->getTranslationModel();

        if(!empty($translationModel->master_key)){
            return $translationModel->master_key;
        }else if(!empty($this->model->translation_master_key)){
            return $this->model->translation_master_key;
        }else{
            return $this->model->getForeignKey();
        }
    }

    private function setWhereQuery($query, $column, $value, $type='where')
    {
        if(str_starts_with($column, 'filter_')){
            $column = str_replace('filter_', '', $column);
        }

        $value = trim($value);

        if(strlen($value) == 0){
            return;
        }

        // escapes Ex. phone number (123)456789 => \(123\)456789
        $arr = ['(', ')', '+'];
        foreach ($arr as $symble) {
            if(str_contains($value, $symble)){
                $value = str_replace($symble, '\\'.$symble, $value);
            }
        }

        $operators = ['=','<','>','*'];

        // *foo woo* => foo woo
        if(str_starts_with($value, '*')  && str_ends_with($value, '*') ){
            $value = substr($value,1);
            $value = substr($value,0,-1);
        }

        $has_operator = false;
        foreach ($operators as $operator) {
            if(str_starts_with($value, $operator) != false || str_ends_with($value,'*')){
                $has_operator = true;
                break;
            }
        }

        // No operator
        if($has_operator == false){
            // 'foo woo' => 'foo*woo'
            $value = str_replace(' ', '*', $value);
            // 'foo*woo' => 'foo(.*)woo'
            $value = str_replace('*', '(.*)', $value);
            if($this->is_mapping_zh_hant_hans === true){
                // $zhtw = zhChsToCht($value);
                // $zhcn = zhChtToChs($value);
                // $query->$type(function ($query) use($column, $zhtw, $zhcn) {
                //     $query->orWhere($column, 'REGEXP', $zhtw);
                //     $query->orWhere($column, 'REGEXP', $zhcn);
                // });
            }else{
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, 'REGEXP', $value);
                });
            }

            return $query;
        }

        // '=' Empty or null
        if($value === '='){
            $query->$type(function ($query) use($column) {
                $query->orWhereNull($column);
                $query->orWhere($column, '=', '');
            });
        }
        // '=foo woo' Completely Equal 'foo woo'
        else if(str_starts_with($value, '=') && strlen($value) > 1){
            $value = substr($value,1); // 'foo woo'
            if($this->is_mapping_zh_hant_hans === true){
                // $zhtw = zhChsToCht($value);
                // $zhcn = zhChtToChs($value);
                // $query->$type(function ($query) use($column, $zhtw, $zhcn) {
                //     $query->orWhere($column, '=', $zhtw);
                //     $query->orWhere($column, '=', $zhcn);
                // });
            }else{
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, '=', $value);
                });
            }
        }
        // '<>' Not empty or not null
        else if($value === '<>'){
            $query->$type(function ($query) use($column) {
                $query->orWhereNotNull($column);
                $query->orWhere($column, '<>', '');
            });
        }
        // '<>foo woo' Not equal 'foo woo'
        else if(str_starts_with($value, '<>') && strlen($value) > 2){
            $value = substr($value,2); // 'foo woo'
            if($this->is_mapping_zh_hant_hans === true){
                // $zhtw = zhChsToCht($value);
                // $zhcn = zhChtToChs($value);
                // $query->$type(function ($query) use($column, $zhtw, $zhcn) {
                //     $query->orWhere($column, '<>', $zhtw);
                //     $query->orWhere($column, '<>', $zhcn);
                // });
            }else{
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, '<>', $value);
                });
            }
        }
        // '<123' Smaller than 123
        else if(str_starts_with($value, '<') && strlen($value) > 1){
            $value = (int)substr($value,1);
            if($type == 'where'){
                $query->whereRaw("$column < $value");
            }
            if($type == 'orWhere'){
                $query->orWhereRaw("$column < $value");
            }
        }
        // '>123' bigger than 123
        else if(str_starts_with($value, '>') && strlen($value) > 1){
            $value = (int)substr($value,1);
            if($type == 'where'){
                $query->whereRaw("$column > $value");
            }
            if($type == 'orWhere'){
                $query->orWhereRaw("$column > $value");
            }
        }
        // '*foo woo'
        else if(substr($value,0, 1) == '*' && substr($value,-1) != '*'){
            $value = str_replace(' ', '(.*)', $value);
            $value = "(.*)".substr($value,1).'$';
            if($this->is_mapping_zh_hant_hans === true){
                // $query->$type(function ($query) use($column, $zhtw, $zhcn) {
                //     $query->orWhere($column, 'REGEXP', "$zhtw");
                //     $query->orWhere($column, 'REGEXP', "$zhcn");
                // });
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, 'REGEXP', "$value");
                });
            }else{
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, 'REGEXP', "$value");
                });
            }
        }
        // 'foo woo*'
        else if(substr($value,0, 1) != '*' && substr($value,-1) == '*'){
            $value = substr($value,0,-1); // foo woo
            $value = str_replace(' ', '(.*)', $value); //foo(.*)woo
            $value = '^' . $value . '(.*)';

            if($this->is_mapping_zh_hant_hans === true){
                // $query->$type(function ($query) use($column, $zhtw, $zhcn) {
                //     $query->orWhere($column, 'REGEXP', "$zhtw");
                //     $query->orWhere($column, 'REGEXP', "$zhcn");
                // });
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, 'REGEXP', "$value");
                });
            }else{
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, 'REGEXP', "$value");
                });
            }
        }

        return $query;
    }

    private function setWhereHas($query, $data)
    {
        foreach ($data as $rel_name => $relation) {
            $query->whereHas($rel_name, function($query) use ($relation) {
                foreach ($relation as $set) {
                    $this->setSubAndWhereQuery($query, $set);
                }
            }); 
        }
    }

    private function setSubAndWhereQuery($query, $set)
    {
        $query->where(function ($query) use($set) {
            foreach ($set as $key => $value) {
                $query = $this->setWhereQuery($query, $key, $value,'where');
            }
        });
    }

    private function setSubOrWhereQuery($query, $set)
    {
        $query->where(function ($query) use($set) {
            foreach ($set as $key => $value) {
                $query = $this->setWhereQuery($query, $key, $value,'orWhere');
            }
        });
    }

    private function getQueryDebug(Builder $builder)
    {
        $addSlashes = str_replace('?', "'?'", $builder->toSql());

        $bindings = $builder->getBindings();

        if(!empty($bindings)){
            $arr['statement'] = vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
        }else{
            $arr['statement'] = $builder->toSql();
        }


        $arr['original'] = [
            'toSql' => $builder->toSql(),
            'bidings' => $builder->getBindings(),
        ];

        echo "<pre>".print_r($arr , 1)."</pre>"; exit;
    }


    /**
     * 獲取 meta_data，並根據 meta_keys ，若 meta_key 不存在，設為空值 ''
     */
    private function getMetas($row)
    {
        $local = app()->getLocale();

        if(!empty($row->metas)){
            foreach ($row->metas as $meta) {
                //將 $locale = null, 及 $locale = 當前語言，載入 $row。若 $locale = 非當前語言，不載入
                if($meta->locale == null || $meta->locale == $local){
                    $row->{$meta->meta_key} = $meta->meta_value;
                }
            }

            return $row;
        }

        return [];
    }



    // public function optimizeRow($row)
    // {
    //     if(!empty($this->repository)){
    //         return $this->repository->optimizeRow($row);
    //     }

    //     return $row;
    // }


    // public function sanitizeRow($row)
    // {
    //     if(!empty($this->repository)){
    //         return $this->repository->sanitizeRow($row);
    //     }

    //     return $row;
    // }
}