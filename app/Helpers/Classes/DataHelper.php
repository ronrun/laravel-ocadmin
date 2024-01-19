<?php

namespace App\Helpers\Classes;

use Illuminate\Support\Facades\Storage;

class DataHelper
{

    /**
     * 陣列裡的子元素如果是陣列，刪除。
     * 
     * @author Elon Lee
     * @since 2024-01-17
     * @param array $data
     * @return array
     * @last-modified-by Elon Lee
     */
    public static function unsetArray($data = [])
    {
        foreach ($data as $key => $value) {
            if(is_array($value)){
                unset($data[$key]);
            }
        }
        
        return $data;
    }

    /**
     * 對於資料集，刪除每一筆記錄裡面的陣列。
     * 
     * @author Elon Lee
     * @since 2024-01-17
     * @param array $rows
     * @return array
     * @last-modified-by Elon Lee
     */
    public static function unsetArrayFromRows($rows = [])
    {
        foreach ($rows as $key => $row) {
            $result[$key] = self::unsetArray($row);
        }
        
        return $result;
    }

    /**
     * 將變數新增到指定的陣列
     * 目標變數可以是字串或陣列。如果是字串，則將該變數變成陣列，然後再加上本次要新增的變數。
     * 
     * @author Elon Lee
     * @since 2024-01-17
     * @param array $src
     * @param array $dst
     * @return array
     * @last-modified-by Elon Lee
     */
    public static function addToArray($src, $dst = null)
    {
        $dst = [];

        // $dst is empty
        if(empty($dst)){
            if(is_string($src)){
                $dst[] = $src;
            }else if(is_array($src)){
                $dst = $src;
            }
        }
        // $dst not empty
        else{
            if(is_string($dst)){
                $dst = [$dst];
            }
            $dst = $dst;

            if(is_string($src)){
                $dst[] = $src;
            }else if(is_array($src)){
                foreach ($src as $value) {
                    $dst[] = $value;
                }
            }
        }

        return array_unique($dst);
    }


    public static function saveJsonToStorage($json_path, $data)
    {
        if (Storage::exists($json_path)) {
            Storage::delete($json_path);
        }

        Storage::put($json_path, json_encode($data));

        return true;
    }

    public static function getJsonFromStorage($json_path, $toArray = false)
    {
        if (Storage::exists($json_path)) {
            $result = json_decode(Storage::get($json_path));

            return $result;
        }

        return null;
    }


}