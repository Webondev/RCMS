<?php
/**
 * Методы ядра
 * **/
defined('ROOT_PATH') or die('No direct script access.');

class coreMethod {

    function __construct() {
    	
    	
    }
    
 	/**Получаем часть урла
	 * 
	 * не бывает 0 
	 * бывает 1 и более.
	 *  /qqqq/wwww
	 * 1 - это qqqq
	 * 2 - это wwww
	 * 
	 * $as_array - вернуть муть в ввиде массива
	 * **/
	public function path($num = 0, $as_array=false){
		$num = (int)$num;
		
		$path = $_SERVER['REQUEST_URI'];
		if(!$path) return false;
		
		if($_n = strpos($path,"?")){
			$path = substr($path, 0, $_n);
		}
		
		$path = str_replace('\\', "/", $path);
		
		$p_arr = explode("/",$path);
		
		if($as_array){
			return $p_arr;
		}
		
		if( $num && isset($p_arr[$num]) && !empty($p_arr[$num])){
			return $p_arr[$num];
		}
		return false;
	}
	
    public function redirect($url){
    	
    	header('Location: '.$url);
    	exit;
    }
}
