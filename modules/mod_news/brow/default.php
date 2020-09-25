<?php
require_once("libs/cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATEGORY();
$catid='';
if($r['category_id']>0) $catid = $r['category_id'];
$cat_name = $objcat->getNameById($catid);
$cat_code = Un_unicode($cat_name);
?>
<div class="module <?php echo $r['class'];?>">
	<?php if($r['viewtitle']==1){ ?>
	<div class="main-title"><a href="<?php echo ROOTHOST.$cat_code;?>" title="<?php echo $cat_name;?>">
		<i class="fa fa-angle-double-right"></i> <?php echo stripslashes($r['title']);?>
	</a></div>
	<?php }
	$order = " ORDER BY pin DESC,ishot DESC,`order` ASC, id DESC ";
	$limit = " LIMIT 0,5 "; 
	if($r['category_id']>0) $catid = $r['category_id']."','".$objcat->getCatIDChild('',$r['category_id']);
	if($catid!='')
		$objcon->getList(" AND category_id IN ('$catid') "," $order "," $limit ");
	else $objcon->getList(""," $order "," $limit "); ?>
	<ul class="news"><?php while ($item = $objcon->Fetch_Assoc()) { 
		$cdate = date("d/m/Y",strtotime($item['cdate']));
		$title = stripslashes($item["title"]);
		$cat_name = $objcat->getNameById($item['category_id']);
		$link = ROOTHOST.Un_unicode($cat_name).'/'.$item['code'].'.html';
		echo "<li><a href='$link' title='$title'>$title</a></li>";
		} ?>
	</ul>
</div>