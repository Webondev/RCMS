<?php
/**
 * Первая версия типа ORM 
 * 
 * **/
 
class orm {
	
	private $db;
	public $table;
	public $id; //это поле id, если онокакоето дрогое то нужно указать
	
    function __construct($db, $table) {
    	$this->db = $db;
    	$this->table = $table;
    	$this->id = "id";
    }
    
    /**Всавляем новую запись**/
     public function insert($data){
    	
    	$data_res = $this->getColls($data);
    	
    	if($data_res){
    		return $this->db->query("INSERT INTO  ?# SET ?a ", $this->table, $data_res);
    	}
    	return false;
    }   
    
    /**СОханяем данные по уже существующей записи**/
    public function save($id, $data){
    	
    	if(empty($id) || !(int)$id) return false;
    	
    	
    	$data_res = $this->getColls($data);
    	if($data_res){
    		$this->db->query("UPDATE ?# SET ?a WHERE ?# = ?d",
    		 $this->table, $data_res, $this->id,$id);
    		 return true;
    	}
    	return false;
    }
    
    /**получаем список колонок таблицы и подгоняем полученный массив под нашу тадлицу**/
    private function getColls($data){
    	$data_res = array();
    	$res = $this->db->select("SHOW COLUMNS FROM ?#", $this->table);

    	if($res){
    		foreach($res as $k=>$v){
    			if(!empty($v['Field']) 
	    			&& $v['Field'] !== $this->id 
	    			&& isset($data[$v['Field']]) 
	    			&& !is_array($data[$v['Field']])){
	    				
    					$data_res[$v['Field']] = $data[$v['Field']];
    			}
    		}
    	}
    	return $data_res;
    }
    
    /**ПОлучаем одну запись по ид*/    
    public function get($id){
    	return $this->db->selectRow("SELECT * FROM ?# WHERE ?# = ?d", $this->table, $this->id, (int)$id);
    }
        /**ПОлучаем одну запись по заданному полю
         * $val - значение искомое
         * $field - поле по  которому ищем
         * $list - список или одно значение
         * */    
    public function getBy($val, $field, $list=false){
    	
    	if($list){
    		return $this->db->select("SELECT * FROM ?# WHERE ?# = ?", $this->table, $field, $val);
    	}else{
    		return $this->db->selectRow("SELECT * FROM ?# WHERE ?# = ?", $this->table, $field, $val);
    	}
    	
    }
    
    /**Получаем список */
    public function getList($from = false, $to = false, $ordr = "ASC"){
    	$q = "";
    	$to = (int)$to;
    	
    	$q .= " ORDER BY ".$this->id." ".$ordr;
    	
    	if($to){
    		$q .= " LIMIT ".(int)$from.", ".(int)$to;
    	}
    	return $this->db->select("SELECT * FROM ?# ".$q, $this->table);
    }
    
    /**удаление, или массив номеров id, или номер id**/
    public function delete($data){
    	
    	if(!is_array($data) || !(int)$data){
    		return false;
    	}
    	
    	$this->db->query("DELETE FROM ?# WHERE " .
    			"{?# IN(?a)}" .
    			"{?# = ?} " , 
    			(is_array($data)) ? DBSIMPLE_SKIP : $data,
    			((int)$data) ? DBSIMPLE_SKIP : $data);
    	
    }
}
