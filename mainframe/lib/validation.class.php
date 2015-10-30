<?php
/*****
 * Класс валидации данных
 *  
 * */


class Input_Error_Exception extends Exception{};
class Empty_Error_Exception extends Exception{};

class validation{
	protected $db;
	
    function __construct($db) {
    	
    	$this->db = $db;
    	
    }
    
    /**Подготовка массива, вернуть только нужные элементы***/
    public function prepare_array($data, $require){
    	$res = array();
    	foreach($require as $k=>$v){
    		if(!empty($data[$v])){
    			$res[$v] = $data[$v];
    		}else{
    			$res[$v]="";
    		}
    	}
    	
    	return $res;
    }   
    
     /***Нужно проверять наличие нужных элементов в массиве в принципе
      * 
      * $data - проверяемый массив
      * $require - массив обязательных элементов
      * 
      * */
    public function is_empty($data, $require){
    	$res = array();
    	foreach($require as $k=>$v){
    		if(!empty($data[$v])){
    			$res[$v] = $data[$v];
    		}else{
    			throw new Empty_Error_Exception("empty_field_".$v);
    		}
    	}
    	
    	return $res;
    }
    
    /**
     * Валидация пароля
     * **/
    public function pass($pass, $pass2, $min = 6, $max = 50){

    		if(empty($pass) or empty($pass2)) throw new Empty_Error_Exception("empty_password_field");
    		
    		if(!preg_match("/^.{".$min.",".$max."}$/is",$pass)) throw new Input_Error_Exception("password_min_max");
			
			if($pass !== $pass2) throw new Input_Error_Exception("error_in_repeating_password");
			
			return $pass;
    }
    /**
     * Валидация email
     * **/
    public function email($email){
    	
    	if(empty($email)) throw new Empty_Error_Exception("empty_email_field");
    	
    	if(!preg_match("|^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is", $email)) throw new Input_Error_Exception("wrong_email");
    	
    	return $email;
    	
    }
    /**
     * ВАлидация логина и ему подобных полей
     * разрешены только латинские буквы и цифры
     * 0-9A-Za-z
     * ***/
    public function login($login, $field = "login", $min = 2, $max = 50){
    	
		if(empty($login)) throw new Empty_Error_Exception("empty_".$field."_field");

    	if(!preg_match("/^[0-9A-Za-z]{".$min.",".$max."}$/is", $login)) throw new Input_Error_Exception($field."_min_max");
    		
    	return $login;
    }
}
