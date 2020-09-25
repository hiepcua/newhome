<div class="module <?php echo $r['class'];?>">
	<?php if($r['viewtitle']==1){ $cls='main-title'; ?>
	<div class="<?php echo $cls;?>"><?php echo $r['title'];?>
		<i class="fa fa-angle-double-right"></i>
	</div>
	<?php } ?>
	
	<marquee onMouseOver="this.stop()" onMouseOut="this.start()"><?php 
	require_once("libs/cls.category.php");
	if(!isset($objcon)) $objcon = new CLS_CONTENTS();
	if(!isset($objcat)) $objcat = new CLS_CATEGORY();
	$catid='';
	$order = "ORDER BY a.ishot DESC,a.`order` ASC, a.id DESC";
	$limit = "LIMIT 0,10"; 
	if($r['category_id']>0) $catid = $r['category_id']."','".$objcat->getCatIDChild('',$r['category_id']);
	if($catid!=''){
		$objcon->getLink(" AND a.category_id IN ('$catid') "," $order "," $limit ");
	}else{
		$objcon->getLink(""," $order "," $limit ");
	}
	$num = $objcon->Num_rows();$i=0;
	while ($item_r = $objcon->Fetch_Assoc()) {
		$i++;
		$title = stripslashes($item_r["title"]);
		$link = ROOTHOST.$item_r["cat_code"].'/'.stripslashes($item_r["code"]).'.html';
		echo '<a href="'.$link.'" title="'.$title.'">'.$title.'</a>';
		if($i<$num) echo " - "; 
	} ?></marquee>
</div>