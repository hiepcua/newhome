<?php
$cate_id = $r['category_id'];
$res_cates = SysGetList('tbl_categories', [], "AND id=".$r['category_id']);
$cate_link = ROOTHOST.$res_cates[0]['alias'];
?>
<div class="wg-wrap">
	<div class="wg-head"><span><?php echo $res_cates[0]['title'];?></span></div>
	<div class="wg-content">
		<div class="custom-row row">
			<?php
			$res_cate_news = SysGetList('tbl_content', [], "AND cat_id=".$cate_id." AND status=4 ORDER BY `cdate` DESC LIMIT 0,4");
			foreach ($res_cate_news as $key => $value) {
				$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
				$title = $value['title'];
				$thumb = getThumb('', 'img-fluid', $title);

				if($key<=1){
					echo '<div class="custom-col col-md-6">
					<div class="wg-item">
					<div class="wrap-thumb" data-src="'.$value['images'].'">
					<a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
					</div>
					<h2 class="wg-item-title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h2>
					</div>
					</div>';
				}else{
					echo '<div class="custom-col col-md-6 pt-3">
					<div class="wg-item">
					<div class="wrap-thumb"  data-src="'.$value['images'].'">
					<a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
					</div>
					<h2 class="wg-item-title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h2>
					</div>
					</div>';
				}
			}
			?>
		</div>

		<a href="<?php echo $cate_link;?>" title="Xem thêm" class="view-more">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</div>
</div>