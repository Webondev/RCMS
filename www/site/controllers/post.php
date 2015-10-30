<?php
/*
 * Created on Dec 28, 2012
 *
 */

require_once(LIB_PATH."/mainFrame.class.php");

class post extends mainFrame{
	
	function __construct(){
		parent::__construct();
		$this->table = DB_PFX."posts";
		
		$this->loadModel($this->table);
	}
	
	public function actionIndex(){
		$path = $this->path(0, true);
		$pageN = 0;
		
		if(!empty($path[2])){
			if($path[2] == "page"){
				if(!empty($path[3]) && (int)$path[3]){
					$pageN = (int)$path[3];
				}
			}else{
				$this->getPost($path[2]);
			}
		}
		
		$limit = 10;
		$get = "/post/page/{%PAGE%}/";
		$pager["obj"] = new simplePager($limit, $pageN, $get);
		$pager['total'] = 0;
		$pager['limit'] = $pager["obj"]->getMySQLLimit();
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# ' .
		'WHERE status = 2 AND update_time < ?d ' .
		'ORDER BY id DESC LIMIT '.$pager['limit'], 
		$this->table, time());
		
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);	
		
		$this->render("post/posts.tpl");
		
	}
	
	public function actionCategory(){
		$path = $this->path(0, true);
		$name = "";
		$pageN = 0;
		
		if(empty($path[3])){
			$this->error404();
		}
		$name = $path[3];
		
		$data = $this->db->selectRow("SELECT * FROM ?# WHERE url = ? ", DB_PFX."post_categories", $name);
		
		if(!$data){
			$this->error404();
		}
		$this->setTitle("Категория ".$data['name']);
		//$this->setDesc($data['description']);
		
		
		
		if(!empty($path[4]) && $path[4] =="page"){
			if(!empty($path[5]) && (int)$path[5]){
				$pageN = (int)$path[5];
			}
		}
		
		$limit = 10;
		$get = "/post/category/".$name."/page/{%PAGE%}/";
		$pager["obj"] = new simplePager($limit, $pageN, $get);
		$pager['total'] = 0;
		$pager['limit'] = $pager["obj"]->getMySQLLimit();
		
		$list = $this->db->selectPage($pager['total'], 'SELECT p.* ' .
			' FROM ?# p LEFT JOIN ?# cat ON p.category_id = cat.id ' .
		'WHERE p.status = 2 AND p.update_time < ?d ' .
			'AND cat.url = ? ' .
		'ORDER BY id ASC LIMIT '.$pager['limit'], 
		$this->table, DB_PFX."post_categories", time(), $name);
		
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);	
		
		$this->render("post/posts.tpl");
		
	}
	
	private function getPost($name){
		
		$name = str_replace(".html", "", $name); //делаем суровую привязку к урлу, дубли мало возможны
		
		$data = $this->db->selectRow("SELECT * FROM ?# WHERE url = ?", $this->table, $name);
		if(!$data){
			$this->error404();
		}
		
		$this->post();
		$error = "";
		$info = "";
		$c_data = array();
		if(!empty($this->post['_comment'])){
			
			$res = $this->addComment($this->post['_comment'], $data);
			
			if($res == "SUCCESS"){
				
				$info = "Ваш комментарий сохранен и ожидает модерации.";
			}else{
				$c_data = $this->post['_comment'];
				$error = "Неверно заполненны поля.";
				$error =$res;
			}
		}
		
		$this->assign("comment_error", $error);
		$this->assign("comment_info", $info);
		
		$this->setTitle($data['title']);
		$this->setDesc($data['description']);
		
		$comments_list = $this->db->select("SELECT * FROM ?# " .
				"WHERE note_id = ?d AND is_moderated = 1", DB_PFX."post_comments", $data['id']);
		$this->assign("comments_list", $comments_list);
		
		$this->assign("c_data", $c_data); 
		$this->assign("data", $data);
		$this->render("post/post.tpl");
	}
	
	private function addComment($data, $note){
		
		try{
			if(empty($data['email']) || empty($data['name']) 
				|| empty($data['captcha'])
				|| empty($data['text'])){
				throw new Exception("REQUIRED_FIELDS_EMPTY");
			}
			
			if(!isset($_SESSION['captcha_keystring'])){
	    			throw new Exception("CAPTCHA_INIT_ERROR");
	    	}
	    	
	   		if( $_SESSION['captcha_keystring'] !== $data['captcha']){
	    		throw new Exception("CAPTCHA_ENTER_ERROR");
	    	}
	    	$data['email'] = trim($data['email']);
	    	$this->valid->email($data['email']);
	    	
			$arr['text'] = strip_tags($data['text']);
			$arr['date_add'] = time();
			$arr['user_name'] = strip_tags($data['name']);
			$arr['user_email'] = $data['email'];
			$arr['note_id'] = $note['id'];
			
			if(!empty($data['website'])){
				$arr['user_web_site'] = htmlspecialchars($data['website']);
			}
			$res = $this->db->query("INSERT INTO ?# SET ?a", DB_PFX."post_comments", $arr);
			if(!$res){
				return "SAVE_ERROR";
			}
			return "SUCCESS";
			
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
}
