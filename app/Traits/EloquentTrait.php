<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Helpers\Classes\DataHelper;
use App\Helpers\Classes\ChineseCharacterHelper;

trait EloquentTrait
{
    private $initialized = false;
    public $zh_hant_hans_transform;

    public function initialize($data = null)
    {
        if($this->initialized){
            return true;
        }

        $this->model = new $this->modelName;
        $this->table = $this->model->getTable();
        $this->table_columns = $this->getTableColumns();
        $this->translation_attributes = $this->model->translation_attributes ?? [];
        $this->zh_hant_hans_transform = true;
        $this->initialized = true;
    }

    public function newModel()
    {
        $model = new $this->modelName;

        if(empty($this->model)){
            $this->model = $model;
        }

        return new $this->modelName;
    }

    public function findIdFirst($id, $params = null)
    {
        $row = $this->newModel()->where('id', $id)->first();

        return $row;
    }

    public function findIdOrNew($id, $params = null, $debug = 0)
    {
        //find
        if(!empty(trim($id))){
            $params['equal_id'] = $id;
            $row = $this->getRow($params);
        }

        //new
        if(empty($row) || empty($id)){
            $row = $this->newModel();
        }

        return $row;
    }

    public function findIdOrFailOrNew($id, $params = null, $debug = 0)
    {
        $row = [];
        
        try{
            //find
            if(!empty(trim($id))){
                $params['equal_id'] = $id;
                $row = $this->getRow($params, $debug);

                if(empty($row)){
                    throw new \Exception ('Record not found!');
                }
            }
            //new
            else{
                $row = $this->newModel();
            }

            return ['data' => $row]; // To make difference with 'error', 'data' is needed.
            
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function getRow($data, $debug=0)
    {
        $data['first'] = true;
        $row = $this->getRows($data, $debug);
        return $row;
    }

    public function getRows($data = [], $debug = 0)
    {
        $this->initialize($data);

        $query = $this->setQuery($data, $debug);

        $rows = $this->getResult($query, $data);
        
        if(empty($data['no_meta_translation'])){
            foreach($rows as $row){
                if (isset($row->translation_model_name) && substr($row->translation_model_name, -4) === 'Meta') {
                    foreach($row->translation as $translation){
                        $column = $translation->meta_key;
                        $row->{$column} = $translation->meta_value;
                        unset($row->translation);
                    }
                }
            }
        }

        return $rows;
    }


    public function setQuery($data=[], $debug = 0)
    {
        $query = $this->newModel()->query();

        $this->setIsActive($query, $data); //equal_is_active
        $this->setWith($query, $data);
        $this->setWhereIn($query, $data);
        $this->setWhereNotIn($query, $data);
        $this->setWhereHas($query, $data);
        $this->setWhereDoesntHave($query, $data);
        $this->setWhereRawSqls($query, $data);
        $this->setEqualsQuery($query, $data);
        $this->setFiltersQuery($query, $data);
        $this->setDistinct($query, $data);
        $this->setSortOrder($query, $data);
        $this->setSelect($query, $data);

        $this->setTranslationsQuery($query, $data);

        $this->showDebugQuery($query, $debug);

        return $query;
    }

    private function setIsActive($query, &$data)
    {
        if(in_array('is_active', $this->table_columns)){
            
            if(isset($data['filter_is_active'])){
                $data['equal_is_active'] = $data['filter_is_active'];
                unset($data['filter_is_active']);
            }

            // - 如果 equal_is_active 是 *, 或長度是 0 ，或值小於0，表示不做 is_active 判斷。
            if(isset($data['equal_is_active']) && ($data['equal_is_active'] === '*' || strlen($data['equal_is_active']) === 0 || $data['equal_is_active'] < 0)){
                unset($data['equal_is_active']);
                return $query;
            }
            
            // - 開始判斷
            if(isset($data['equal_is_active'])){

                if($data['equal_is_active'] == 1){
                    $query->where($this->table . '.is_active', 1);
                }else{
                    $query->where($this->table . '.is_active', '<>', 1);
                }

                unset($data['equal_is_active']);
            }
        }

        return $query;
    }

    private function setWith($query, $data)
    {
        if(empty($data['with'])){
            return $query;
        }

        //width_arr has to be array
        if(is_string($data['with'])){
            $width_arr[] = $data['with'];
        }else if(is_array($data['with'])){
            $width_arr = $data['with'];
        }

        // check translation
        $has_translation = false;
        $appends = $this->model->getAppends() ?? [];
        $translation_attributes = $this->model->translation_attributes ?? [];
        foreach ($appends as $append) {
            if(in_array($append, $translation_attributes)){
                $has_translation = true;
                break;
            }
        }

        if($has_translation){
            $width_arr[] = 'translation';
        }
        
        //unique
        $width_arr = array_unique($width_arr);

        foreach ($width_arr as $key => $with) {
            // Example: $data['with'] = ['products','members'];
            if(!is_array($with)){
                $query->with($with);
            }
        }

        return $query;
    }

    private function setWhereIn($query, $data)
    {
        if(!empty($data['whereIn'])){
            foreach ($data['whereIn'] as $column => $arr) {
                $query->whereIn($this->table . '.' . $column, $arr);
            }
        }

        return $query;
    }

    private function setWhereNotIn($query, $data)
    {
        if(!empty($data['whereNotIn'])){
            foreach ($data['whereNotIn'] as $column => $arr) {
                $query->whereNotIn($this->table . '.' . $column, $arr);
            }
        }

        return $query;
    }

    /**
     * If $order_product: 
     * $data['whereHas] = ['product' => ['name' => 'something']];
     */
    private function setWhereHas($query, $data)
    {
        if(empty($data['whereHas'])){
            return $query;
        }

        foreach ($data['whereHas'] as $relation_name => $relation) {
            $query->whereHas($relation_name, function($query) use ($relation) {
                foreach ($relation as $column => $value) {
                    $query->where($column, 'like', "%{$value}%");
                }
            });
        }
    }

    private function setWhereDoesntHave($query, $data)
    {
        if(empty($data['whereDoesntHave'])){
            return $query;
        }

        foreach ($data['whereDoesntHave'] as $relation_name => $relation) {
            $query->whereDoesntHave($relation_name, function($query) use ($relation) {
                foreach ($relation as $column => $value) {
                    $query->where($column, 'like', "%{$value}%");
                }
            });
        }
    }

    private function setAndSubOrWhereQuery($query, $set)
    {
        $query->where(function ($query) use($set) {
            foreach ($set as $key => $value) {
                $query = $this->setWhereQuery($query, $key, $value,'orWhere');
            }
        });
    }

    private function setEqualsQuery($query, $data)
    {
        $table_columns = $this->getTableColumns();
        $translation_attributes = $this->model->translation_attributes ?? [];

        $meta_keys = $this->model->meta_keys;
        if(empty($meta_keys)){
            $meta_keys = [];
        }

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

            // meta_keys is not processed here
            if(in_array($column, $meta_keys)){
                continue;
            }

            // Has to be the table's columns
            if(!in_array($column, $table_columns)){
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

        // set translated whereHas
        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'equal_')){
                continue;
            }else{
                $column = str_replace('equal_', '', $key);
            }

            if(in_array($column, $translation_attributes)){
                $query->whereHas('translation', function ($query) use ($column, $value) {
                    $query->where('meta_key', $column);
                    $query->where('meta_value', $value);
                });
                unset($data[$key]);
            }
        }

        // set meta whereHas
        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'equal_') || $value == '*'){
                continue;
            }else{
                $column = str_replace('equal_', '', $key);
            }

            if(in_array($column, $meta_keys)){
                $query->whereHas('metas', function ($query) use ($column, $value) {
                    $query->where('meta_key', $column);
                    $query->where('meta_value', $value);
                });
                unset($data[$key]);
            }
        }

        return $query;
    }

    private function setFiltersQuery($query, $data, $debug=0)
    {
        $translation_attributes = $this->model->translation_attributes ?? [];
        $table_columns = $this->getTableColumns();
        
        $meta_keys = $this->model->meta_keys;
        if(empty($meta_keys)){
            $meta_keys = [];
        }

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

            // Translated column is not processed here
            if(in_array($column, $translation_attributes)){
                continue;
            }

            // meta_keys is not processed here
            if(in_array($column, $meta_keys)){
                continue;
            }

            // Has to be the table's columns
            if(!in_array($column, $table_columns)){
                continue;
            }

            if(is_array($value)){ // Filter value can not be array
                continue;
            }

            if(isset($data['regexp']) && $data['regexp'] == false){
                $value = "=$value";
            }else{
                $value = str_replace(' ', '*', trim($value));
            }

            $query = $this->setWhereQuery($query, $column, $value, 'where');
        }

        // Filters - data table - andSubOrWhere
        if(!empty($data['andOrWhere'])){
            foreach ($data['andOrWhere'] as $set) {
                $this->setAndSubOrWhereQuery($query, $set);
            }
        }

        // set translated whereHas
        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'filter_')){
                continue;
            }else{
                $column = str_replace('filter_', '', $key);
            }

            if(in_array($column, $translation_attributes) && !empty($data[$key])){
                $data['whereHas']['translation'][$key] = $data[$key];
                unset($data[$key]);
            }
        }

        // set meta whereHas
        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'filter_') || $value == '*'){
                continue;
            }else{
                $column = str_replace('filter_', '', $key);
            }

            if(in_array($column, $meta_keys)){
                $data['whereHas']['metas'] = ['meta_key' => $column, 'meta_value' => $value];
                unset($data[$key]);
            }
        }
        
        // Display sql statement
        if(!empty($debug)){
            $this->getDebugQueryContent($query);
        }
    }

    /**
     * 'foo woo'    where($column, 'REGEXP', 'foo(.*)woo')
     * 'foo*woo'    where($column, 'REGEXP', 'foo(.*)woo')
     * '=foo woo'   where($column, '=', 'foo woo')
     * 'foo woo*'   where($column, 'like', 'foo woo%')
     * '*foo woo'   where($column, 'like', '%foo woo')
     * '>123'       where column >123
     * '<123'       where column <123
     * '<>123'      where column <>123
     * $type = 'where' or 'orWhere'
     */
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

            if($this->zh_hant_hans_transform === true){
                $query->$type(function ($query) use($column, $value) {
                    //先用原本字串查一次
                    $query->orWhere($column, 'REGEXP', $value);

                    $zhtw = ChineseCharacterHelper::zhChsToCht($value);
                    if(!empty($zhtw)){
                        $query->orWhere($column, 'REGEXP', $zhtw);
                    }
                    
                    $zhcn = ChineseCharacterHelper::zhChtToChs($value);
                    if(!empty($zhcn)){
                        $query->orWhere($column, 'REGEXP', $zhcn);
                    }
                });
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
            if($this->zh_hant_hans_transform === true){
                $query->$type(function ($query) use($column, $value) {
                    //先用原本字串查一次
                    $query->orWhere($column, '=', $value);

                    $zhtw = ChineseCharacterHelper::zhChsToCht($value);
                    if(!empty($zhtw)){
                        $query->orWhere($column, '=', $zhtw);
                    }
                    
                    $zhcn = ChineseCharacterHelper::zhChtToChs($value);
                    if(!empty($zhcn)){
                        $query->orWhere($column, '=', $zhcn);
                    }
                });
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
            if($this->zh_hant_hans_transform === true){
                $query->$type(function ($query) use($column, $value) {
                    //先用原本字串查一次
                    $query->orWhere($column, '<>', $value);

                    $zhtw = ChineseCharacterHelper::zhChsToCht($value);
                    if(!empty($zhtw)){
                        $query->orWhere($column, '<>', $zhtw);
                    }
                    
                    $zhcn = ChineseCharacterHelper::zhChtToChs($value);
                    if(!empty($zhcn)){
                        $query->orWhere($column, '<>', $zhcn);
                    }
                });
            }else{
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, '<>', $value);
                });
            }
        }
        // '<123' Smaller than 123
        else if(str_starts_with($value, '<') && strlen($value) > 1){
            $value = substr($value,1); // '123'
            $query->$type($column, '<', $value);
        }
        // '>123' bigger than 123
        else if(str_starts_with($value, '>') && strlen($value) > 1){
            $value = substr($value,1);
            $query->$type($column, '>', $value);
        }
        // '*foo woo'
        else if(substr($value,0, 1) == '*' && substr($value,-1) != '*'){
            $value = str_replace(' ', '(.*)', $value);
            $value = "(.*)".substr($value,1).'$';
            if($this->zh_hant_hans_transform === true){
                $query->$type(function ($query) use($column, $value) {
                    //先用原本字串查一次
                    $query->orWhere($column, 'REGEXP', "$value");

                    $zhtw = ChineseCharacterHelper::zhChsToCht($value);
                    if(!empty($zhtw)){
                        $query->orWhere($column, 'REGEXP', "$zhtw");
                    }
                    
                    $zhcn = ChineseCharacterHelper::zhChtToChs($value);
                    if(!empty($zhcn)){
                        $query->orWhere($column, 'REGEXP', "$zhcn");
                    }
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

            if($this->zh_hant_hans_transform === true){
                $query->$type(function ($query) use($column, $value) {
                    //先用原本字串查一次
                    $query->orWhere($column, 'REGEXP', "$value");

                    $zhtw = ChineseCharacterHelper::zhChsToCht($value);
                    if(!empty($zhtw)){
                        $query->orWhere($column, 'REGEXP', "$zhtw");
                    }
                    
                    $zhcn = ChineseCharacterHelper::zhChtToChs($value);
                    if(!empty($zhcn)){
                        $query->orWhere($column, 'REGEXP', "$zhcn");
                    }
                });
            }else{
                $query->$type(function ($query) use($column, $value) {
                    $query->orWhere($column, 'REGEXP', "$value");
                });
            }
        }

        return $query;
    }

    private function setWhereRawSqls($query, $data)
    {
        if(empty($data['whereRawSqls'])){
            return $query;
        }

        if(is_string($data['whereRawSqls'])){
            $data['whereRawSqls'][] = $data['whereRawSqls'];
        }

        foreach($data['whereRawSqls'] as $rawsql){
            $query->whereRaw('(' . $rawsql . ')');
        }

        return $query;
    }

    private function setDistinct($query, $data)
    {
        if(!empty($data['distinct'])){
            $query->distinct();
        }

        return $query;
    }

    private function setSortOrder($query, $data)
    {
        //  - Order (default DESC)
        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $order = 'ASC';
        }
        else{
            $order = 'DESC';
        }

        //  - Sort
        //  -- 指定排序字串
        if(!empty($data['orderByRaw'])){
            $query->orderByRaw($data['orderByRaw']);
        }
        // -- 指定排序欄位
        else if(!empty($data['sort'])){
            // 非多語欄位
            if(!in_array($data['sort'], $this->translation_attributes)){
                $query->orderBy($data['sort'], $order);
            }
            // 多語欄位
            else{
                $translation_table = $this->model->getTranslationTable();
                $master_key = $this->model->getTranslationMasterKey();
                $sort = $data['sort'];
    
                if (str_ends_with($this->model->translation_model_name, 'Meta')) {
    
                    $query->join($translation_table, function ($join) use ($translation_table, $master_key, $sort){
                        $join->on("{$this->table}.id", '=', "{$translation_table}.{$master_key}")
                             ->where("{$translation_table}.locale", '=', $this->locale)
                             ->where("{$translation_table}.meta_key", '=', $sort);
                    });
                    $query->orderBy("{$translation_table}.meta_value", $order);
    
                }else{ // 一般用 Translation 做結尾，例如 ProductTranslation
                    $query->join($translation_table, function ($join) use ($translation_table, $master_key, $sort){
                        $join->on("{$this->table}.id", '=', "{$translation_table}.{$master_key}")
                             ->where("{$translation_table}.locale", '=', app()->getLocale());
                    });
                    $query->orderBy("{$translation_table}.{$sort}", $order);
                }
            }

        }

        // 未指定排序欄位，但資料表欄位有 sort_order
        else if(empty($data['sort']) && in_array('sort_order', $this->getTableColumns())){
            $query->orderBy('sort_order', 'ASC');
        }
        //  -- 其它情況
        else{
            if(empty($data['sort']) || $data['sort'] == 'id'){
                $sort = $this->model->getTable() . '.id';
            }
            else{
                $sort = $data['sort'];
            }
            $query->orderBy($sort, $order);
        }
    }

    /**
     * $data['select] = ['col1', 'col2'];
     * $data['select] = 'col1, col2';
     */
    private function setSelect($query, $data)
    {
        if(!empty($data['select'])){
            if(is_array($data['select'])){
                $query->select($data['select']);
            }else if($data['select'] !== '*'){ 
                $query->select(DB::raw($data['select']));
            }
        }

        return $query;
    }

    private function showDebugQuery(Builder $builder, $debug = 0, $params = [])
    {
        if($debug == 0 ){
            return true;
        }

        $sqlstr = str_replace('?', "'?'", $builder->toSql());

        $bindings = $builder->getBindings();

        if(!empty($bindings)){
            $arr['statement'] = vsprintf(str_replace('?', '%s', $sqlstr), $builder->getBindings());
        }else{
            $arr['statement'] = $builder->toSql();
        }

        $arr['original'] = [
            'toSql' => $builder->toSql(),
            'bidings' => $builder->getBindings(),
        ];

        echo "<pre>".print_r($arr , 1)."</pre>"; exit;
    }


    public function getResult($query, $data)
    {
        $result = [];

        if(isset($data['first']) && $data['first'] = true){
            if(empty($data['pluck'])){
                $result = $query->first();
            }else{
                $result = $query->pluck($data['pluck'])->first();
            }
        }else{
            // Limit
            if(isset($data['limit'])){
                $limit = (int)$data['limit'];
            }else{
                $limit = config('settings.config_admin_pagination_limit');

                if(empty($limit)){
                    $limit = 10;
                }
            }

            // Pagination
            if(isset($data['pagination']) ){
                $pagination = (boolean)$data['pagination'];
            }else{
                $pagination = true;
            }
            
            if($pagination == true && $limit != 0){  // Get some rows per page
                if(empty($data['pluck'])){
                    $result = $query->paginate($limit);
                }else{
                    $result = $query->paginate($limit)->pluck($data['pluck']);
                }
            }
            else if($pagination == false && $limit != 0){ // Get some rows without pagination
                if(empty($data['pluck'])){
                    $result = $query->limit($limit)->get();
                }else{
                    $result = $query->limit($limit)->pluck($data['pluck']);
                }
            }
            else if($limit == 0){
                if(empty($data['pluck'])){
                    $result = $query->get(); // Get all
                }else{
                    $result = $query->pluck($data['pluck']);
                }
            }

            if(!empty($data['keyBy'])){
                $result = $result->keyBy($data['keyBy']);
            }
        }

        return $result;
    }


    public function getTableColumns($connection = null)
    {
        // table_columns already exist
        if(!empty($this->table_columns) && is_array($this->table_columns)){
            return $this->table_columns;
        }

        // get from cache
        if(empty($this->table)){
            $this->table = $this->model->getTable();
        }

        $cache_name = 'cache/json/table_columns/' . $this->table . '.json';

        $this->table_columns = DataHelper::getJsonFromStorage($cache_name);

        if(!empty($this->table_columns)){
            return $this->table_columns;
        }
        
        // get from database
        if(!empty($connection)){
            $this->table_columns = DB::connection($connection)->getSchemaBuilder()->getColumnListing($this->table);
        }else if(!empty($this->model->connection) ){
            $this->table_columns = DB::connection($this->model->connection)->getSchemaBuilder()->getColumnListing($this->table);
        }else{
            $this->table_columns = DB::getSchemaBuilder()->getColumnListing($this->table);
        }
        
        DataHelper::saveJsonToStorage($cache_name, $this->table_columns);
        sleep(1);

        return DataHelper::getJsonFromStorage($cache_name);
    }

    /**
     * 獲取 meta_data，並根據 meta_keys ，若 meta_key 不存在，設為空值 ''
     */
    public function setMetasToRow($row)
    {
        foreach ($row->metas ?? [] as $meta) {
            foreach($this->model->meta_keys ?? [] as $meta_key){
                $row->{$meta_key} = $meta->meta_value ?? '';
            }
        }
        
        return $row;
    }

    public function setTranslationMetasToRow($row)
    {
        $translation = $row->translation;

        foreach ($translation as $meta) {
            $row->{$meta->meta_key} = $meta->meta_value;
            unset($row->translation);
        }

        return $row;
    }


    /**
     * 儲存：用表單欄位，比對資料庫欄位，而且資料有不同。
     * 
     * last modified: 2024-01-23
     */
    public function saveRow($id, $data)
    {
        try{
            DB::beginTransaction();
            
            $result = $this->findIdOrFailOrNew(id:$id);
    
            if(empty($result['error'])){
                $row = $result['data'];
            }else{
                return $result;
            }
    
            $table_columns = $this->getTableColumns();
    
            foreach($data as $column => $value){
                if(in_array($column, $table_columns)){
                    $row->{$column} = $value;
                }
            }
    
            if($row->isDirty()){
                $row->save();
            }

            DB::commit();

            return $row;

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
        
    }


    /**
     * 比對表單欄位是否存在資料表欄位
     * 
     * last modified: 2024-01-23
     */
    public function setSaveDataByTableColumn($id, $data)
    {
        $result = [];

        $table_columns = $this->getTableColumns();

        foreach($data as $column => $value){
            if(in_array($column, $table_columns)){
                $result[$column] = $value;
            }
        }
        
        return $result;
    }

    /**
     * 儲存 Meta資料。不包含多語
     * 
     * last modified: 2024-01-23
     */
    public function saveMeta($modelInstance, $metas)
    {
        try{
            DB::beginTransaction(); 

            if(empty($modelInstance->meta_keys)){
                return false;
            }
    
            $update_data = [];
    
            $master_key = $modelInstance->getForeignKey();
    
            foreach($metas as $column => $value){
                if(in_array($column, $modelInstance->meta_keys ?? [])){
                    $update_data[] = [
                        $master_key => $modelInstance->id,
                        'locale' => '',
                        'meta_key' => $column,
                        'meta_value' => $value,
                    ];
                }
            }
            
            $result = '';

            if(!empty($update_data)){
                $modelInstance->meta_model_name::where($master_key, $modelInstance->id)->delete();
                $result = $modelInstance->meta_model_name::upsert($update_data, [$master_key,'locale','meta_key']);
            }
            
            DB::commit();

            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    
    
    }

    /**
     * 儲存 Meta 的多語資料
     * 
     * last modified: 2024-01-23
     */
    public function saveMetaTranslations($modelInstance, $translations)
    {
        if(empty($modelInstance->translation_attributes)){
            return false;
        }

        $update_date = [];
        $master_key = $modelInstance->getForeignKey();

        foreach($translations as $locale => $rows){
            foreach($rows as $column => $value){
                if(in_array($column, $modelInstance->translation_attributes ?? [])){
                    $update_date[] = [
                        $master_key => $modelInstance->id,
                        'locale' => $locale,
                        'meta_key' => $column,
                        'meta_value' => $value,
                    ];
                }
            }
        }

        if(!empty($update_date)){
            $result = $modelInstance->meta_model_name::upsert($update_date, [$master_key,'locale','meta_key']);
        }

        return $result;
    }

    /**
     * 根據主模型 id 及 meta_key 強制刪除 meta 資料。不處理多語。
     * 
     * last modified: 2024-01-23
     */
    public function forceDeleteMeta($masterModel, $meta_keys)
    {
        try{
            DB::beginTransaction(); 

            $master_key = $masterModel->getForeignKey();
    
            $builder = $masterModel->meta_model_name::query();
            $builder->where($master_key, $masterModel->id);

            //不處理多語。
            $builder->where(function ($query) {
                $query->whereNull('locale')
                      ->orWhere('locale', '=', '');
            });

    
            foreach($meta_keys as $meta_key){
                $builder->where('meta_key', $meta_key);
            }

            
            // $result = $builder->get();
            // echo "<pre>".print_r($result, true)."</pre>"; exit;
            $result = $builder->forceDelete();

            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return ['error' => $e->getMessage()];
        }
    }






    /**
     * filter_somecolumn 如果是 meta 表，則去 meta 表查詢。
     */
    private function setTranslationsQuery($query, $data, $flag = 1)
    {

        if(empty($this->model->translation_attributes)){
            return;
        }

        //判斷第一層 filter_column 是否存在
        $basic_translation_filter_data = [];

        foreach ($data as $key => $value) {
            if(!str_starts_with($key, 'filter_')){
                continue;
            }

            $column = str_replace('filter_', '', $key);

            $basic_translation_filter_data[$column] = $value;
        }

        //判斷進階查詢是否存在
        $advanced_translation_filter_data = [];

        if(!empty($data['translation'])){
            $advanced_translation_filter_data = $data['translation'];
        }

        //既無基本查詢，也無進階查詢
        if(empty($basic_translation_filter_data) && empty($advanced_translation_filter_data)){
            return;
        }

        //開始構建查詢
        $query->whereHas('metas', function($qry) use ($basic_translation_filter_data, $advanced_translation_filter_data) {
            $qry->where('locale', app()->getLocale());

            //基本查詢
            if(!empty($basic_translation_filter_data)){
                foreach($basic_translation_filter_data as $column => $value){
                    $qry->where('meta_key', $column);
                    $this->setWhereQuery($qry, 'meta_value', $value, 'where');
                }
            }

            //進階查詢
            if(!empty($advanced_translation_filter_data)){
                if(!empty($advanced_translation_filter_data['andOrWhere'])){
                    foreach($advanced_translation_filter_data['andOrWhere'] as $set){
                        $qry->where(function($qry) use ($set){
                            foreach($set as $column => $value){
                                $qry->orWhere(function($qry) use ($column, $value){
                                    $qry->where('meta_key', $column);
                                    $this->setWhereQuery($qry, 'meta_value', $value, 'where');
                                });
                            }
                        });
                    }
                }
            }

        });
        
        return $query;
    }

    // private function setAdvancedTranslationQuery($query, $data)
    // {
    //     if(empty($data['translation'])){
    //         return;
    //     }

    //     foreach($data['translation'] as $set){

    //     }


    // }
}