<?php
/*
 * Created on Dec 28, 2012
 *
 */
defined('ROOT_PATH') or die('No direct script access.');

require_once(LIB_PATH."/mainFrame.class.php");

class user extends mainFrame{
	
	function __construct(){
		parent::__construct();

	}
	
	public function actionIndex(){
		
		$this->render("user/profile.tpl");
		
	}
	public function actionAuth(){
		/**Авторизация юзера*/
	    try{	
	    	
			$this->setLastVisit();
	    	
	    	$error = "";
	    	$this->post();
	    	
	    	if(!empty($this->post)){
		    	if(empty($this->post['login']) 
		    		|| empty($this->post['password'])
		  //|| empty($this->post['captcha'])
		    			){
		    		throw new Exception("EMPTY_REQUIRED_FIELDS");
		    	}
	    		if(!isset($_SESSION['captcha_keystring'])){
	    			throw new Exception("CAPTCHA_INIT_ERROR");
	    		}
//	    		if( $_SESSION['captcha_keystring'] !== $this->post['captcha']){
//	    			throw new Exception("CAPTCHA_ENTER_ERROR");
//	    		}
	    		
	    		if(!preg_match("!^[0-9A-Za-z]{3,30}$!is",$this->post['login'])){
	    			throw new Exception("NOT_CORRECT_LOGIN");
	    		}
	    		$data['login'] = $this->post['login'];
	    		$data['password'] = $this->post['password'];
	    		
	    		if(!$this->user->auth($data['login'], $data['password'])){
	    			throw new Exception("WRONG_LOGIN_OR_PAROL");
	    		}

		    	//$this->redirectToLast();
		    	$this->redirect("/");
		    	exit;
	    	}	
			//$this->redirectToLast();
			
	    }catch(Exception $e){
	    	$error = $e->getMessage();
	    	
	    }
	    $this->assign("error", $error);
		$this->render("user/login-form.tpl");
	}
	private function setLastVisit(){
			    	$to_url = "/";
	    	if(!empty($_SERVER['HTTP_REFERER']) && !empty($_SERVER['REQUEST_URI'])){
	    		$res = stripos($_SERVER['HTTP_REFERER'], $_SERVER['REQUEST_URI']);
	    		if($res === false){
	    			$_SESSION['last_url'] = $_SERVER['HTTP_REFERER'];
	    		}
	    	}
	}
	
	private function redirectToLast(){
		
			if($this->user->is_authed()){
	    		$to_url = "/";
	    		if(!empty($_SESSION['last_url'])){
	    			$to_url = $_SESSION['last_url'];
	    		}
	    		$this->redirect($to_url);
	    	}
	}
	
	public function actionRegister(){
		
		$this->render("user/register.tpl");
		
	}
	
	public function actionRestore(){
		
		$this->render("user/restore.tpl");
	}
	
	public function actionLogout(){
		
		$this->user->logout();
		$this->redirect("/");
		
	}

}
