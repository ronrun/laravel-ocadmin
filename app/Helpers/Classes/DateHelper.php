<?php

namespace App\Helpers\Classes;

class DateHelper
{
    /**
     * 解析日期
     * 可以輸入兩碼西元年加上月日，例如230501, 23-5-1
     * 
     * @param string $dateString
     * @return string
     */
    public static function parse($dateString)
    {
        if(strlen($dateString) > 10){
            return ['error' => 'datestring too long!'];
        }
        
        //帶有橫線的日期
        if(preg_match('/(^\d{2,4}-\d{1,2}-\d{1,2}$)/', $dateString, $matches)){ //2023-05-01, 23-05-01
            $arr = explode('-', $dateString);
            $date_year = $arr[0] < 2000 ? $arr[0]+2000 : $arr[0];
            $dateString = $date_year . '-' . $arr[1] . '-' . $arr[2];
        }

        //連續數字
        else if(preg_match('/(^\d{6,8}$)/', $dateString, $matches)){ //230501, 20230501
            $date_year = substr($dateString, 0, -4);
            $date_year = $date_year < 2000 ? $date_year+2000 : $date_year;
            $dateString = $date_year . '-' . substr($dateString, -4, -2) . '-' . substr($dateString, -2);
        }

        $validDateString = date('Y-m-d', strtotime($dateString));

        if($validDateString == $dateString){
            return $dateString;
        }

        return false;
    }

    /**
     * 判斷兩個時間差異
     * 可以輸入兩碼西元年加上月日，例如230501, 23-5-1
     * 
     * @param string $startString
     * @param string $endString
     * @param string $type days, minutes, seconds
     * @return integer
     */
    public static function diff($startString, $endString, $type = 'days')
    {
        $date1 = new \DateTime($startString);
        $date2 = new \DateTime($endString);

        $interval = $date1->diff($date2);

        if($type =='days'){
            $diff = $interval->days;
        }

        switch ($type){
            case 'days':
                $diff = $interval->days;
                break;
            case 'minutes':
                $diff = $interval->format('%i');
                break;
            case 'seconds':
                $diff = $interval->format('%s');
                break;
            default:
                $diff = 'error!';
        }

        if ($date1 > $date2) {
            $diff *= -1;
        }

        return $diff;
    }

    /**
     * 將日期轉換成2碼西元年加上月日
     * 
     * @param string $input
     * @return string
     */
    public static function parseDateTo6d($input)
    {
        $dateYmd = self::parse($input); // yyyy-mm-dd

        if($dateYmd){
            preg_match_all('/\d+/', $input, $matches);
            $all_numbers = implode('', $matches[0]);
            $date2ymd = substr($all_numbers, -6);
        }
        
        if(!empty($date2ymd)){
            return $date2ymd;
        }
        
        return false;
    }
}