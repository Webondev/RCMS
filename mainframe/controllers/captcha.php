<?php
/**
 * Created on Dec 28, 2012
 *
 */

class captcha extends initMainFrame{
	
	function __construct(){
		parent::__construct();
	}
	
	public function actionIndex(){
		

		require_once(M_FRAME_PATH.'/extensions/captcha/kcaptcha.php');
		
		$captcha = new KCAPTCHA();
		
		if($_REQUEST[session_name()]){
			$_SESSION['captcha_keystring'] = $captcha->getKeyString();
		}
	}
	

	
}
