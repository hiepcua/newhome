<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','pages');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
$isAdmin = getInfo('isadmin');
$objmysql 	= new CLS_MYSQL();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

$task='';
if(isset($_GET['task'])) $task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
if($isAdmin){
	include_once(THIS_COM_PATH.'task/'.$task.'.php');
}else{
	echo "404 not found!";
	exit();
}
unset($obj); unset($task);	unset($objmysql); unset($ids);
?>