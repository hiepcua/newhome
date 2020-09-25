<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$objmysql = new CLS_MYSQL();
if(isset($_GET['user'])){
	$username=$_GET['user'];
}

$sql="UPDATE `tbl_users` SET `isactive`=if(`isactive`=1,0,1) WHERE `username`='".$username."'";
$objmysql->Exec($sql);
echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."'</script>";
?>