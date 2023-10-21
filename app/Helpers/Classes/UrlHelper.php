<?php

namespace App\Helpers\Classes;

class UrlHelper
{
    private static $request;

    public static function getUrlQueries($queries)
    {
        $query_data = [];

        if(!empty($queries['sort'])){
            $query_data['sort'] = $queries['sort'];
        }else{
            $query_data['sort'] = 'id';
        }

        if(!empty($queries['order'])){
            $query_data['order'] = $queries['order'];
        }else{
            $query_data['order'] = 'DESC';
        }

        if(isset($queries['page'])){
            $query_data['page'] = $queries['page'];
        }

        if(isset($queries['limit'])){
            $query_data['limit'] = $queries['limit'];
        }else{
            $query_data['limit'] = 10;
        }

        // filter_
        foreach($queries as $key => $value){
            if(strpos($key, 'filter_') !== false){
                $query_data[$key] = $value;
            }
        }

        // equals_
        foreach($queries as $key => $value){
            if(strpos($key, 'equal_') !== false){
                $query_data[$key] = $value;
            }
        }

        // is_active
        if(!isset($queries['equal_is_active'])){
            $query_data['equal_is_active'] = 1;
        }else{
            $query_data['equal_is_active'] = $queries['equal_is_active'];
        }


        if(isset($queries['with'])){
            $multi_with = explode(',',$queries['with']);

            foreach ($multi_with as $chained_with) {
                $query_data['with'][] = $chained_with;
            }
        }

        if(!empty($queries['extra_columns'])){
            $query_data['extra_columns'] = $queries['extra_columns'];
        }

        if(!empty($queries['simplelist'])){
            $query_data['simplelist'] = $queries['simplelist'];
        }
        
        return $query_data;
    }
}