<section class="sec-1 component">
	<div class="row custom-row">
		<div class="col-md-3 custom-col order-md-1 order-2">
			<?php $tmp->loadModule('box1') ;?>
		</div>

		<div class="col-md-6 custom-col order-md-2 order-1">
			<?php
			$res_contents = SysGetList('tbl_content', [], "AND ishot=1 AND status=4 AND is_trash <> 1 ORDER BY `order` ASC, cdate DESC LIMIT 0,4");
			$n_res_contents = count($res_contents);
			?>
			<div class="wg-cate wg-big-cate">
				<div class="wg-wrap">
					<div class="wg-head"><span>Tin chủ nhật vàng</span></div>
					<div class="wg-content">
						<?php
						if($n_res_contents > 0){
							$res_con = $res_contents[0];
							$link = ROOTHOST.$res_con['alias'].'-'.$res_con['id'].'.html';
							$title = $res_con['title'];
							$thumb = getThumb('', '', $title);

							echo '<div class="wg-item big">
							<div class="i-wrap-thumb" data-src="'.$res_con['images'].'">
							<a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
							</div>
							<h1 class="wg-item-title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h1>
							</div>';
						}
						if($n_res_contents >= 1){
							foreach ($res_contents as $key => $value) {
								$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
								$title = $value['title'];
								$thumb = getThumb('', '', $title);
								$sapo = Substring($value['sapo'], 0, 30);

								if($key > 0){
									echo '<div class="wg-item">
									<div class="i-wrap-thumb" data-src="'.$value['images'].'">
									<a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
									</div>
									<div class="wg-item-info">
									<h2 class="wg-item-title"><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h2>
									<p class="desc">'.$sapo.'</p>
									</div>
									</div>';
								}
							}
						}
						?>
						
						<!-- <a href="" title="" class="view-more">Xem thêm <i class="fa fa-angle-double-right" aria-hidden="true"></i></a> -->
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3 custom-col order-md-3 order-3">
			<div class="wg-ads wg-cate">
				<div class="wg-wrap">
					<div class="wg-head"><span>Quảng cáo</span></div>
					<?php $tmp->loadModule('ads3') ;?>
					<?php $tmp->loadModule('ads4') ;?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="sec-2">
	<div class="row custom-row">
		<div class="col-md-3 custom-col">
			<?php $tmp->loadModule('box2') ;?>
		</div>

		<div class="col-md-6 custom-col">
			<div class="wg-cate wg-cate-3">
				<?php $tmp->loadModule('box3') ;?>
			</div>
		</div>

		<div class="col-md-3 custom-col">
			<div class="wg-cate">
				<?php $tmp->loadModule('box4') ;?>
			</div>
		</div>
	</div>
</section>

<section class="sec-3">
	<div class="row custom-row">
		<div class="col-md-3 custom-col">
			<div class="wg-cate">
				<?php $tmp->loadModule('box5') ;?>
			</div>
		</div>

		<div class="col-md-6 custom-col">
			<div class="wg-cate wg-cate-3">
				<?php $tmp->loadModule('box6') ;?>
			</div>
		</div>

		<div class="col-md-3 custom-col">
			<div class="wg-cate">
				<?php $tmp->loadModule('box7') ;?>
			</div>
		</div>
	</div>
</section>