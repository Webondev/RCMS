<?php
require_once("coreMethod.class.php");

class app {

    function __construct() {
		
    }
    
    /**Ищем контроллеры и загружаем их если есть
     * 
     * $c_name - имя конроллера
     * $c_action - имя экшена
     * если задано оба, то запускаем заданное
     * 
     * **/
    public function getController($c_name=false, $c_action=false){

    	if($c_name && $c_action){ //если заданы контроллеры и экшен то это
    		$path[1] = $c_name;
    		$path[2] = $c_action;
    		
    	}else{
			$path = coreMethod::path(0, true);    	
	    	
	    	foreach($path as $k=>$v){
	    		$pattern = "![^0-9a-zA-Z\-\.]!is";
				
				if($v){ 
					$path[$k] = preg_replace($pattern, "", $v );
					$path[$k] = str_replace('.html', "", $v ); //делаем чтоб воспринимал .html
				}
	    	}
    	}
    	
    	if(empty($path[1])){ //если ничего нет то главная
			$path[1] = "index";
    	}
    	if(empty($path[2])) $path[2] = "index"; //если ничего нет главный экшн
    	if(empty($path[3])) $path[3] = "index"; //если ничего нет главный экшн
    	
    	
    	$s_file = C_PATH."/".$path[1].".php";
    	$m_file = M_C_PATH."/".$path[1].".php";
    	 
    	if(is_file($s_file) ){ //если контроллер есть то его и запустим
    	
    	 	return $this->loadController($s_file, $path[1], $path[2]);
    	 	
    	}elseif(is_file($m_file) ){ //если контроллер есть то его и запустим
    	 	
    	 	return $this->loadController($m_file, $path[1], $path[2]);
    	}
    	
    	/**работа с папками на первом уровне**/
    	
    	$s_dir = C_PATH."/".$path[1]."/";
    	if(is_dir($s_dir) && $path[2]){ //если папка и есть название конроллера то проверим наличие контроллера
    	
    	 	$s_file = $s_dir.$path[2].".php";
    	  	if(is_file($s_file)){
    	 
    			return $this->loadController($s_file, $path[2], $path[3]);
    		}
    	}    	
    	
    	$m_dir = M_C_PATH."/".$path[1]."/";
    	
    	if(is_dir($m_dir) && $path[2]){ //если папка и есть название конроллера то проверим наличие контроллера
    	
    	 	$m_file = $m_dir.$path[2].".php";
    	  	if(is_file($m_file)){
    	 
    			return $this->loadController($m_file, $path[2], $path[3]);
    		}else{
    			return false;
    		}
    	}
    	return false;
    }
   
    /**загрузка контроллера и экшена**/
	public function loadController($c_file, $c_name, $c_action=false){
		
			if(!$c_action) return false;	
			
			require_once($c_file);	
			
			$c_action = ucfirst($c_action);
			$c_action = "action".$c_action;
			
			$c_tmp = new $c_name;
			
			if(method_exists($c_tmp , $c_action)){
				$c_tmp->$c_action();
			}else{
				$c_tmp->actionIndex();
			}
			
			$c_tmp->after();
			
			return true;
	}
	
}
