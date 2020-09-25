<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];

	$res_cates = SysGetList('tbl_categories', [], "AND id=". $id);
	if(count($res_cates)>0){
		$seo_link = ROOTHOST_WEB.$res_cates[0]['alias'];
		$res_seos = SysGetList('tbl_seo', [], "AND `link`='".$seo_link."'");

		SysDel('tbl_categories', "id=". $id);
		if(count($res_seos)>0){
			SysDel('tbl_seo', "link='".$res_seos[0]['link']."'");
		}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."'</script>";
?>