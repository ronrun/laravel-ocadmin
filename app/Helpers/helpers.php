<?php

//https://jamesqi.com/博客/一个独立可用的中文简体繁体转换PHP程序
if (! function_exists('ChtToChs')) {
	function ChtToChs($input){
		//$array = array_flip($array); //如果需要繁体到简体的转换，只需要用一个array_flip函数来对调key和value
		if(trim($input)==''){ //输入为空则返回空字符串
			return ''; 
		}

		$array = include_once(base_path() .'/app/Helpers/CharacterChtToChs.php');

		$output = ''; 
		$count = mb_strlen($input,'utf-8'); //按照utf-8字符计数
		for($i = 0; $i <= $count; $i++){ //逐个字符处理
			$jchar = mb_substr($input,$i,1,'utf-8'); //分离出一个需要处理的字符
			$fchar = isset($array[$jchar])?$array[$jchar]:$jchar; //如果在上面的对照数组中就转换，否则原样不变
			$output .= $fchar; //逐个字符添加到输出
		} 
		return $output;//返回输出
	}
}

if (! function_exists('ChsToCht')) {
	function ChsToCht($input){
		//$array = array_flip($array); //如果需要繁体到简体的转换，只需要用一个array_flip函数来对调key和value
		if(trim($input)==''){ //输入为空则返回空字符串
			return ''; 
		}

		$array = include_once(base_path() .'/app/Helpers/CharacterChsToCht.php');

		$output = ''; 
		$count = mb_strlen($input,'utf-8'); //按照utf-8字符计数
		for($i = 0; $i <= $count; $i++){ //逐个字符处理
			$jchar = mb_substr($input,$i,1,'utf-8'); //分离出一个需要处理的字符
			$fchar = isset($array[$jchar])?$array[$jchar]:$jchar; //如果在上面的对照数组中就转换，否则原样不变
			$output .= $fchar; //逐个字符添加到输出
		} 
		return $output;//返回输出
	}
}

// from 6 digit 220601 transform to 2022-06-01
//將6碼西元年月日，改成完整日期
if (! function_exists('parseDateYMD')) {
	function parseDateYMD($str){
		if(strlen($str)===6 && is_numeric($str)){
			$str = '20' . substr($str,0,2).'-'.substr($str,2,2).'-'.substr($str,4,2);
		}
		return $str;
	}
}

// Passord rules
if (! function_exists('chkPasswordRule')) {
	function chkPasswordRule($str){
		$rule = [
			'123456',
			'000000',
			'111111',
			'222222',
			'333333',
			'444444',
			'555555',
			'666666',
			'777777',
			'888888',
			'999999',
			'000111',
			'111222',
			'222333',
			'333444',
			'444555',
			'555666',
			'666777',
			'777888',
			'888999',
			'999000',
			'135246',
			'246135',
		];

		if(in_array($str, $rule)){
			return false;
		}

		return true;
	}
}
?>