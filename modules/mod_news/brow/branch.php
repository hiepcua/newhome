<?php 
require_once(LIB_PATH."cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATEGORY();
$order = "ORDER BY pin DESC,ishot DESC,`order` ASC, id DESC";
if($r['category_id']>0) $catid = $r['category_id']."','".$objcat->getCatIDChild('',$r['category_id']);
if($catid!='')
	$objcon->getList(" AND category_id IN ('$catid') "," $order "," ");
else $objcon->getList(""," $order "," ");
$arr_con= array();
while ($item_r = $objcon->Fetch_Assoc()) $arr_con[]=$item_r; 
?>
<div class="row"><div id="block-3" class="owl-carousel owl-theme">
<?php $i=0; $cat_name='';
foreach($arr_con as $item) { 
	$cdate = date("d/m/Y",strtotime($item['cdate']));
	$title = stripslashes($item["title"]);
	$intro = stripslashes($item["intro"]);
	$imgs = getThumb($item['thumb'],'img-responsive',$title);
	$cat_name = $objcat->getNameById($item['category_id']);
	$link = ROOTHOST.Un_unicode($cat_name).'/'.$item['code'].'.html';
	echo '<div class="item">
		<a href="'.$link.'"><div class="thumb">'.$imgs.'</div>
		<div class="title" title="'.$title.'">'.$title.'</div></a>
		<div class="intro">'.$intro.'</div>
		<a href="'.$link.'" class="readmore">Xem thêm <i class="fa fa-arrow-right"></i></a>
		</div>';
} ?>
</div>
<div class="clearfix text-center">
	<a href="<?php echo ROOTHOST.Un_unicode($cat_name);?>" class="viewall">Xem tất cả dịch vụ</a>
</div>
</div>