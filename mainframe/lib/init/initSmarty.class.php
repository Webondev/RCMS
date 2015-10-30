<?php
/**
 * Инициализация работы с шаблонизатором Smarty
 * некоторые методы немного переопределяю 
 * для простоты написания кода
 * ***/


require_once(M_E_PATH."/smarty/Smarty.class.php");
require_once("initDB.class.php");

class initSmarty extends initDB {
	private $smarty;
	public $mainTplContainer;
	public $smartyHeader;

    function __construct() {
    	parent::__construct();
     	/**инициализация смарти**/
 		$this->initSmarty();
 		
 		$this->assign("this", $this);
 		
    }
    
        /**инициализация смарти**/
    private function initSmarty(){

    	$this->smarty = new Smarty();
    	
        $this->smarty->compile_dir  = ROOT_PATH.'/site/tmp/templates_c/';
        $this->smarty->template_dir = T_PATH."/";
        $this->smarty->config_dir   = ROOT_PATH.'/site/extensions/smarty/configs/';
        $this->smarty->cache_dir    = ROOT_PATH.'/site/tmp/cache/';
	
		if(IS_DEVELOP){
			
		//   $this->smarty->debugging = true;
			$this->smarty->caching = false;
		}else{
		//	$this->smarty->caching = false;
			//$this->smarty->caching = true;
			$this->smarty->cache_lifetime = 120;
		}
     	
    	$this->assign("header", "");
    	$this->assign("content", "");
    	$this->assign("title", "");
    	$this->assign("description", "");
    	
    	$this->assign("template", "main.tpl");
    	
    	$this->mainTplContainer = "index.tpl";
    	
    	$this->initConst();
    }
    
    /**Зададим псевдо константы для смарти**/
    private function initConst(){
    	
    	$this->assign("ROOT", "/");
    	$this->assign("ADMIN_URL", "/admin-zone/");
    	
    	$this->assign("title", SITE_NAME);
    	$this->assign("description", "");
    	$this->assign("keys", "");
    	
    	$this->assign("error", "");
    	$this->assign("info", "");
    	/**массив где задаем списки подулючаемых файлов js и css***/
    	$this->smartyHeader = array(
								"js" => array(),
    							"css"=> array());
    	
    }
    
    /**определяем переменные**/
    public function assign($var, $data){
    	
    	$this->smarty->assign($var, $data);
    }
     
    /**сохранение временных переменных**/
    public function assignSession($var, $data){
    	
    	$_SESSION['tmp_vars'][$var] = $data;
    	
    }
    /**Получаем и присваиваем временные переменные и обнуляем временные*/
    public function getAssignSession(){
    	
    	if(!empty($_SESSION['tmp_vars'])){
    		$data = $_SESSION['tmp_vars'];
    		
    		foreach($data as $k=>$v){
    			$this->assign($k, $v);
    		}
    	}
    	$_SESSION['tmp_vars'] = array();
    }
    
    /**Устанавливаем значение шаблона**/
    public function setTemplate($tpl){
    	$this->assign("template", $tpl);
    }
    /**Основной вывод шаблона***/
    public function render($tpl = ""){
    	
		$this->compileHeader();
    	$this->getAssignSession();
    	if($tpl !==""){
    		
    		$this->assign("template", $tpl);
    	}
    	$this->display();
    	
    }
    /**Установим основной шаблон-контейнер**/
    public function setContainer($tpl){
    	$this->mainTplContainer = $tpl;
    }
    
    public function display($tpl=""){
    	if($tpl =="" || !$tpl){
    		$tpl = $this->mainTplContainer;
    	}
    	$this->smarty->display($tpl);
    	$this->endApp();
    }
    
    /**Выводим все заданные файлы стилей и javascript файлы**/
    public function compileHeader(){
    	
    	$header = "";
    	
    	if($this->smartyHeader['js']){
    		foreach($this->smartyHeader['js'] as $k=>$v){
    			$header.='<script type="text/javascript" src="'.ROOT_URL.'theme/js/'.$v.'"></script> ';
    			$header.="\r\n";
    		}
    	}
    	if($this->smartyHeader['css']){
    		foreach($this->smartyHeader['css'] as $k=>$v){
    			$header.='<link rel="stylesheet" href="'.ROOT_URL.'theme/css/'.$v.'" type="text/css" />';
    			$header.="\r\n";
    		}
    	}
    	
    	$this->assign("header", $header);
    	
    }
	
	
	/**ЗАдаем title страницы*/
	public function setTitle($text){
		$this->assign("title", $text);
	}
	/**ЗАдаем description страницы*/
	public function setDesc($text){
		$this->assign("description", $text);
	}
	/**ЗАдаем keys страницы*/
	public function setKeys($text){
		$this->assign("keys", $text);
	}

}
