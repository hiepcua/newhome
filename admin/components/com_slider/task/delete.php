<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];

	$objmysql = new CLS_MYSQL();
	$sql_del = "DELETE FROM `tbl_slider` WHERE `id` in ('$id')";
	$objmysql->Exec($sql_del);
	echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."'</script>";
?>