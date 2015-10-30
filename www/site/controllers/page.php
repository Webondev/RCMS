<?php
/*
 * Created on Dec 28, 2012
 *
 */

require_once(LIB_PATH."/mainFrame.class.php");

class page extends mainFrame{
	
	function __construct(){
		parent::__construct();

	}
	
	public function actionIndex(){
		
		$this->actionError404();
		
	}
	

	
	
}
