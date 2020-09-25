<?php 
include_once('global/libs/gfconfig.php');
include_once('libs/cls.menuitem.php');
$objmenuitem=new CLS_MENUITEM;
$mnuid=isset($r['menu_id'])?$r['menu_id']:0;
$objmenuitem->getList(" WHERE `menu_id` = ". $mnuid);
$str = '';

if($objmenuitem->Num_rows()>0) {
	$str.= '<ul>';
	while ($res = $objmenuitem->Fetch_Assoc()) {
		$str.= '<li><a href="'.$res['link'].'" title="'.$res['name'].'">'.$res['name'].'</a></li>';
	}
	$str.= '</ul>';
	echo $str;
}

unset($objmenuitem);
?>