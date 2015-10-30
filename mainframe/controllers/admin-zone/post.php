<?php
/***
 * Created on Dec 28, 2012
 *
 */

class post extends initAdminImage{
	
	function __construct(){
		parent::__construct();
		
		$this->table = DB_PFX."posts";
		
		$this->loadModel($this->table);
		
		/**список статусов страниц**/
		$this->status_list = array(
						//"0"=>"tmp",
						"1"=>"draft",
						"2"=>"published",
						"3"=>"deleted");
	}
	/**получим список категорий**/
	public function getCats(){
		
		$res = $this->db->selectCol("SELECT id AS ARRAY_KEY, name FROM ?#", DB_PFX."post_categories");
		//print_R($res);
		return $res;
	}
	
	public function actionIndex(){

		$pager = $this->myPager(20);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# ' .
		"WHERE status <> '3' AND status > '0' 
		ORDER BY id DESC LIMIT ".$pager['limit'], $this->table);
		
		
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);
		
		$this->render("admin/post/list.tpl");
		
	}
	
	/**РЕдактирование и создание. если не указан id  в get запросе - создаем новую запись и редиректим сюда же опять**/
	public function actionEdit(){
		
		try{
			$error="";
			
			$this->get();
			$tmp_id = 0;
			
			if(empty($this->get['id']) || !($id = (int)$this->get['id'])){
				/**если нет id то берем если создана временную запись, либо, создаем новую временную**/
				if(!$tmp_id = $this->model->getBy("0","status")){
					$_save = array("title"=>"tmp title", "status"=>"0");
					if(!$tmp_id = $this->model->insert($_save)){
						echo "Ошибка при создании временного поста";
						$this->endApp(true);
					}
				}
				
				if(is_array($tmp_id)) $tmp_id = $tmp_id['id'];
				
				$this->redirect("/admin-zone/post/edit?id=".$tmp_id);
				$this->endApp(true);
				
			}
			
			$data = array( "title"=>"", "url"=>"",  "text"=>"", "status"=>"1", "category_id" => "");
			$require = array_keys($data);
			
			$res = $this->model->get($id);
			
			if(!$res){
				$error="Нет поста с таким id";
				$this->assignSession("error", $error);
				$this->redirect("/admin-zone/post/");
			} 
			
			$this->post(); //получим $_POST в $this->post;
			
			if(!empty($this->post['post'])){
				$data =  $this->post['post'];
				
				$_save = $this->valid->is_empty($data, $require);
				
				if(!empty($data["description"])){
					$_save['description'] = $data["description"];
				}
				
				$_save['text_preview'] =  myFunc::getShort($_save['text'] , 500);
				$_save['create_time'] = time();
				$_save['update_time'] = time();
				
				$_save['author_id'] = $this->user->data['id'];
				$_save['main_pic'] = "";

				if($this->model->save($id, $_save)){
					$tmp_info = "Сохранено!";
					if(!empty($data['to_ping']) && ((int)$data['status'] == 2)){
						myFunc::pingPostUrl($_save['url']);
						$tmp_info .= " Пинг отправлен.";
					}
					
					myFunc::generSitemap($this->db);
					
					$this->assignSession("info", $tmp_info);
					$this->redirect("/admin-zone/post/");
				}
			}
			
			$data = $res;
			
		}catch(Exception $e){
			$error = $e->getMessage();
		}
		$this->activateImgUp($id,"post"); //activating img uploader
		
		$this->assign("cat_list", $this->getCats());
		
		$this->addAdminJS("edit.js");
		
		$this->assign("data", $data);
		$this->assign("error", $error);
		
		$this->render("admin/post/item.tpl");
		
	}
	/**действие удления поста, точнее перевод в статус удаленного**/
	public function actionDel(){
		$error="";
		try{
			$this->get();
		
			if(empty($this->get['id']) || !($id = (int)$this->get['id'])){
				 $error="Нет id поста";
			}
			
			$_save = array("update_time"=>time(), "status"=>"3");
			
			$this->model->save($id, $_save);
			
			
		}catch(Exception $e){
			
			$error = $e->getMessage();
			
		}
		$this->assign("error", $error);
		$this->redirect("/admin-zone/post/");
		
	}
	
	public function initSimpleComments(){
		
		include_once("simpleComments.class.php");
		
		$model = new simpleComments(DB_PX."post_comments", $this->db);
		
		if(!empty($this->post['_comment'])){
			$data = $this->post['_comment'];
			
			
		}
		
		$this->assign("c_list", $list);
		
		
	}
		
}
