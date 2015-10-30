<?php
/***
 * Created on Dec 28, 2012
 *
 */

class counter extends initAdminMainFrame{
	
	function __construct(){
		parent::__construct();

		
	}

	
	public function actionIndex(){

		$this->actionPages();

	}

	public function actionPages(){
		$this->get();
		$data = $this->get;
		
		$data['limit'] = 40;
		
		if(!empty($this->get['limit'])){
			$data['limit'] = (int)$this->get['limit'];
		}
		
		if(empty($this->get['from'])|| empty($this->get['to'])){
						$data['from'] = date("Y-m-d");
			$data['to'] = date("Y-m-d");
		}
		$sql =" WHERE date >= '".$data['from']."' AND  date <= '".$data['to']."'";
		
		$pager = $this->myPager($data['limit']);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# ' .
		$sql.
		" ORDER BY id DESC LIMIT ".$pager['limit'], DB_PFX."st_pages");
		
		$data['hits'] = $this->db->selectCell("SELECT SUM(hits) FROM ?# ".$sql, DB_PFX."st_pages");
		$data['hosts'] = $this->db->selectCell("SELECT SUM(hosts) FROM ?# ".$sql, DB_PFX."st_pages");
		
		$this->assign("data", $data);
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);
		
		$this->render("admin/counter/pages.tpl");
	}	
	public function actionRefers(){
		$this->get();
		$data = $this->get;
		
		$data['limit'] = 40;
		
		if(!empty($this->get['limit'])){
			$data['limit'] = (int)$this->get['limit'];
		}
		
		if(empty($this->get['from'])|| empty($this->get['to'])){
						$data['from'] = date("Y-m-d");
			$data['to'] = date("Y-m-d");
		}
		$sql =" WHERE date >= '".$data['from']."' AND  date <= '".$data['to']."'";
		
		$pager = $this->myPager($data['limit']);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# ' .
		$sql.
		" ORDER BY id DESC LIMIT ".$pager['limit'], DB_PFX."st_refs");
		
		$this->assign("data", $data);
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);
		
		$this->render("admin/counter/refers.tpl");	
	}
	public function actionVisiters(){
		$this->get();
		$data = $this->get;
		
		$data['limit'] = 40;
		
		if(!empty($this->get['limit'])){
			$data['limit'] = (int)$this->get['limit'];
		}
		
		if(empty($this->get['from'])|| empty($this->get['to'])){
						$data['from'] = date("Y-m-d");
			$data['to'] = date("Y-m-d");
		}
		$sql =" WHERE date >= '".$data['from']."' AND  date <= '".$data['to']."'";
		
		$pager = $this->myPager($data['limit']);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# ' .
		$sql.
		" ORDER BY id DESC LIMIT ".$pager['limit'], DB_PFX."st_visiters");
		
		$this->assign("data", $data);
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);
		
		$this->render("admin/counter/visiters.tpl");
	}
	
}
