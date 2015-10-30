<?php
/**
 * **/

defined('ROOT_PATH') or die('No direct script access.');
require_once("initSmarty.class.php");

class initCore extends initSmarty {
	public $post;    // тут храним post запросы
	public $get;     // тут храним get запросы
	public $files;
	public $model;   // сюда загружаем нужную модель
	
    function __construct() {
    	parent::__construct(); 
    }
	
    /**ринимает значение $_GET запроса, пожет с ним будет проще**/
	public function get(){
		$this->get = $_GET;
		return $this->get;
	} 
 
  /**ринимает значение $_POST запроса, пожет с ним будет проще**/
	public function post(){
		 $this->post = $_POST;
		return $this->post;
	} 
	
  /**ринимает значение $_FILES запроса, пожет с ним будет проще**/
	public function files(){
		 $this->files = $_FILES;
		return $this->files;
	} 
	/**действие после всего**/
	public function after(){
		$this->display($this->mainTplContainer);
	}
	
	/**загрузим модель для данного контроллера***/
	public function loadModel($table){
		
		$c_name = get_class($this);
		
		$file = M_PATH."/".$c_name."Model.class.php";
		if(!is_file($file)){
			$file = M_M_PATH."/".$c_name."Model.class.php";
		}
		require_once($file);
		
		$m_name = $c_name."Model";
		
		$this->model= new $m_name($this->db, $table);
		
	}

	
	/**Почти Аккуратная остановка приложения
	 * $full - окончательно, чтоб воабще ничего не выводилось
	 * */
	public function endApp($full = false){
		
		if(IS_DEVELOP && !$full){
			global $start_time, $start_memory_usage;
					    $end_time = microtime(true);
			$end_memory_usage = memory_get_usage();
			
			echo "Выполнено за: ".round(($end_time-$start_time),5)." секунд |  ";
			$total_memory_usage = $end_memory_usage - $start_memory_usage;
			//echo $total_memory_usage."<br>";
			echo "Расход памяти:  ". number_format($total_memory_usage, 0, '.', ',') . " байт";
		}
		
		
		exit();
		
	}    
    

}
