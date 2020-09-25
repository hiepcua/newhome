<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];
	$objmysql = new CLS_MYSQL();
	$sql="DELETE FROM `tbl_modules` WHERE `id` in ('$id')";
	$objmysql->Exec($sql);
	echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."'</script>";
?>