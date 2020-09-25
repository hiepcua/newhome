<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$orders='';
	$ids='';
	if(isset($_POST['txtorders']))
		$orders=addslashes($_POST['txtorders']);
	if(isset($_POST['txtids']))
		$ids=addslashes($_POST['txtids']);
	$arids=explode(',',$ids);
	$arods=explode(',',$orders);
	$obj->Orders($arids,$arods);
?>