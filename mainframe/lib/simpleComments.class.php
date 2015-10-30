<?php

class simpleComments extends orm{
	
	public $table;
	
	function __construct($table, $db){
		
		$this->db = $db;
	   	$this->table = $table;
	   	
    	parent::__construct($db, $this->table);
	}
	
	public function addComment($data){

		
	}
	
	public function getComments($id, $approved = true){
		
		
		
	}
	
}
