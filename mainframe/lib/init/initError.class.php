<?php
require_once("initCore.class.php");

class initError extends initCore {

    function __construct() {
    	parent::__construct();
    }
    
    public function error404(){
    	
    	$this->render("errors/404.tpl");
    	
    }
    
    public function actionError404(){
		header("HTTP/1.1 404 Not Found");
		$this->render("errors/404.tpl");
	}
    
}
