<?php 
require_once("libs/cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATEGORY();
?>
<div class="module <?php echo $r['class'];?>">
	<?php if($r['viewtitle']==1){ ?>
	<div class="main-title"><span>
		<i class="fa fa-calendar"></i> <?php echo $r['title'];?>
	</span></div>
	<?php }
	$catid='';
	$order = "ORDER BY pin DESC,ishot DESC,`order` ASC, id DESC";
	$limit = "LIMIT 0,1"; 
	if($r['category_id']>0) $catid = $r['category_id']."','".$objcat->getCatIDChild('',$r['category_id']);
	if($catid!='')
		$objcon->getList(" AND category_id IN ('$catid') "," $order "," $limit ");
	else $objcon->getList(""," $order "," $limit ");
	if($objcon->Num_rows()>0) {
		$item = $objcon->Fetch_Assoc();
		$title = stripslashes($item["title"]);
		$intro = Substring(stripslashes($item["intro"]),0,45);
		$imgs = getThumb($item['thumb'],'img-responsive',$title);
		$date=date('d/m/Y',strtotime($item["cdate"]));
		$cat_name = $objcat->getNameById($item['category_id']);
		$link = ROOTHOST.Un_unicode($cat_name).'/'.stripslashes($item["code"]).'.html';
		echo '<a href="'.$link.'" title="'.$title.'">'.$imgs.'</a>';
		echo '<h4 class="title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h4>';
		echo '<div class="intro"><small>'.$intro.'</small></div>';
	} ?>
</div>