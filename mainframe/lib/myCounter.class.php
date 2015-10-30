<?php

class myCounter {
	private $db;
	private $hitArr;
	
    function __construct($db) {
    	
    	$this->db = $db;
    	
    	$this->hitArr['date'] = date("Y-m-d");
    }
    
    public function saveVisit(){
	    //print_r($_SERVER);
	    
    	$this->hitArr['date'] = date("Y-m-d");
    	$this->hitArr['hit'] = "0"; //уникальное посещение
    	
		$this->saveUser();    	
    	$this->saveUrl();
    	$this->saveRef();
    	
    }
    
    private function saveUser(){
    	
    	//$this->hitArr['ip'] = empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR'];
		//$this->hitArr['ip'] = sprintf("%u", ip2long($this->hitArr['ip']));
		
		$this->hitArr['ip'] = "";
    	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    		$this->hitArr['ip'] = $_SERVER['REMOTE_ADDR'];
    	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    		$this->hitArr['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];  		
    	}  
    	if(!empty($_arr['ip'])){
			$this->hitArr['ip'] = sprintf("%u", ip2long($this->hitArr['ip']));
    	}
		
		
    	/**Браузер**/
    	if(!empty($_SERVER['HTTP_USER_AGENT'])){
			$this->hitArr['http_user_agent'] = htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
		}else{
			$this->hitArr['http_user_agent'] = "";
		}

		/**пока уникальность юзера будет основываться на уникальности ip и данных сессии**/
		if(empty($_SESSION['visit_id'])){
			$this->hitArr['visit_id'] = $this->db->selectRow("SELECT * FROM ?# WHERE date = ? AND ip = ?", 
						DB_PFX."st_visiters", $this->hitArr['date'], $this->hitArr['ip']);
			
			if(!$this->hitArr['visit_id']){
				
				$arr['date']= $this->hitArr['date'];
				$arr['ip'] = $this->hitArr['ip'];
				$arr['http_user_agent'] = $this->hitArr['http_user_agent'];
				
				$arr['is_bot'] = $this->is_bot($arr['http_user_agent']);
					
				$this->hitArr['visit_id'] = $this->db->query("INSERT IGNORE INTO ".DB_PFX."st_visiters SET ?a ".
											" ON DUPLICATE KEY UPDATE ?a", $arr, $arr);
											
				$_SESSION['visit_id'] = $this->hitArr['visit_id'];	
				$this->hitArr['hit'] = "1"; //отчечаем уникальное посещение				
			}
		}else{
			$this->hitArr['visit_id'] = $_SESSION['visit_id'];
		}
    	
    }
    
    private function saveUrl(){

    	$arr['url']="";
    	/**запрошенная страница*/
    	if(!empty($_SERVER['REQUEST_URI'])){ 
    		$arr['url'] = $_SERVER['REQUEST_URI'];
    		
       	}elseif(!empty($_SERVER['PATH_INFO'])){
    		$arr['url'] = $_SERVER['PATH_INFO'];
    	}
    	
    	$arr['url_md5'] = md5($arr['url']);
    	
    	$arr['date'] = $this->hitArr['date'];
    	
    	/**Делаем так, а не так
    	 * 
		   	$this->db->query("INSERT INTO ?# SET hits = 1, hosts = 1, ?a " .
    			"ON DUPLICATE KEY UPDATE hits = hits+ ?d, hosts = hosts+1, ?a", DB_PFX."st_pages", 
    			$arr,$this->hitArr['hit'], $arr );
    	 * ибо для полной статы нужны id а они так не всегда получаем
    	 * **/
    	$id = $this->db->selectCell("SELECT id FROM ?# WHERE date = ? AND url_md5 = ?",
    			 DB_PFX."st_pages", $arr['date'],$arr['url_md5']);
    	
    	if($id){
    		$this->db->query("UPDATE ?# SET hits = hits+ ?d, hosts = hosts+1 WHERE id = ?d", 
    							DB_PFX."st_pages",$this->hitArr['hit'], $id);
    	}else{
    		
    		$arr['hits'] = $this->hitArr['hit'];
    		$arr['hosts'] = "1";
    		
    		$id = $this->db->query("INSERT INTO ?# SET ?a ON DUPLICATE KEY UPDATE ?a",
    								 DB_PFX."st_pages", $arr, $arr);
    	}

    	$this->hitArr['url_id'] = $id;
    	
    }
    
    private function saveRef(){
    	
    	/**рефер**/
    	if(empty($_SERVER['HTTP_REFERER'])){
    		return false;
    	}
    	if(!empty($_SERVER['HTTP_HOST'])){
    		$res = stripos($_SERVER['HTTP_REFERER'], "http://".$_SERVER['HTTP_HOST']);
    		if($res === false){
	    		
	    	}else{
	    		return false;
	    	}
    	}	
    	$arr['url'] =$_SERVER['HTTP_REFERER'];
		$arr['url_md5'] = md5($arr['url']);
	
	    $arr['date'] = $this->hitArr['date'];
	    	
	    $id = $this->db->selectCell("SELECT id FROM ?# WHERE date = ? AND url_md5 = ?",
    			 DB_PFX."st_refs", $arr['date'],$arr['url_md5']);
    
	    if($id){
	    	$this->db->query("UPDATE ?# SET hits = hits+ ?d, hosts = hosts+1 WHERE id = ?d", 
	    							DB_PFX."st_refs",$this->hitArr['hit'], $id);
	    }else{
	    		
	    	$arr['hits'] = $this->hitArr['hit'];
	    	$arr['hosts'] = "1";
	    		
	    	$id = $this->db->query("INSERT IGNORE INTO ?# SET ?a ", DB_PFX."st_refs", $arr);
	   	}
    	
//	    	$this->db->query("INSERT INTO ?# SET hits = 1, hosts = 1, ?a " .
//    			"ON DUPLICATE KEY UPDATE hits = hits+ ?d, hosts = hosts+1, ?a", DB_PFX."st_refs", 
//    			$arr,$this->hitArr['hit'], $arr );	
			
		$this->hitArr['ref_id'] = $id;		
    	
    	return false;
    	
    }
    
    private function is_bot($str){
    	/**список ботов
		 * 
		 * Mozilla/5.0 (compatible; Nigma.ru/3.0; crawler@nigma.ru)
		 * Mozilla/5.0 (compatible; stat.cctld.ru/Bot; +http://stat.cctld.ru/bot.html)
		 * Mozilla/5.0 (compatible; statdom.ru/Bot; +http://statdom.ru/bot.html)
		 * TppRFbot/1.1 (compatible; http://www.ruschamber.net, http://www.geocci.com)
		 * Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)
		 * Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)
		 * Mozilla/5.0 (compatible; YandexFavicons/1.0; +http://yandex.com/bots)
		 * Mozilla/5.0 (compatible; Ezooms/1.0; ezooms.bot@gmail.com)
		 * Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)
		 * 
		 * ***/

		$bot_arr = array("Yandex", 'Google', 'Nigma.ru','cctld.ru','TweetmemeBot','topsy.com','Butterfly',
		'statdom.ru','ezooms','bingbot');
   
    	foreach ($bot_arr as $k=>$v){
    		$res = stripos($str, $v);
    		
    		if ($res === false) {
    			continue;
    		}else{
    			return $v;
    		}
    	}
    	return "";
    	
    }
}
