<?php 
require_once("libs/cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATEGORY();
?>
<div class="module <?php echo $r['class'];?>">
<?php 
$catid='';
$order = "ORDER BY pin DESC,ishot DESC,`order` ASC, id DESC";
$limit = "LIMIT 0,8"; 
if($r['category_id']>0) $catid = $r['category_id']."','".$objcat->getCatIDChild('',$r['category_id']);
if($catid!='')
	$objcon->getList(" AND category_id IN ('$catid') "," $order "," $limit ");
else $objcon->getList(""," $order "," $limit ");
$arr_con= array();
while ($item_r = $objcon->Fetch_Assoc()) $arr_con[]=$item_r;?>
	<div class='col-md-8 specical'><div class="row">
		<?php 
		$item = $arr_con[0];
		$title = stripslashes($item["title"]);
		$intro = Substring(stripslashes($item["intro"]),0,50);
		$imgs = getThumb($item['thumb'],'img-responsive',$title);
		$date=date('d/m/Y',strtotime($item["cdate"]));
		$info_cate = $objcat->getInfo(" AND id=".$item['category_id']);
		$link = ROOTHOST.$info_cate['code'].'/'.stripslashes($item["code"]).'.html';
		echo '<div class="thumb"><a href="'.$link.'" title="'.$title.'">'.$imgs.'</a>';
		echo '<div class="box">';
			echo '<div class="title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></div>';
			echo '<div class="row"><div class="col-xs-8 text-left">';
			echo '<blockquote><a href="'.ROOTHOST.$info_cate['code'].'">'.$info_cate['name'].'</a></blockquote>';
			echo '</div>';
			echo '<div class="col-xs-4 text-right date"><i>'.$date.'</i></div></div>';
		echo '</div></div>';
		echo '<div class="intro">'.$intro.'</div>';
		?>
	</div></div>
	<div class='col-md-4 list'>
		<?php if($r['viewtitle']==1){ ?>
		<div class="main-title">
			<i class="fa fa fa-bullhorn fa-lg fa-fw fa-fw"></i> 
			<?php echo $r['title'];?>
		</div><?php } ?>
		<ul>
		<?php $i=0;
		foreach($arr_con as $item_r) {
			$i++;
			if($i==1) continue;
			$title = stripslashes($item_r["title"]);
			$imgs = getThumb($item_r['thumb'],'img-responsive',$title);
			$date=date('d/m/Y',strtotime($item_r["mdate"]));
			$info_cate = $objcat->getInfo(" AND id=".$item_r['category_id']);
			$link = ROOTHOST.$info_cate['code'].'/'.stripslashes($item_r["code"]).'.html';

			echo '<li><a href="'.$link.'" title="'.$title.'"><i class="fa fa-dot-circle-o"></i> '.$title.'</a></li>';
		} ?></ul>
	</div>
</div>