<?php
$objmysql = new CLS_MYSQL();
$arr_contents = array();
$sql = "SELECT * FROM tbl_contents WHERE isactive = 1 AND ishot=1 ORDER BY `order` ASC LIMIT 0, 6";
$objmysql->Query($sql);
while ($row = $objmysql->Fetch_Assoc()) {
	$arr_contents[] = $row;
}
$c_arr_contents = count($arr_contents);
?>
<aside class="row">
	<div class="col-lg-12 col-md-6">
		<!-- blog-special-->
		<div class="blog-special">
			<div class="heading-flex sidebar-title">
				<div class="title h4">BÀI VIẾT NỔI BẬT</div>
			</div>
			<div class="bg-light">
				<?php
				if($c_arr_contents > 1){
					$title = stripcslashes($arr_contents[0]['title']);
					$link = ROOTHOST.'bai-viet/'.$arr_contents[0]['code'];
					$thumb = getThumb($arr_contents[0]['thumb'], 'img-responsive', $title);
					$intro = Substring($arr_contents[0]['intro'], 0, 20);
					?>
					<div class="special-main">
						<figure>
							<a href="<?php echo $link; ?>" title="<?php echo $title;?>"><?php echo $thumb;?></a>
						</figure>
						<h3><a href="<?php echo $link;?>" title="<?php echo $title;?>"><?php echo $title;?></a></h3>
						<div class="desc"><?php echo $intro;?></div>
					</div>
					<?php
				}
				?>
				<ul class="list-unstyled list-blog-special">
					<?php
					if($c_arr_contents > 2){
						foreach ($arr_contents as $key => $value) {
							if($key >= 1){
								$title = stripcslashes($value['title']);
								$link = ROOTHOST.'bai-viet/'.$value['code'];
								$thumb = getThumb($value['thumb'], 'img-responsive', $title);
								?>
								<li class="d-flex">
									<figure>
										<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $thumb; ?></a>
									</figure>
									<div class="text">
										<h4 class="dotdotdot" style="overflow-wrap: break-word;">
											<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
										</h4>
									</div>
								</li>
								<?php
							}
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</aside>