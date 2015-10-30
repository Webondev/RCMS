<?php

class error {

    function __construct() {
    }
    
    /***Метод информирования об ошибке**/
    public function toInform($text){
    	
    	$text= date("d-m-Y H:i")."  ------------------------------ START --\r\n".$text;
    	$text = $text."\r\n".date("d-m-Y H:i")."  ------------------------------ END --\r\n";
    	
    	$this->save($text);
    	
    	if(ADMIN_EMAIL){
    		$this->toMail($text);
    	}
    }
    
    public function save($text){
    	$file = TMP_PATH."errors-log.txt";
    	$f = fopen($file, "a+");
    	if($f){
    		fwrite($f, $text);
    	}else{
    		echo "ERROR_WRITE_LOG_FILE";
    		die();
    	}
    	
    	fclose($f);
    }
    
    public function toMail($text){
    	
    	
    }
}
