<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];

	$res_cons = SysGetList('tbl_content', [], "AND id=". $id);
	$seo_link = ROOTHOST_WEB.$res_cons[0]['alias'].'-'.$res_cons[0]['id'].'.html';
	$Cres_seos = SysCount('tbl_seo', "AND `link`='".$seo_link."'");

	SysDel('tbl_content', "id=". $id);
	if($Cres_seos > 0){
		SysDel('tbl_seo', "link='".$seo_link."'");
	}
	
	echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."'</script>";
?>