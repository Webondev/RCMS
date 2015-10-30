<?php
/***
 * Created on Dec 28, 2012
 *
 */

class category extends initAdminMainFrame{
	
	function __construct(){
		parent::__construct();
		
		$this->table = DB_PFX."post_categories";
		
		$this->loadModel($this->table);
		
		/**список статусов категорий**/
		$this->status_list = array(
						//"0"=>"tmp",
						"1"=>"visible",
						"2"=>"hidden",
						"3"=>"deleted");
	}
	
	public function actionIndex(){
		

		$pager = $this->myPager(20);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# ' .
		'WHERE status <> \'3\' AND status > \'0\' 
		ORDER BY id DESC LIMIT '.$pager['limit'], $this->table);
		
		
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);
		
		$this->render("admin/category/list.tpl");
		
	}
	/**первая версия для создания нового поста, но из за желания, использовать аякс загрузку  файлов - 
	 * сделал другой подход и использую только actioEdit***/
	public function actionAdd(){
		try{
			$this->post(); //получим $_POST в $this->post;
			$error="";
			$data = array( "name"=>"", "url"=>"", "status"=>"1");
			
			$require = array_keys($data);
			
			if(!empty($this->post['category'])){
				$data =  $this->post['category'];
				$_save = $this->valid->is_empty($data, $require);
					
				if($this->model->insert($_save)){
					$this->redirect("/admin-zone/category/");
				}
				
			}
			
		}catch(Exception $e){
			$error = $e->getMessage();
		}
		$this->addAdminJS("edit.js");
		$this->assign("data", $data);
		$this->assign("error", $error);
		$this->render("admin/category/item.tpl");
	}
	
	/**РЕдактирование и создание. если не указан id  в get запросе - создаем новую запись и редиректим сюда же опять**/
	public function actionEdit(){
		try{
			$error="";
			
			$this->get();
			$tmp_id = 0;
			
			if(empty($this->get['id']) || !($id = (int)$this->get['id'])){

				$this->redirect("/admin-zone/category/");
				$this->endApp(true);
				
			}
			
			$data = array( "name"=>"", "url"=>"", "status"=>"1");
			$require = array_keys($data);
			
			$res = $this->model->get($id);
			
			if(!$res){
				$error="Нет поста с таким id";
				$this->assignSession("error", $error);
				$this->redirect("/admin-zone/category/");
			} 
			
			$this->post(); //получим $_POST в $this->post;
			
			if(!empty($this->post['category'])){
				$data =  $this->post['category'];
				$_save = $this->valid->is_empty($data, $require);

				if($this->model->save($id, $_save)){
					$this->assignSession("info", "Сохранено!");
					$this->redirect("/admin-zone/category/");
				}
			}
			
			$data = $res;
			
		}catch(Exception $e){
			$error = $e->getMessage();
		}
		
		$this->addAdminJS("edit.js");
		
		$this->assign("data", $data);
		$this->assign("error", $error);
		
		$this->render("admin/category/item.tpl");
		
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
		$this->redirect("/admin-zone/category/");
		
	}
	
	
		
}
