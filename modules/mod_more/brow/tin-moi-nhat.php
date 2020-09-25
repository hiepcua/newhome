<div class="wg-cate">
	<div class="wg-wrap">
		<div class="wg-head"><span>Tin mới nhất</span></div>
		<div class="wg-content">
			<?php
			$res_lastest_news = SysGetList('tbl_content', [], "AND status=4 ORDER BY `cdate` DESC LIMIT 0,7");
			foreach ($res_lastest_news as $key => $value) {
				$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
				$title = $value['title'];
				$thumb = getThumb('', '', $title);
				if($key<=1){
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
			<!-- <a href="" title="" class="view-more">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a> -->
		</div>
	</div>
</div>