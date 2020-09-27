<?php
defined('ISHOME') or die("Can't access this page!");
define('COMS','slider');
$viewtype='list';
// Init variables
$objmysql 	= new CLS_MYSQL();
$isAdmin=getInfo('isadmin');

if(isset($_GET['task'])){
	$viewtype=addslashes($_GET['task']);
}

if($isAdmin==1){
	if(is_file(COM_PATH.'com_'.COMS.'/task/'.$viewtype.'.php'))
		include_once('task/'.$viewtype.'.php');	
}else{
    echo "<h3 class='text-center'>You haven't permission</h3>";
    exit();
}
unset($viewtype); unset($obj);
?>