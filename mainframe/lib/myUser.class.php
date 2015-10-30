<?php
class User_Error_Exception extends Exception{};

class myUser {
	
	private $db;
	public $tbl;
	public $data; //данные юзера
	public $roles; //список ролей
	
    function __construct($db, $id = false) {
    	
    	$this->db = $db;
    	$this->tbl = DB_PFX."users";
    	
		$this->get_info($id);
		
		$this->roles = array(
				"user"=>"Юзер",
				"admin"=>"Админ",
				"manager"=> "Менеджер");
    }
    
    /**аторизация без пасса*/
    public function forceAuth($id){
    	
    		$data_arr['id'] = (int)$id;
    		if($data_arr['id']){
    			$data_arr['rand_hash'] = $this->getRandHash(); //случайный хэш, генерирем при каждом новом заходе, и сохраняем
				
				$_SESSION['UID'] = $id;			
				$_SESSION['hash'] = $data_arr['rand_hash'];
				
				$this->saveFields($data_arr);
				
				return true;
    		}else{
    			return false;
    		}
    }
    
    /**авторизация**/
    public function auth($login="",  $pass){
    	
    	$data = $this->getFastData($login, $login); // получаем данные по юзеру по логину или email
    	
		if($data){
			
			if($this->hashPassword($pass, $data['salt']) == $data['password']){
				
				$data_arr['rand_hash'] = $this->getRandHash(); //случайный хэш, генерирем при каждом новом заходе, и сохраняем
				$data_arr['id'] = $data['id'];
				
				$_SESSION['UID'] = $data['id'];			
				$_SESSION['hash'] = $data_arr['rand_hash'];
				
				$this->saveFields($data_arr, $data['id']);
				
				$this->get_info();
				
				return true;
				
			}else{
				return false;
			}
			
		}else{
			return false;
		}   	
    	
    	
    }
    /**Получение данных по юзеру для авторизации**/
    public function getFastData($login="", $email=""){
		$res = "";
    	if(!empty($login) && !empty($email)){
    		$res = " OR ";
    	}

		return $this->db->selectRow("SELECT id, salt, password, login, email FROM ?# " .
				"WHERE " .
				"{login = ?} " .
				$res .
				"{email = ?}", 
				$this->tbl,
				empty($login) ? DBSIMPLE_SKIP : $login, 
				
				empty($email) ? DBSIMPLE_SKIP : $email);
    	
    }
    
    /**Получаем информацию по юзеру, если он авторизирован**/
    public function get_info($id=false){
    	
    	if($id && (int)$id){
    		$this->getData($id);
    		return true;
    	}
    	if(!empty($_SESSION['UID']) && ($id = (int)$_SESSION['UID'])
    	  	 && !empty($_SESSION['hash'])){
	    		
	    	$this->getData($id);
	    		
     	}else{
    	  	$this->data = array();
    	}
    	
    }
     /**Аторизирован ли юзер**/
    public function is_authed(){
		if(!empty($_SESSION['UID']) && ($id = (int)$_SESSION['UID']) && !empty($_SESSION['hash'])){
			
			$hash = $_SESSION['hash'];
	    	if($this->data && $this->data['rand_hash'] == $hash){
	    		return true;
	    	}
		}
    	return false;
    }   
    
    
    /****/
    public function logout(){
    	
    	if(!empty($_SESSION['UID'])){
    		unset($_SESSION['UID']);
    	}
    	if(!empty($_SESSION['hash'])){
    		unset($_SESSION['hash']);
    	}
    	
    }    
    /**Получим данные по юзеру**/
    public function getData($id){
    	
    	$this->data = $this->db->selectRow("SELECT * FROM ?# WHERE id = ?d", $this->tbl, $id);
    	
    	return $this->data;
    }

     /**сохраним какоето значение**/
    public function saveFields($data_arr, $id = ""){
    	
    	if($id == ""){
    		$id = $this->data['id'];
    	}

    	$this->db->query("UPDATE ?# SET ?a WHERE id = ?d",
    					 $this->tbl,$data_arr, $id);
    } 
        /**сгенерируем и получим соль**/
    public function getRandSalt(){
		return substr(uniqid('').rand(1,100), -10);   	
    }    
    
     /**зашифруем пароль**/
    public function hashPassword($pass, $salt){
    	
  		return 	md5(md5($pass).$salt);
    	
    }  
    
    /**Генерируем случайный хэш**/
    public function getRandHash(){
    	return md5($this->getRandSalt());
    }
    
    /**изменим пароль**/
    public function changePass($new_pass){

    		$new_pass = trim($new_pass);

    		$data_arr['salt']  = $this->getRandSalt();
    		$data_arr['password']= $this->hashPassword($new_pass, $data_arr['salt']);
    		
    		$this->saveFields($data_arr);
    		return true;

    	
    }  
    /**Просто сохраним нового юзера **/
    public function simpleSaveNewUser($data){
    	
    	if(empty($data['password'])
    		|| empty($data['email'])){
    			
    		return false;
    	}
    	
    	if(empty($data['login'])){
    		$data_arr['login'] = $data['email'];
    	}else{
    		$data_arr['login'] = $data['login'];
    	}
    	 if(!empty($data['role'])){
    		$data_arr['role'] = $data['role'];
    	}
    	if($this->getFastData($data['login'], $data['email'])){
    		throw new Exception("SUCH_USER_EXISTS_IN_DB");
    	}
    	
    	$data_arr['email'] = $data['email'];
    	$data_arr['salt']  = $this->getRandSalt();
    	$data_arr['password']= $this->hashPassword($data['password'], $data_arr['salt']);
    	$data_arr['original_pass'] = "";
    	if(SAVE_ORIGINAL_PASS){
    		$data_arr['original_pass'] = $data['password'];
    	}
    	
    	$data_arr['id'] = $this->db->query("INSERT INTO ?# SET ?a ",
    					 $this->tbl,$data_arr);
    	return $data_arr['id'];				 
			 
    }
   

	
}
