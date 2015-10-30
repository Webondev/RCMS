<?php
/**
 * Первый пользовательский мейнфрейм,
 * его стоит наследовать все остальные классы
 * от этого идет и админский мэйнфрэйм
 * **/

defined('ROOT_PATH') or die('No direct script access.');

require_once("initError.class.php");
require_once(M_LIB_PATH."/myUser.class.php");
require_once(M_LIB_PATH."/validation.class.php");

class initMainframe extends initError {
	public $user;    //объект класса myUser
	public $valid;
	
    function __construct() {
    	parent::__construct();
       
        $this->user = new myUser($this->db);
        $this->valid = new validation($this->db);
//echo "1";

		$this->countStatistic();

    }
	public function addJS($file){
		$this->smartyHeader['js'][] = $file;
	}
	public function addCSS($file){
		$this->smartyHeader['css'][] = $file;
	}
     
    /**Счетчик посещений сайта**/
	public function countStatistic(){
		require_once(M_LIB_PATH."/myCounter.class.php");
		
		if(COUNT_VISITS){
			//$counter = new myCounter($this->db);
			
			//$counter->saveVisit();
		}
	}
}
