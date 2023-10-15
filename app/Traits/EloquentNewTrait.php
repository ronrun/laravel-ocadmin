<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait EloquentNewTrait
{
    public function findOrFailOrNew($id, $model)
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
                $this->setSubAndWhereQuery($query, $set);
            }
        }
        if(!empty($data['subOrWhere'])){
            foreach ($data['subOrWhere'] as $set) {
                self::setSubOrWhereQuery($query, $set);
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
            $translationModelName = get_class($this->model) . 'Translation';
        }

        if(empty($translationModelName) && !empty($this->model->translationModelName)){ // Customized
            $translationModelName = $this->model->translationModelName;
        }

        return new $translationModelName();
    }

    private function getTranslationMasterKey()
    {
        $translationModel = self::getTranslationModel();

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
        $translation_model = self::getTranslationModel();
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
    private function getMetaDatas($row)
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