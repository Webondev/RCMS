<?php
/**
 * Created on Dec 28, 2012
 *
 */

defined('ROOT_PATH') or die('No direct script access.');

require_once(LIB_PATH."/mainFrame.class.php");

class index extends mainFrame{
	
	function __construct(){
		parent::__construct();
	}
	
	public function actionIndex(){
		
		$pager = $this->myPager(10);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * FROM ?# WHERE status = 2 ' .
				' ORDER BY id DESC LIMIT '.$pager['limit'], DB_PFX."posts");
		
		
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);

		$this->render("post/posts.tpl");

	}
	
	public function actionPost(){
		
		
		
		
		$this->render("post/view.tpl");
	}
	
	
}
