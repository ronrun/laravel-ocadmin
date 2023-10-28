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
    private $filter_data;
    private $equal_data;

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
        $this->translation_attributes = $this->model->translation_attributes ?? [];
        $this->meta_attributes = $this->model->meta_attributes ?? [];

        // $this->filter_data, $this->equal_data
        $this->resetFilterAndEqualData($data);
    }

    private function resetFilterAndEqualData($data)
    {
        foreach ($data as $key => $value) {
            if(empty($value)){
                continue;
            }

            // Must Start with filter_
            if(str_starts_with($key, 'filter_') && !empty($value)){
                $column = str_replace('filter_', '', $key);
                $this->filter_data[$column] = $value;
            }
            else if(str_starts_with($key, 'equal_') && !empty($value)){
                $column = str_replace('equal_', '', $key);
                $this->equal_data[$column] = $value;
                unset($data[$key]);
            }
        }

        if(empty($this->filter_data)){
            $this->filter_data = [];
        }

        if(empty($this->equal_data)){
            $this->equal_data = [];
        }
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

        $this->setTranslationToRow($row);

        return $row;
    }

    public function getRow($data, $debug=0)
    {
        $data['first'] = true;
        $row = $this->getRows($data, $debug);
        return $row;
    }

    public function getRows($data = [], $debug = 0): mixed
    {
        $this->initialize($data);

        $query = $this->model->query();

        // is_active can only be: 1, 0, -1, *
        if(in_array('is_active', $this->table_columns)){
            
            // - 將 filter_is_active 轉成 equal_is_active (相容以前的舊寫法)
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
                }else if($equal_is_active == 1){
                    $query->where('is_active', 1);
                }

                unset($data['equal_is_active']);
            }
        }

        // columns
        $query = $this->setColumnsQuery($query, $data);

        // translations
        $query = $this->setTranslationsQuery($query, $data);

        // Sub query
        $query = $this->setSubQuery($query, $data);

        // where has
        $query = $this->setWhereHasQuery($query, $data);

        // with
        if(!empty($data['with'])){
            $this->setWith($query, $data['with']);
        }

        // Sort & Order
        //  - Order
        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $order = 'ASC';
        }
        else{
            $order = 'DESC';
        }

        //  - Sort
        if(!empty($data['sort']) && !empty($this->model->translation_attributes) && in_array($data['sort'], $this->model->translation_attributes)){
            $translation_table = $this->model->getTranslationTable();
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
            return $query->first();
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
            $rows->load('translation');
            
            foreach ($rows as $row) {
                $this->setTranslationToRow($row);
            }

            return $rows;
        }
    }


    /**
     * modified: 2023-10-29
     */
    private function setColumnsQuery($query, $data)
    {
        $translation_attributes = $this->model->translation_attributes ?? [];
        $meta_attributes = $this->model->meta_attributes ?? [];

        foreach ($data as $key => $value) {
            // $key has prifix 'filter_' or 'equal_'
            // $column is the name of database table's column

            $column = null;

            if($value == ''|| is_array($value)){
                continue;
            }

            if(str_starts_with($key, 'filter_')){
                $column = str_replace('filter_', '', $key);

                // translation or meta column is not processed here, Has to be the table's columns
                if(in_array($column, $translation_attributes) || in_array($column, $meta_attributes) || !in_array($column, $this->table_columns)){
                    continue;
                }

                $query = $this->setFilterWhereQuery($query, $column, $value, 'where');

            }else if(str_starts_with($key, 'equal')){
                $column = str_replace('equal', '', $key);

                // translation or meta column is not processed here, Has to be the table's columns
                if(in_array($column, $translation_attributes) || in_array($column, $meta_attributes) || !in_array($column, $this->table_columns)){
                    continue;
                }

                $query->where($query, $value);

            }
        }

        return $query;
    }

    private function setTranslationsQuery($query, $data, $flag = 1)
    {
        $standard_translation = [];
        $meta_translation = [];

        foreach ($data as $key => $value) {
            $column = null;
            if(str_starts_with($key, 'filter_')){
                $column = str_replace('filter_', '', $key);
            }else{
                continue;
            }

            //FooTranslation
            if(in_array($column, $this->translation_attributes) && !in_array($column, $this->meta_attributes)){
                $standard_translation[$column] = $value;
            }

            // meta translation
            if(in_array($column, $this->translation_attributes) && in_array($column, $this->meta_attributes)){
                $meta_translation[$column] = $value;
            }
        }

        if(!empty($standard_translation)){
            $this->filterStandardTranslations($query, $standard_translation);
        }

        if(!empty($meta_translation)){
            $this->filterMetaTranslations($query, $meta_translation);
        }

        return $query;
    }

    // setTranslationsQuery, use setWhereHas()
    private function filterStandardTranslations($query, $standard_whereHas)
    {
        $this->setWhereHas($query, $standard_whereHas);
    }

    private function filterMetaTranslations($query, $meta_data)
    {
        foreach ($meta_data as $column => $value) {
            $query->whereHas('metas', function($qry) use ($column, $value) {
                $qry->where('locale', app()->getLocale());
                $qry->where('meta_key', $column);
                $this->setFilterWhereQuery($qry, 'meta_value', $value, 'where');
            });
        }
    }

    /**
     * $data 是從 repository 傳來的完整 $data
     */
    private function setSubQuery($query, $data, $flag = 1)
    {
        if(!empty($data['andWhere'])){
            $sub_data = $data['andWhere'];
            $type = 'where';
        }
        else if(!empty($data['orWhere'])){
            $sub_data = $data['orWhere'];
            $type = 'orWhere';
        }
        else{
            return $query;
        }
        
        foreach ($sub_data as $set) {
            $query->$type(function ($query) use ($set, $flag) {

                // 處理本輪篩選欄位
                $this->setColumnsQuery($query, $set, $set['sub_type']);
                // 多語欄位
                $query = $this->setTranslationsQuery($query, $set, $flag);
                
                // 如果還有下一級
                if(!empty($set['andWhere'])){
                    $this->setSubQuery($query, $set);
                }
    
                if(!empty($set['orWhere'])){
                    $this->setSubQuery($query, $set, $flag);
                }
            });
        }

        return $query;
    }

    // 暫時沒用到
    private function setWhereHasQuery($query, $data)
    {
        if(empty($data['whereHas'])){
            return $query;
        }

        return $query;
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
            unset($row->translation);
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
                    unset($modelInstance->name);
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
            $meta_model = $this->model->getMetaModel();
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

    private function equalTranslations($query, $data)
    {}

    private function getTranslationMasterKey()
    {
        $translationModel = $this->model->getTranslationModel();

        if(!empty($translationModel->master_key)){
            return $translationModel->master_key;
        }else if(!empty($this->model->translation_master_key)){
            return $this->model->translation_master_key;
        }else{
            return $this->model->getForeignKey();
        }
    }

    private function setFilterWhereQuery($query, $column, $value, $type = 'where')
    {
        if(str_starts_with($column, 'filter_')){
            $column = str_replace('filter_', '', $column);
        }

        if(is_string($value)){
            $value = trim($value);
        }

        if(is_array($value)){
            return false;
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
                $query->$type($column, 'REGEXP', $value);
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
                $query->$type($column, '=', $value);
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
                $query->$type($column, '<>', $value);
            }
        }
        // '<123' Smaller than 123
        else if(str_starts_with($value, '<') && strlen($value) > 1){
            $value = (int)substr($value,1);
            $query->$type($column, '<', $value);

            // if($type == 'where'){
            //     $query->whereRaw("$column < $value");
            // }
            // if($type == 'orWhere'){
            //     $query->orWhereRaw("$column < $value");
            // }
        }
        // '>123' bigger than 123
        else if(str_starts_with($value, '>') && strlen($value) > 1){
            $value = (int)substr($value,1);
            $query->$type($column, '>', $value);
            // if($type == 'where'){
            //     $query->whereRaw("$column > $value");
            // }
            // if($type == 'orWhere'){
            //     $query->orWhereRaw("$column > $value");
            // }
        }
        // '*foo woo'
        else if(substr($value,0, 1) == '*' && substr($value,-1) != '*'){
            $value = "(.*)".substr($value,1).'$';
            if($this->is_mapping_zh_hant_hans === true){
                // $query->$type(function ($query) use($column, $zhtw, $zhcn) {
                //     $query->orWhere($column, 'REGEXP', "$zhtw");
                //     $query->orWhere($column, 'REGEXP', "$zhcn");
                // });

            }else{
                $query->$type($column, 'REGEXP', $value);
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
            }else{
                $query->$type($column, 'REGEXP', $value);
            }
        }

        return $query;
    }

    /**
     * $data['whereHas']['translation'][$key] = $data[$key];
     */
    private function setWhereHas($query, $data)
    {
        foreach ($data as $rel_name => $relation) {
            $query->whereHas($rel_name, function($query) use ($relation) {
                foreach ($relation as $key => $value) {
                    $this->setFilterWhereQuery($query, $key, $value, 'where');
                }
            });
        }
    }

    private function setWith($query, $funcData)
    {
        // $data['with'] = 'translation'
        if(!is_array($funcData)){
            $query->with($funcData);
        }else{
            foreach ($funcData as $key => $filters) {

                // Example: $data['with'] = ['products','members'];
                if(!is_array($filters)){
                    $query->with($funcData);
                }

                /* Example:
                $data['with'] = [
                    'products' => ['slug' => 'someCategory', 'is_active' => 1],
                    'orders' => ['amount' => '>1000']
                ];
                */
                else{
                    // 注意：with 裡面使用Closure函數，只是過濾 with 表，然後附加過來。不會過濾主表
                    $query->with([$key => function($query) use ($key, $filters) {
                        foreach ($filters as $column => $value) {
                            //$query = $this->setFilterWhereQuery($query, $column, $value, 'where');
                            $query->where("$key.$column", '=', $value);
                        }
                    }]);
                }
            }
        }
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
    public function getMetas($row)
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