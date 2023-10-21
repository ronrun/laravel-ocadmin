<?php

/**
 * 2023-10-15 昨日創建，現未使用。改回使用 Trait
 * 不使用的原因：很多時候要用到物件 $this->model 等等，用靜態不太方便。
 * 依然使用下列結構：
 *   ProductController > ProductService > ProductRepository
 *   並在其中使用 EloquentTrait
 *  
 */

namespace App\Helpers\Classes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentHelper
{

    /**
     * $data['model']
     * $data['filter_somecolumn']
     * $data['equal_somecolumn']
     * $data['pagination']
     * $data['limit']
     * $data['whereIn']
     * $data['whereHas']
     * 
     */
    
    private static $connection;
    private static $model;
    private static $table;
    private static $table_columns;
    private static $locale;
    private static $zh_hant_hans_transform = false;

    public static function newModel($model_name)
    {
        return new $model_name;
    }

    public static function findOrFailOrNew($id, $model)
    {
        //find
        if(!empty($id)){
            $row = $model->where('id', $id)->firstOrFail();
        }
        //new
        else{
            $row = $model;
        }

        return $row;
    }

    public static function getRows($data = [], $debug = 0): mixed
    {
        self::initialize($data['model']);
        $query = self::$model->query();

        // Equals
        $query = self::setEqualsQuery($query, $data);

        // Filters
        $query = self::setFiltersQuery($query, $data);


        // Sort & Order
        //  - Order
        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $order = 'ASC';
        }
        else{
            $order = 'DESC';
        }

        //  - Sort
        if(!empty(self::$model->translation_attributes) && in_array($data['sort'], self::$model->translation_attributes)){
            $translationTable = self::getTranslationTable();
            $master_key = self::getTranslationMasterKey();

            $query->join($translationTable, function ($join) use ($translationTable, $master_key, $order){
                $join->on("{$this->table}.id", '=', "{$translationTable}.{$master_key}")
                     ->where("{$translationTable}.locale", '=', $this->locale);
            });

            $query->orderBy("{$translationTable}.{$data['sort']}", $order);
        }else{
            if(empty($data['sort']) || $data['sort'] == 'id'){
                $sort = self::$model->getTable() . '.id';
            }
            else{
                $sort = $data['sort'];
            }
            $query->orderBy($sort, $order);
        }


        // see the sql statement
        if(!empty($debug)){
            self::getQueries($query);
        }


        // get result
        $result = [];

        // single row
        if(isset($data['first']) && $data['first'] = true){
            $result = $query->first();
            $result = self::getMetaDatas($result);
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
                    $row = self::getMetaDatas($row);
                }

            }
        }

        return $result;
    }

    public static function getRow($data, $debug=0)
    {
        $data['first'] = true;
        $row = self::getRows($data, $debug);
        return $row;
    }

    public static function resetTranslations($rows)
    {
        $rows->load('translations');

        foreach ($rows as $row) {
            $row = self::resetRowTranslation($row);
        }

        return $rows;
    }

    public static function resetRowTranslation($row)
    {
        $formattedTranslations = [];

        foreach ($row->translations as $translation) {
            $locale = $translation->locale;
            $column = $translation->meta_key;
            $value = $translation->meta_value;
            $formattedTranslations[$locale][] = [$column => $value];
        }

        // $row->setAttribute('translations', $arr); 
        // $row->translations = $formattedTranslations;
        $row->setRelation('translations', collect($formattedTranslations));

        return $row;
    }


    /**
     * 根據傳來的 $data ，批次儲存所有本表欄位
     */
    public static function save($row, $data)
    {
        $table_columns = $row->getFillable();

        if(empty($table_columns)){
            $table_columns = $row->getConnection()->getSchemaBuilder()->getColumnListing($row->getTable());
        }

        foreach ($data as $key => $value) {
            if(in_array($key, $table_columns)){
                $row->$key = $value;
            }
        }

        return $row->save();
    }

    public function saveTranslationData($masterRow, $data)
    {
        $translated_attributes = $masterRow->translated_attributes;
        echo '<pre>', print_r(888, 1), "</pre>"; exit;
        $translationModel = $this->getTranslationModel();

        // Keys
        $foreign_key = $translationModel->foreign_key ?? $masterRow->getForeignKey();
        $foreign_key_id = $masterRow->id;
        $table_keys = ['id', $foreign_key, 'locale'];

        foreach($data as $locale => $row){

            $arr[$foreign_key] = $foreign_key_id;
            $arr['locale'] = $locale;
            
            $row_data_keys = []; //用於檢查非鍵的欄位是否有資料

            //設定語言表全部欄位，若無值則給空值，確保每一個欄位都有值。這是為了讓欄位數量一致，才能做批次upsert()。
            foreach ($translated_attributes as $column) {
                if(!empty($row[$column])){
                    $arr[$column] = $row[$column];

                    if(!in_array($column, $table_keys)){
                        $row_data_keys[] =  $column; 
                    }
                }else{
                    $arr[$column] = '';
                }
            }

            //非鍵的部份有資料，才做更新
            if(!empty($row_data_keys)){
                $upsert[] = $arr;

                $newKeys[$foreign_key_id][$locale] = ''; //用於檢查主鍵的欄位是否存在
            }
        }
        
        // Find all where foreign_key_id exists
        $existed_translations = $translationModel->where($foreign_key, $foreign_key_id)->get();

        //Delete
        foreach ($existed_translations as $existed_translation) {
            $locale = $existed_translation->locale;
            if(!isset($newKeys[$foreign_key_id][$locale])){
                $delete_ids[] = $existed_translation->id;
            }
        }

        if(!empty($delete_ids)){
            $translationModel->where('id', $delete_ids)->delete();
        }

        $translationModel->upsert($upsert,[$foreign_key, 'locale']);
    }


    private static function initialize($model)
    {
        if(!empty($model->connection)){
            self::$connection = $model->connection;
        }else{
            self::$connection = DB::connection()->getName();
        }

        self::$model = $model;
        self::$table = $model->getTable();
        self::$table_columns = self::getTableColumns();
        self::$locale = app()->getLocale();
        self::$zh_hant_hans_transform = false;
    }

    private static function getTableColumns()
    {
        // $table_columns = $row->getFillable();

        // if(empty($table_columns)){
        //     $table_columns = $row->getConnection()->getSchemaBuilder()->getColumnListing($row->getTable());
        // }

        return self::$table_columns = DB::connection(self::$connection)->getSchemaBuilder()->getColumnListing(self::$table);
    }

    private static function setFiltersQuery($query, $data, $debug = 0)
    {
        $translation_attributes = self::$model->translation_attributes ?? [];
        $meta_attributes = self::$model->meta_attributes ?? [];

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
            if(!in_array($column, self::$table_columns)){
                continue;
            }

            if(is_array($value)){ // Filter value can not be array
                continue;
            }

            $value = str_replace(' ', '*', trim($value));

            $query = self::setWhereQuery($query, $column, $value, 'where');
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
                    'locale' => app()->getLocale(),
                    'meta_key' => '='.$column,
                    'meta_value' => $data[$key],
                ];
                unset($data[$key]);
            }
        }

        // whereHas
        if(!empty($data['whereHas'])){
            self::setWhereHas($query, $data['whereHas']);
        }

        // sub query
        if(!empty($data['subAndWhere'])){
            foreach ($data['subAndWhere'] as $set) {
                self::setSubAndWhereQuery($query, $set);
            }
        }
        if(!empty($data['subOrWhere'])){
            foreach ($data['subOrWhere'] as $set) {
                self::setSubOrWhereQuery($query, $set);
            }
        }

        return $query;
    }

    private static function setEqualsQuery($query, $data, $debug = 0)
    {
        $translation_attributes = self::$model->translation_attributes ?? [];
        $meta_attributes = self::$model->meta_attributes ?? [];

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
            if(!in_array($column, self::$table_columns)){
                continue;
            }

            $value_array = explode('__or__', $value);
            if(count($value_array) > 1){
                $column = self::$table . '.' . $column;
                $query->whereIn($column, $value_array);
            }else{
                $column = self::$table . '.' . $column;
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
                    'locale' => '='.self::$locale,
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

    private static function getTranslationModel()
    {
        if(empty($translation_model_name)){
            $translation_model_name = get_class(self::$model) . 'Translation';
        }

        if(empty($translation_model_name) && !empty(self::$model->translationModelName)){ // Customized
            $translation_model_name = self::$model->translationModelName;
        }

        return new $translation_model_name();
    }

    private static function getTranslationMasterKey()
    {
        $translationModel = self::getTranslationModel();

        if(!empty($translationModel->master_key)){
            return $translationModel->master_key;
        }else if(!empty(self::$model->translation_master_key)){
            return self::$model->translation_master_key;
        }else{
            return self::$model->getForeignKey();
        }
    }

    private static function getTranslationTable()
    {
        $translation_model = self::getTranslationModel();
        return $translation_model->getTable();      
    }

    private static function setWhereQuery($query, $column, $value, $type='where')
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
            if(self::$zh_hant_hans_transform === true){
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
            if(self::$zh_hant_hans_transform === true){
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
            if(self::$zh_hant_hans_transform === true){
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
            if(self::$zh_hant_hans_transform === true){
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

            if(self::$zh_hant_hans_transform === true){
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

    private static function setWhereHas($query, $data)
    {
        foreach ($data as $rel_name => $relation) {
            $query->whereHas($rel_name, function($query) use ($relation) {
                foreach ($relation as $set) {
                    self::setSubAndWhereQuery($query, $set);
                }
            }); 
        }
    }

    private static function setSubAndWhereQuery($query, $set)
    {
        $query->where(function ($query) use($set) {
            foreach ($set as $key => $value) {
                $query = self::setWhereQuery($query, $key, $value,'where');
            }
        });
    }

    private static function setSubOrWhereQuery($query, $set)
    {
        $query->where(function ($query) use($set) {
            foreach ($set as $key => $value) {
                $query = $this->setWhereQuery($query, $key, $value,'orWhere');
            }
        });
    }

    private static function getQueries(Builder $builder)
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
    private static function getMetaDatas($row)
    {
        $local = app()->getLocale();

        if(!empty($row->metas)){
            foreach ($row->metas as $meta) {
                if($meta->locale == $local){
                    $row->{$meta->meta_key} = $meta->meta_value;
                }else if($meta->locale == null){
                    $row->{$meta->meta_key} = $meta->meta_value;
                }
            }

            return $row;
        }

        return [];
    }
}