<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_user.php');
require_once(libs_path.'cls.mysql.php');
if(isLogin()){
	$thisUser = getInfo('username');
	$isAdmin = getInfo('isadmin');
	$domain = antiData($_POST['domain']);
	$site_id = antiData($_POST['site_id']) ? antiData($_POST['site_id']) : 0;

	if($domain!=='' && $isAdmin==1){
		if($site_id == 0){
			$number = SysCount('tbl_sites', "AND domain='".$domain."'");
		}else{
			$number = SysCount('tbl_sites', "AND domain='".$domain."' AND id <>".$site_id);
		}
		
		if($number > 0){
			die("1");
		}else{
			die("0");
		}
	}else{ die("System don't see data");}

}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>