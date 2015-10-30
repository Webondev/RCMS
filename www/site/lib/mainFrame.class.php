<?php
/**
 * Первый пользовательский мейнфрейм,
 * его стоит наследовать все остальные классы
 * от этого идет и админский мэйнфрэйм
 * **/

defined('ROOT_PATH') or die('No direct script access.');

require_once(M_LIB_PATH."/init/initMainFrame.class.php");

class mainFrame extends initMainFrame {
	
    function __construct() {
    	parent::__construct();
       
       $this->getPostCategories();
       
       		$this->countStatistic();
    }
	public function getPostCategories(){
		
		$list = $this->db->select("SELECT * FROM ?# WHERE status = 1", DB_PFX."post_categories");
		//print_R($list);
		$this->assign("p_categories", $list);
		
		$p_list = $this->db->select("SELECT * FROM ?# WHERE status = 2  LIMIT 5", DB_PFX."posts");
		//print_R($list);
		$this->assign("p_posts", $p_list);
	}

 }
