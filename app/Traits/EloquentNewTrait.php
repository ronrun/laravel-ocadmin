<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait EloquentNewTrait
{
    public function initialize($data = null)
    {
        $this->model = new $this->model_name;
        $this->table = $this->model->getTable();
        $this->connection  = $this->model->getConnectionName();
        $this->table_columns = $this->getTableColumns($this->connection);
        $this->locale = app()->getLocale();
        $this->is_mapping_zh_hant_hans = false;
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
    // public function findOrFailOrNew($id, $model)
    // {
    //     //find
    //     if(!empty($id)){
    //         $row = $model->where('id', $id)->firstOrFail();
    //     }
    //     //new
    //     else{
    //         $row = $model;
    //     }

    //     return $row;
    // }

    public function getRows($data = [], $debug = 0): mixed
    {
        $this->initialize();
        $query = $this->model->query();

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
            $translationTable = $this->getTranslationTable();
            $master_key = $this->getTranslationMasterKey();
            $sort = $data['sort'];

            $query->join($translationTable, function ($join) use ($translationTable, $master_key, $sort){
                $join->on("{$this->table}.id", '=', "{$translationTable}.{$master_key}")
                     ->where("{$translationTable}.locale", '=', $this->locale)
                     ->where("{$translationTable}.meta_key", '=', $sort);
            });

            $query->orderBy("{$translationTable}.meta_value", $order);

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
            $this->getQueries($query);
        }


        // get result
        $result = [];

        // single row
        if(isset($data['first']) && $data['first'] = true){
            $result = $query->first();
            //$result = $this->getMetas($result);
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
    
            if($pagination == true && $limit != 0){
                $result = $query->paginate($limit); // Get some rows per page
            }
            else if($pagination == false && $limit != 0){
                $result = $query->limit($limit)->get(); // Get some rows without pagination
            }
            else if($pagination == false && $limit == 0){
                $result = $query->get(); // Get all
            }

            if(count($result) > 0){
                foreach ($result as $row) {
                    //$row = $this->getMetas($row);
                    //$row = $this->setTranslationToRow($row);
                }



            }
        }

        return $result;
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
            // 未指定欄位
            if(empty($columns)){
                $row->{$translation->meta_key} = $translation->meta_value;
            }
            // 有指定欄位
            else if(!empty($columns)){
                if(in_array($translation->meta_key, $columns)){
                    $row->{$translation->meta_key} = $translation->meta_value;
                }else{
                    continue;
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

    public function save($row, $data)
    {
        $this->initialize();

        if(!empty($row->getFillable())){
            $row->fill($data);
            return $row->save();
        }
        
        $table_columns = $this->table_columns;
        $form_columns = array_keys($data);

        foreach ($table_columns as $column) {
            if(!in_array($column, $form_columns)){
                continue;
            }

            $row->$column = $data[$column];
        }

        return $row->save;
    }

    public function getMetaModel()
    {
        if(!empty($this->model->meta_model_name)){
            $meta_model_name = $this->model->meta_model_name;
        }else{
            $meta_model_name = get_class($this->model) . 'Meta';
        }

        return new $meta_model_name();
    }

    public function saveTranslationMeta($masterRow, $data)
    {
        $meta_keys = $masterRow->meta_keys;
        $meta_model = $this->getMetaModel();

        // Keys
        $master_key = $meta_model->master_key ?? $masterRow->getForeignKey();
        $master_key_value = $masterRow->id;

        $upsert_data = [];

        foreach($data as $locale => $row){
            $arr = [];
            foreach ($row as $key => $value) {
                $arr[$master_key] = $master_key_value;
                $arr['locale'] = $locale;
                $arr['meta_key'] = $key;
                $arr['meta_value'] = $value;
            }
            $upsert_data[] = $arr;
        }

        $meta_model->upsert($upsert_data,[$master_key, 'locale', 'meta_key']);
    }

    private function getTableColumns()
    {
        $table_columns = $this->model->getFillable();

        if(empty($table_columns)){
            $table_columns = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        }

        return $table_columns;
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

    private function getTranslationModel()
    {
        if(empty($translationModelName)){
            $translationModelName = get_class($this->model) . 'Meta';
        }

        if(empty($translationModelName) && !empty($this->model->translationModelName)){ // Customized
            $translationModelName = $this->model->translationModelName;
        }

        return new $translationModelName();
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

    private function getTranslationTable()
    {
        $translation_model = $this->getTranslationModel();
        return $translation_model->getTable();      
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

    private function getQueries(Builder $builder)
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
}