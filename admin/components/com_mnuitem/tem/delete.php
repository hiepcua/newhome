<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['mnuid'])){
		$mnuid=(int)$_GET['mnuid'];
	}
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];

	SysDel('tbl_mnuitems', "id=". $id);
	echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS.'/'.$mnuid."'</script>";
?>