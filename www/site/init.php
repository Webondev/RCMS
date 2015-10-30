<?php
/**
 *Инициализация всего 
 *Подключение нужных файлов и остального другого 
 * 
 **/

define('ROOT_PATH', realpath(dirname(__FILE__)."/.." )); //defined('ROOT_PATH') or die('No direct script access.');
//define('ROOT_PATH', realpath(dirname(__FILE__)."/../../.." ));

require_once("config_site.php");
require_once("constants.php");
require_once("config_db.php");

if(IS_DEVELOP){
	$start_memory_usage = memory_get_usage();
	$start_time = microtime(true);
	
	error_reporting( E_ALL );
	ini_set( 'display_errors', 1 );
}

session_start();  	

 /**Подключение классов
  * можно подключить и просто последний, который и наследует все остальные,
  * пока это админский класс
  * **/
require_once(M_LIB_PATH."/init/app.class.php");
require_once(M_LIB_PATH."/init/initAdminMainFrame.class.php");
require_once(M_LIB_PATH."/init/initAdminImage.class.php");

 