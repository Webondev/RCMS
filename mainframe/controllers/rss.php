<?php
/**
 * Created on Dec 28, 2012
 *
 */

defined('ROOT_PATH') or die('No direct script access.');

require_once(LIB_PATH."/mainFrame.class.php");

class rss extends mainFrame{
	
	function __construct(){
		parent::__construct();
	}
	
	public function actionIndex(){
		
		/***выведем 10 последних постов**/
		
		$news = $this->db->select("SELECT * FROM ?# " .
					"WHERE status = 2 AND update_time < ?d  " .
				"ORDER BY id DESC LIMIT 10 ",
		 DB_PFX."posts", time());
		 
		
		 require_once(M_E_PATH.'/simpleRSS.class.php');
		 $rss = new simpleRSS(SITE_NAME, HOST_URL, 'Посты', array('lastBuildDate' => date('r', time())));
		 
		 foreach($news as $p){
		 	$p['url'] = HOST_URL."/post/".$p['url'].".html";
		 	$rss->addItem(
				$p['title'], 
				$p['url'], 
				$p['text_preview'], 
				array('guid'=>$p['url'], 'author' => "admin@mymphone.ru"));
		 }
	
		 $rss->printXML('utf-8');
		 
		 $this->endApp(true);
		 
	}
	
	
}
