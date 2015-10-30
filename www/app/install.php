<?php
require_once("../site/init.php");

$_init = new initDB();

$f_list = glob(ROOT_PATH."/app/sqls/*.sql");
print_R($f_list);

foreach($f_list as $k=>$v){
	$_sql = file_get_contents($v);
	$_init->db->query($_sql);
}

?>
<h1>INSTAL NEW SITE FINISHED</h1>