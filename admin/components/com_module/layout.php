<?php
defined('ISHOME') or die("Can't access this page!");
define('COMS','module');
$user = getInfo('username');
$isAdmin = getInfo('isadmin');
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
$viewtype = isset($_GET['viewtype']) ? addslashes($_GET['viewtype']) : 'list';

if($isAdmin==1){
	function getListComboboxCategories($parid=0, $level=0, $childs=array()){
		$sql="SELECT * FROM tbl_categories WHERE `par_id`='$parid' AND `isactive`='1'";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$char.="|-----";
		}
		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$parid=$rows['par_id'];
			$title=$rows['title'];
			if(in_array($id, $childs)){
				echo "<option value='$id' disabled='true' class='disabled'>$char $title</option>";
			}else{
				echo "<option value='$id'>$char $title</option>";
			}
			$nextlevel=$level+1;
			getListComboboxCategories($id,$nextlevel, $childs, $siteid);
		}
	}
	
	if(is_file(COM_PATH.'com_'.COMS.'/tem/'.$viewtype.'.php')){
		include_once('tem/'.$viewtype.'.php');
	}
}else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}
unset($viewtype); unset($obj);
// if(isset($_POST['cmdsave'])){
// 	$Cate_ID 	= isset($_POST['cbo_cate']) ? (int)$_POST['cbo_cate'] : 0;
// 	$Place_ID 	= isset($_POST['cbo_place']) ? (int)$_POST['cbo_place'] : 0;
// 	$Con_ID 	= isset($_POST['cbo_content']) ? (int)$_POST['cbo_content'] : 0;
// 	$MnuID 		= isset($_POST['cbo_menutype']) ? (int)$_POST['cbo_menutype'] : 0;
// 	$ViewTitle	= isset($_POST['optviewtitle']) ? (int)$_POST['optviewtitle'] : 0;
// 	$isActive	= isset($_POST['optactive']) ? (int)$_POST['optactive'] : 0;

// 	$Title 		= isset($_POST['txttitle']) ? addslashes($_POST['txttitle']) : '';
// 	$Type 		= isset($_POST['cbo_type']) ? addslashes($_POST['cbo_type']) : '';
// 	$Theme 		= isset($_POST['cbo_theme']) ? addslashes($_POST['cbo_theme']) : '';
// 	$HTML 		= isset($_POST['txtcontent']) ? addslashes($_POST['txtcontent']) : '';
// 	$Position	= isset($_POST['cbo_position']) ? addslashes($_POST['cbo_position']) : '';
// 	$Class		= isset($_POST['txtclass']) ? addslashes($_POST['txtclass']) : '';
// 	$Intro		= isset($_POST['txtintro']) ? addslashes($_POST['txtintro']) : '';

// 	if(isset($_POST['txtid'])){
// 		$ID = (int)$_POST['txtid'];
// 		$sql="UPDATE `tbl_modules` SET 
// 		`type`='".$Type."',
// 		`title`='".$Title."',
// 		`intro`='".$Intro."',
// 		`content`='".$HTML."',
// 		`viewtitle`='".$ViewTitle."',
// 		`menu_id`='".$MnuID."',
// 		`category_id`='".$Cate_ID."',
// 		`place_id`='".$Place_ID."',
// 		`content_id`='".$Con_ID."',
// 		`theme`='".$Theme."',
// 		`position`='".$Position."',
// 		`class`='".$Class."',
// 		`isactive`='".$isActive."' 
// 		WHERE `id`='".$ID."'";
// 		$result = $objmysql->Exec($sql);
// 		if($result) $_SESSION['flash'.'com_'.COMS] = 1;
// 		else $_SESSION['flash'.'com_'.COMS] = 0;
// 	}else{
// 		$sql="INSERT INTO `tbl_modules` (`type`,`viewtitle`,`menu_id`,`place_id`,`category_id`,`content_id`,`theme`,`position`,`class`,`isactive`,`title`,`intro`,`content`) VALUES ('".$Type."','".$ViewTitle."','".$MnuID."','".$Place_ID."','".$Cate_ID."','".$Con_ID."','".$Theme."','".$Position."','".$Class."','".$isActive."','".$Title."','".$Intro."','".$HTML."')";
// 		$result = $objmysql->Exec($sql);
// 		if($result) $_SESSION['flash'.'com_'.COMS] = 1;
// 		else $_SESSION['flash'.'com_'.COMS] = 0;
// 	}
// }

// if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
// 	$ids=trim($_POST["txtids"]);
// 	if($ids!='')
// 		$ids = substr($ids,0,strlen($ids)-1);
// 	$ids=str_replace(",","','",$ids);
// 	switch ($_POST["txtaction"]){
// 		case "public": 
// 		$sql_active = "UPDATE `tbl_modules` SET `isactive`='1' WHERE `id` in ('$ids')";
// 		$objmysql->Exec($sql_active);
// 		break;
// 		case "unpublic":
// 		$sql_unactive = "UPDATE `tbl_modules` SET `isactive`='0' WHERE `id` in ('$ids')";
// 		$objmysql->Exec($sql_unactive);
// 		break;
// 		case "delete":
// 		$sql="DELETE FROM `tbl_modules` WHERE `id` in ('$ids')";
// 		$result=$objmysql->Exec($sql);

// 		case 'order':
// 		$sls = explode(',',$_POST['txtorders']); 
// 		$ids = explode(',',$_POST['txtids']);
// 		$n = count($ids);
// 		for($i=0;$i<$n;$i++){
// 			$sql_order = "UPDATE `tbl_modules` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
// 			$objmysql->Exec($sql_order);
// 		}
// 	}
// 	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
// }
?>