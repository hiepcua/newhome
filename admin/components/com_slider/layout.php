<?php
defined('ISHOME') or die("Can't access this page!");
define('COMS','slider');
$viewtype='list';

if(isset($_GET['task'])){
	$viewtype=addslashes($_GET['task']);
}

if(is_file(COM_PATH.'com_'.COMS.'/task/'.$viewtype.'.php'))
	include_once('task/'.$viewtype.'.php');	
unset($viewtype); unset($obj);
?>