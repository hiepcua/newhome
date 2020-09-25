<?php 
require_once(LIB_PATH."cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATEGORY();
$catid='';
if($r['category_id']>0) $catid = $r['category_id'];
$cat_name = $objcat->getNameById($catid);
?>
<div class="module <?php echo $r['class'];?>">
	<h2 class="main-title"><span><?php echo $cat_name;?></span></h2>
	<div class="row">
	<?php 
	$order = "ORDER BY `order` ASC, id ASC";
	$limit = "LIMIT 0,5"; 
	if($catid!='')
		$objcon->getList(" AND category_id IN ('$catid') "," $order "," $limit ");
	else $objcon->getList(""," $order "," $limit ");
	while ($item = $objcon->Fetch_Assoc()) {
		$title = stripslashes($item["title"]);
		$imgs = getThumb($item['thumb'],'img-responsive',$title);
		$cat_code = Un_unicode($objcat->getNameById($item["category_id"]));
		$link = ROOTHOST.$cat_code.'/'.stripslashes($item["code"]).'.html';
		echo '<div class="item col-md-3 col-xs-6">
			<a href="'.$link.'"><div class="thumb">'.$imgs.'</div>
			<div class="title" title="'.$title.'">'.$title.'</div></a></div>';
	} ?>
	</div>
</div>