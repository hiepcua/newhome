<div class="module <?php echo $r['class'];?>">
	<?php 
	require_once("libs/cls.category.php");
	if(!isset($objcon)) $objcon = new CLS_CONTENTS();
	if(!isset($objcat)) $objcat = new CLS_CATEGORY();
	$catid='';
	if($r['category_id']>0) $catid = $r['category_id'];
	$cat_name = $objcat->getNameById($catid);
	$objcat->getList(" AND par_id=$catid "," ORDER BY `order` ASC,id ASC ",''); ?>
	<div class="col-md-4 col-xs-12 left">
		<div class="main-title"><span><i class="fa fa-angle-double-right"></i>
			<?php echo $cat_name;?></span>
		</div>
		<ul>
		<?php 
		while ($item = $objcat->Fetch_Assoc()) {
			$title = stripslashes($item["name"]);
			$link = ROOTHOST.$item["code"];
			echo '<li><a href="'.$link.'">'.$title.'</a></li>';
		} ?>
		</ul>
	</div>
	<div class="col-md-8 col-xs-12 right">
		<?php $order = "ORDER BY pin DESC,ishot DESC,`order` ASC, id DESC";
		$limit = "LIMIT 0,5"; 
		if($r['category_id']>0) $catid = $r['category_id']."','".$objcat->getCatIDChild('',$r['category_id']);
		if($catid!='')
			$objcon->getList(" AND category_id IN ('$catid') "," $order "," $limit ");
		else $objcon->getList(""," $order "," $limit ");
		$arr_con= array();
		while ($item_r = $objcon->Fetch_Assoc()) $arr_con[]=$item_r;  
		if($objcon->Num_rows()>0) {
			$item = $arr_con[0]; 
			$title = stripslashes($item["title"]);
			$cdate = date("d/m/Y H:i A",strtotime($item['cdate']));
			$imgs = getThumb($item['thumb'],'img-responsive',$title);
			$cat_name = $objcat->getNameById($item['category_id']);
			$link = ROOTHOST.Un_unicode($cat_name).'/'.$item['code'].'.html';?>
		<div class="col-md-7 col-xs-12 thumb"><?php echo $imgs;?></div>
		<div class="col-md-5 col-xs-12 content">
			<h4><a href="<?php echo $link;?>" class="title"><?php echo $title;?></a></h4>
			<div class="pull-right"><i><small><?php echo $cdate;?></small></i></div>
		</div><div class="clearfix"></div>
		<ul><?php $i=0; foreach($arr_con as $item) { 
			$i++;
			if($i==1)continue;
			$cdate = date("d/m/Y",strtotime($item['cdate']));
			$title = stripslashes($item["title"]);
			$cat_name = $objcat->getNameById($item['category_id']);
			$link = ROOTHOST.Un_unicode($cat_name).'/'.$item['code'].'.html';
			echo "<li><a href='$link' title='$title'> <i class='fa fa-dot-circle-o'></i> $title </a> <i><small>($cdate)</small></i></li>";
			} ?>
		</ul>
		<?php } ?>
	</div>
</div>