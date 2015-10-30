<?php
/**
 * Главный мэйнфрэйм для адинских файлов
 * **/
defined('ROOT_PATH') or die('No direct script access.');

require_once(M_LIB_PATH."/init/initMainFrame.class.php");
require_once(M_LIB_PATH."/myFunc.class.php");

class initAdminMainFrame extends initMainframe {
	
    function __construct() {
    	parent::__construct();
    	
		$this->isAdmin();
       
		$this->setContainer("admin/index.tpl");
		$this->setTemplate("admin/main.tpl");
		
		
    }
	public function isAdmin(){
		
		if(empty($this->user->data)) {
			$this->redirect("/user/auth.html");
		}
		
		if($this->user->data['role'] !== "admin"){
			$this->redirect("/user/auth.html");
		}
		return true;
	}
	
	
	/**Добовляет файл JS для соответствующего контроллера*/
	public function addAdminJS($file){
		
		$c_name = get_class($this);
		$this->smartyHeader['js'][] = "admin/".$c_name."/".$file;
	}
	/**Добовляет файл CSS для соответствующего контроллера*/
	public function addAdminCSS($file){
		
		$c_name = get_class($this);
		$this->smartyHeader['css'][] = "admin/".$c_name."/".$file;
	}	
}
