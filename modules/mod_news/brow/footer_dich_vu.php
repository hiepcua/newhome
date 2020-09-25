<?php 
require_once("libs/cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATEGORY();
?>
<div class="module <?php echo $r['class'];?>">
	<?php
	$catid = $str = '';
	$order = "ORDER BY title ASC";
	$limit = "LIMIT 0,1"; 
	if($r['category_id'] > 0){
		$res_category = $objcat->getInfo(" AND id = " . $r['category_id']);
		$objcon->getList(" AND category_id = " . $r['category_id']," $order ");
	}

	if($objcon->Num_rows()>0) {
		$str.= '<div class="title">'.$res_category['name'].'</div>';
		$str.= '<div class="dlab-separator-outer m-b10"><div class="dlab-separator style-skew"></div></div>';
		$str.= '<ul class="service_menu">';
		while ($item = $objcon->Fetch_Assoc()) {
			$title = stripslashes($item["title"]);
			$code = stripslashes($item["code"]);
			$link = ROOTHOST.Un_unicode($res_category['name']).'/'.stripslashes($item["code"]).'.html';

			$str.= '<li><i class="fa fa-angle-right" aria-hidden="true"></i><a href="'.$link.'" title="'.$title.'">'.$title.'</a></li>';
		}
		$str.= '</ul>';
	}

	echo $str;
	?>
</div>