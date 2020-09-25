<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['user'])){
		$username=$_GET['user'];
	}
	SysDel('tbl_users', "username='". $username."'");
	echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."'</script>";
?>