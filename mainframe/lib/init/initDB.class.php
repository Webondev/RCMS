<?php
/**
 * 
 * Инициализация работы с базой данных и подключение 
 * необходимых файлов
 * 
 * ***/
require_once('coreMethod.class.php');
require_once(M_LIB_PATH.'/orm.class.php');
require_once(M_LIB_PATH.'/db/simplePager.class.php');

class initDB extends coreMethod{
	
	public $db;
	
    function __construct() {
    	
     	/**COnnect to db**/	
        $this->connectDB();  
        
    }
        /**Соединение с БД**/
    private function connectDB(){
    	require_once(M_LIB_PATH.'/db/rDBSimple.php');

		$rDBSimple = new rDBSimple;
		$this->db = $rDBSimple->connect('mysql://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME);
	//$this->db->setErrorHandler('databaseErrorHandler');
		$this->db->setErrorHandler(array('initDB','databaseErrorHandler'));
		$this->db->query('SET NAMES UTF8');
	//print_R($db->query("SHOW TABLES "));
    	
    }
    /**Ошибка БД **/
    public function databaseErrorHandler($message, $info){
	    if (!error_reporting()) return false;
	    if(IS_DEVELOP){
		    echo "SQL Error: $message<br><pre>"; 
		    print_r($info);
		    echo "</pre>";
	    }
	    
	    $error_msg = " -".date("d-m-Y h:i")."-SQL Error: $message<br><pre>".print_r($info, true)."</pre>";
	    
	    $err_file = S_PATH."/tmp/db_error_log.txt";
	    $fp = fopen($err_file , 'a+');
		fwrite($fp, $error_msg);
	    fclose($fp);
	    
	    //exit();
	}

	public function myPager($limit = 10){
		$pageN = 0;
		$get = $_GET;
		
		if(!empty($get['page'])){
			$pageN = $get['page'];
			unset($get['page']);
		}
		$get = http_build_query($get);
		if(empty($get)){
			$get ="page={%PAGE%}";
		}else{
		$get = $get."&page={%PAGE%}";
		}
		$pager["obj"] = new simplePager($limit, $pageN, '?'.$get);
		$pager['total'] = 0;
		$pager['limit'] = $pager["obj"]->getMySQLLimit();
		
		return $pager;
		
		/****EXAMPLE****
		 * 
		$pager = $this->myPager(20);
		
		$list = $this->db->selectPage($pager['total'], 'SELECT * ' .
		' FROM ?# 
		ORDER BY id DESC LIMIT '.$pager['limit'], $this->table);
		
		
		$this->assign("list", $list);
		$this->assign('pages', $pager["obj"]->getPagesStr($pager['total']));
		$this->assign('total', $pager['total']);	
			
		**/
	}

	/**сделан для красивых урлов без get запросов, может и работает но пока не востребована***/
	public function myPathPager($limit = 10, $num1=3){
		$pageN = 0;
		
		if(!empty($this->path[$num1])){
			$pageN = (int)$this->path[$num1];
		}
		
		$get = "/post/page/{%PAGE%}";
		$pager["obj"] = new simplePager($limit, $pageN, $get);
		$pager['total'] = 0;
		$pager['limit'] = $pager["obj"]->getMySQLLimit();
		
		return $pager;
		
	}



/*** ПРИМЕР ПАГИНАЦИИ
$get = $_GET;
if(!empty($get['page'])) unset($get['page']);
$get = http_build_query($get);
$get = $get."&page={%PAGE%}";
$pager = new simplePager(50, @$_GET['page'], '?'.$get);

$total = 0;
$mixdata = "";
if(!empty($_GET['mixdata'])){
	$mixdata = htmlspecialchars($_GET['mixdata']);
	$mixdata = "AND (u.nick LIKE '%".$mixdata."%' OR u.full_name LIKE '%".$mixdata."%' OR u.email LIKE '%".$mixdata."%' OR u.telephone LIKE '%".$mixdata."%') ";
}

$list = $db->selectPage($total, 'SELECT u.* , r_u.login AS ref_login, ' .
		' INET_NTOA(u.ip) AS true_ip 
		FROM users As u 
		LEFT JOIN gold_cities AS gc ON u.city = gc.id ' .
		'LEFT JOIN users AS r_u ON r_u.id = u.ref_id 
		WHERE u.id > 0 ' .
		'{ AND u.country = ?d }
		{ AND gc.name LIKE ? } ' .
		'{ AND u.payed > ?d  } ' .
		'{ AND u.id = ?d  } ' .
		$mixdata.
		'ORDER BY u.id DESC LIMIT '.$pager->getMySQLLimit(),
		empty($_GET['country']) ? DBSIMPLE_SKIP : $_GET['country'],
		empty($_GET['city']) ? DBSIMPLE_SKIP : "%".$_GET['city']."%",
		empty($_GET['payed']) ? DBSIMPLE_SKIP : 0,
		empty($_GET['user_id']) ? DBSIMPLE_SKIP : $_GET['user_id']);


$site->assign("list", $list);

$site->assign('pages', $pager->getPagesStr($total));
$site->assign('total', $total);

*/

}