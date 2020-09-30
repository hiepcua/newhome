<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];

	$sql="DELETE FROM `tbl_album` WHERE `id` in ('$id')";
	$objmysql->Exec('BEGIN');
	$result=$objmysql->Exec($sql);

	$sql2="DELETE FROM `tbl_gallery` WHERE `album_id` in ('$id')";
	$result1=$objmysql->Exec($sql2);

	if($result && $result1 ){
		$objmysql->Exec('COMMIT');
	}else {
		$objmysql->Exec('ROLLBACK');
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
?>