<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['id']))
		$id=$_GET['id'];
	$obj->setHot($id);
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
?>