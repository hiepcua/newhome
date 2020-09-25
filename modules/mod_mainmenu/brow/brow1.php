<?php 
include_once('global/libs/gfconfig.php');
include_once('libs/cls.menuitem.php');
$objmenuitem=new CLS_MENUITEM;
$mnuid=isset($r['menu_id'])?$r['menu_id']:0;
// full url
$scheme=isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']."://":'';
$redirect = isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:'';
$fullurl=$scheme.$_SERVER['SERVER_NAME'].$redirect; 
echo $objmenuitem->ListMenuItem($mnuid,0,0,$fullurl);
unset($objmenuitem);
?>