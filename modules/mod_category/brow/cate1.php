<div class="wg-cate">
	<div class="wg-wrap">
		<?php
		$cate_id = $r['category_id'];
		$res_cates = SysGetList('tbl_categories', [], "AND id=".$r['category_id']);
		$cate_link = ROOTHOST.$res_cates[0]['alias'];
		?>
		<div class="wg-head"><span><?php echo $res_cates[0]['title'];?></span></div>
		<div class="wg-content">
			<?php
			$res_cate_news = SysGetList('tbl_content', [], "AND cat_id=".$cate_id." AND status=4 ORDER BY `cdate` DESC LIMIT 0,5");
			foreach ($res_cate_news as $key => $value) {
				$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
				$title = $value['title'];
				$thumb = getThumb('', '', $title);
				
				if($key==0){
					echo '<div class="wg-item big">
					<div class="wrap-thumb" data-src="'.$value['images'].'">
					<a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
					</div>
					<h2 class="wg-item-title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h2>
					</div>';
				}else{
					echo '<div class="wg-item">
					<h3 class="wg-item-title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h3>
					</div>';
				}
			}
			?>
			<a href="<?php echo $cate_link;?>" title="Xem thêm" class="view-more">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
		</div>
	</div>
</div>