<?php
/***
 * Created on Dec 28, 2012
 *
 */

class page extends initAdminImage{
	
	function __construct(){
		parent::__construct();
		
		$this->table = DB_PFX."pages";
		
		$this->loadModel($this->table);
		
		/**список статусов страниц**/
		$this->status_list = array(
						//"0"=>"tmp",
						"1"=>"draft",
						"2"=>"published",
						"3"=>"deleted");
	}
	
	public function actionIndex(){
		
//		$list = $this->model->getList();
//		
//		$this->assign("list", $list);
//		$this->render("admin/page/list.tpl");

		$pager = $this->myPager(20);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# ' .
		'WHERE status <> \'3\' AND status > \'0\' 
		ORDER BY id DESC LIMIT '.$pager['limit'], $this->table);
		
		
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);
		
		$this->render("admin/page/list.tpl");
		
	}
	/**первая версия для создания нового поста, но из за желания, использовать аякс загрузку  файлов - 
	 * сделал другой подход и использую только actioEdit***/
	public function actionAdd(){
		try{
			$this->post(); //получим $_POST в $this->post;
			$error="";
			$data = array("title"=>"", "url"=>"", "description"=>"", "text"=>"", "status"=>"1");
			
			$require = array_keys($data);
			
			if(!empty($this->post['page'])){
				$data =  $this->post['page'];
				$_save = $this->valid->is_empty($data, $require);
				
				$_save['text_preview'] = myFunc::getShort($_save['text'] , 500);
				$_save['create_time'] = time();
				$_save['update_time'] = time();
				
				$_save['author_id'] = $this->user->data['id'];
				$_save['main_pic'] = "";

				if($this->model->insert($_save)){
					$this->redirect("/admin-zone/page/");
				}
				
			}
			
		}catch(Exception $e){
			$error = $e->getMessage();
		}
		$this->addAdminJS("page-edit.js");
		$this->assign("data", $data);
		$this->assign("error", $error);
		$this->render("admin/page/item.tpl");
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
				
				$this->redirect("/admin-zone/page/edit?id=".$tmp_id);
				$this->endApp(true);
				
			}
			
			$data = array( "title"=>"", "url"=>"", "description"=>"", "text"=>"", "status"=>"1");
			$require = array_keys($data);
			
			$res = $this->model->get($id);
			
			if(!$res){
				$error="Нет поста с таким id";
				$this->assignSession("error", $error);
				$this->redirect("/admin-zone/page/");
			} 
			
			$this->post(); //получим $_POST в $this->post;
			
			if(!empty($this->post['page'])){
				$data =  $this->post['page'];
				$_save = $this->valid->is_empty($data, $require);
				
				$_save['text_preview'] =  myFunc::getShort($_save['text'] , 500);;
				$_save['create_time'] = time();
				$_save['update_time'] = time();
				
				$_save['author_id'] = $this->user->data['id'];
				$_save['main_pic'] = "";

				if($this->model->save($id, $_save)){
					$this->assignSession("info", "Сохранено!");
					$this->redirect("/admin-zone/page/");
				}
			}
			
			$data = $res;
			
		}catch(Exception $e){
			$error = $e->getMessage();
		}
		$this->activateImgUp($id,"page");
		

		
		$this->addAdminJS("page-edit.js");
		
		$this->assign("data", $data);
		$this->assign("error", $error);
		
		$this->render("admin/page/item.tpl");
		
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
		$this->redirect("/admin-zone/page/");
		
	}
	
	
		
}
