<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','gallery');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
$isAdmin = getInfo('isadmin');
$objmysql 	= new CLS_MYSQL();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

$task='';
if(isset($_GET['task'])) $task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
if($isAdmin){
	include_once(THIS_COM_PATH.'task/'.$task.'.php');
}else{
	echo "404 not found!";
	exit();
}
unset($obj); unset($task);	unset($objmysql); unset($ids);
// if(isset($_POST["cmdsave"])){
// 	$Name 		= addslashes(htmlentities($_POST['txt_name']));
// 	$Thumb 		= addslashes($_POST['txtthumb']);
// 	$Intro 		= addslashes(htmlentities($_POST['txt_intro']));
// 	$Code 		= un_unicode($_POST['txt_name']);
// 	$Cdate 		= date('Y-m-d H:i:s');

//     if(isset($_POST['txtid'])){
// 		$ID = $_POST['txtid'];
// 		$sql = "UPDATE tbl_album SET `name`='".$Name."',`thumb`='".$Thumb."',`code`='".$Code."',`intro`='".$Intro."' WHERE id='".$ID."'";
// 		$objmysql->Exec($sql);
// 	}else{
//         $sql = "INSERT INTO `tbl_album`(`name`,`thumb`,`code`,`cdate`,`intro`,`isactive`) VALUES";
//         $sql.="('".$Name."', '".$Thumb."', '".$Code."','".$Cdate."','".$Intro."','1')";
//         echo $sql;
//         $objmysql->Exec($sql); 
//         $id = $objmysql->LastInsertID();

//         if($id !== ''){
//             echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."/add_gallery/".$id."'</script>";
//         }
// 	}
// 	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
// }

// if(isset($_POST["txtaction"]) && $_POST["txtaction"] !== ""){
// 	$ids = trim($_POST["txtids"]);
// 	if($ids !== '')
// 		$ids = substr($ids,0,strlen($ids)-1);
// 	$ids=str_replace(",","','",$ids);
// 	switch ($_POST["txtaction"]){
// 		case "public": 
// 			$sql_active = "UPDATE `tbl_album` SET `isactive`='1' WHERE `id` in ('$ids')";
// 			$objmysql->Exec($sql_active);
// 			break;
// 		case "unpublic":
// 			$sql_unactive = "UPDATE `tbl_album` SET `isactive`='0' WHERE `id` in ('$ids')";
// 			$objmysql->Exec($sql_unactive);
// 			break;
// 		case "delete":
// 	        $sql = "DELETE FROM `tbl_album` WHERE `id` in ('$ids')";
// 	        $objmysql->Exec('BEGIN');
// 	        $result=$objmysql->Exec($sql);

// 	        $sql = "DELETE FROM `tbl_gallery` WHERE `album_id` in ('$ids')";
// 	        $result1 = $objmysql->Exec($sql);

// 	        if($result && $result1 ){
// 	        	$objmysql->Exec('COMMIT');
// 	        }else {
// 	        	$objmysql->Exec('ROLLBACK');
// 	        }
// 	        break;
// 		case 'order':
// 			$sls = explode(',',$_POST['txtorders']); 
// 			$ids = explode(',',$_POST['txtids']);
// 			$n = count($ids);
// 			for($i=0;$i<$n;$i++){
// 				$sql_order = "UPDATE `tbl_album` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
// 				$objmysql->Exec($sql_order);
// 			}
// 			break;
// 		case "edit": 	
// 			$id = explode("','",$ids);
// 			echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."/edit/".$id[0]."'</script>";
// 			exit();
// 			break;
// 	}
// 	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
// }
?>