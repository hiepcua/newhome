<?php
defined('ISHOME') or die("Can't access this page!");
define('COMS','event_group');
$viewtype='list';

if(isset($_GET['viewtype'])){
	$viewtype=addslashes($_GET['viewtype']);
}

function getListComboboxGEvent($parid=0, $level=0, $childs=array()){
	$sql="SELECT * FROM tbl_event_group WHERE `par_id`='$parid' AND `isactive`='1'";
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
		getListComboboxGEvent($id,$nextlevel, $childs, $siteid);
	}
}

$isAdmin=getInfo('isadmin');
if($isAdmin==1){
	if(is_file(COM_PATH.'com_'.COMS.'/tem/'.$viewtype.'.php'))
		include_once('tem/'.$viewtype.'.php');	
	unset($viewtype); unset($obj);
}else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}
?>