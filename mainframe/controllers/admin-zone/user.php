<?php
/*
 * Created on Dec 28, 2012
 *
 */
defined('ROOT_PATH') or die('No direct script access.');

class user extends initAdminMainFrame{
	
	function __construct(){
		parent::__construct();
		
		$this->tbl = DB_PFX."users";
		
		$this->u_orm = new orm($this->db, "tbl_users");

	}
	
	public function actionIndex(){
		
		$this->actionList();
	}
	
	public function actionList(){
		
		$get = "&page={%PAGE%}";
		$pager = new simplePager(30, @$_GET['page'], '?'.$get);
		
		$total = 0;
		
		$list = $this->db->selectPage($total, 'SELECT u.*  FROM ?# AS u ' .
				' ORDER BY u.id DESC LIMIT '.$pager->getMySQLLimit() , $this->tbl);
		
		//print_R($list);
		
		$this->assign("list", $list);
		
		$this->assign('pages', $pager->getPagesStr($total));
		$this->assign('total', $total);
		
		$this->render("admin/user/list.tpl");
	}
	
	public function actionAdd(){
		$data['login']="";
		$data['email'] = "";
		$data['password'] = "";
		$data['role'] = "";
		$this->post();
		$error = "";
			//print_r($this->post);
		try{ 
			if(!empty($this->post)){
				if(empty($this->post['password']) || 
					empty($this->post['email'])){
						
					throw new Exception("ENTERED_NOT_ALL_DATA");
				}
				if($this->post['password'] !== $this->post['password2']){
					throw new Exception("PASSWORDS_NOT_IDENTICAL");
				}
			
				if($this->user->simpleSaveNewUser($this->post)){
					$error ="NEW_USER_ADDED";
				}else{
					$error = "ERROR_ADD_USER";
				}
				
			}
		}catch(Exception $e){
			$error = $e->getMessage();
		}

		$this->assign('role_options', $this->user->roles);
		
		$this->assign("error", $error);
		$this->assign("data", $data);
		$this->render("admin/user/item.tpl");
		
	}
	public function actionEdit(){
		$data['login']="";
		$data['email'] = "";
		$data['password'] = "";
		
		$this->get();
		$this->post();
		$error = "";
			//print_r($this->post);
		try{ 
			if(empty($this->get['id'])) {
				throw new Exception("EMPTY_ID");
			}
			$id=$this->get['id'];
			$edit_user = new myUser($this->db, $id);
			$data = $edit_user->data;
			
			$data_arr['id']=$this->get['id'];
			if(!empty($this->post)){

				if(empty($this->post['email'])){
					throw new Exception("NOT_ENTERED_EMAIL");
				}
				if(!empty($this->post['password']) && !empty($this->post['password2'])){
					if($this->post['password'] !== $this->post['password2']){
						throw new Exception("PASSWORDS_NOT_IDENTICAL");
					}
				}
				if(!empty($this->post['role'])){
    				$data_arr['role'] = $this->post['role'];
    			}
				
				$data_arr['email'] = $this->post['email'];
				$data_arr['login'] = $this->post['login'];
				$data_arr['original_pass'] = "";
		    	if(SAVE_ORIGINAL_PASS){
		    		$data_arr['original_pass'] = $this->post['password'];
		    	}
		    	
				$edit_user->saveFields($data_arr);
				
				$edit_user->changePass($this->post['password']);
				
				
			}
		}catch(Exception $e){
			$error = $e->getMessage();
			
			
		}

		$this->assign('role_options', $this->user->roles);
		
		$this->assign("error", $error);
		$this->assign("data", $data);
		$this->render("admin/user/item.tpl");
		
	}
}
