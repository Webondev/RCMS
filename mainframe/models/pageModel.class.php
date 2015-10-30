<?php

class pageModel extends orm{

	public $table;

    function __construct($db, $table) {
    	
    	$this->table = $table;
    	parent::__construct($db, $this->table);
    }
    
    /**установка заданного номаера статуса**/
    public function setStatus($id,$status){
		   $_save['status']= (int)$status;
		   $this->save($id, $_save); 	
    }
    

}
