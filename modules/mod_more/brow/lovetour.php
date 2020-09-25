<aside class="row">
	<div class="col-lg-12 col-md-6">
		<!-- tour special-->
		<div class="heading-flex sidebar-title">
			<div class="title h4">Tour <span>nổi bật</span></div>
		</div>
		<aside class="tour-special">
			<?php
			$objmysql = new CLS_MYSQL();
			$sql="SELECT * FROM tbl_tour WHERE isactive = 1 AND ishot=1 ORDER BY `order` ASC LIMIT 0, 5";
			$objmysql->Query($sql);
			while ($row = $objmysql->Fetch_Assoc()) {
				$link = ROOTHOST.'tour/'.$row['code'];
				$name = stripcslashes($row['name']);
				$number_of_holes = (int)$row['number_of_holes'];
				$days = stripcslashes($row['days']);
				$images = json_decode($row['images']);
				$thumb = getThumb($images[0]->url, 'img-responsive', $name);
				?>
				<div class="item">
					<div class="card card-1 rounded-bottom mb-col">
						<a class="card-link effect-more" href="<?php echo $link; ?>">
							<?php echo $thumb; ?>
							<div class="extra rounded-bottom">
								<span class="availability">Số chỗ: <?php echo $number_of_holes; ?></span>
								<span class="timer"><?php echo $days; ?></span>
							</div>
							<?php if((int)$row['price1'] !== 0 && (int)$row['price2'] !== 0){ ?>
								<span class="sale-off"><?php echo round((($row['price1'] - $row['price2'])/$row['price1'])*100); ?>%</span>
							<?php } ?>
							<span class="btn btn-info" href="http://dulichdanko.com/tour/chuong-trinh-xem-bong-da-vong-loai-wc-2020">Chi tiết</span>
						</a>

						<div class="card-body">

							<h5 class="cart-title">
								<a href="<?php echo $link; ?>" title="<?php echo $name; ?>"><?php echo $name; ?></a>
							</h5>
							<?php if($row['departure'] !== 0){ ?>
								<div class="card-text">Khởi hành: <?php echo date('d/m/Y', $row['departure']); ?></div>
							<?php }else{ ?>
								<div class="card-text">Khởi hành: Hàng ngày</div>
							<?php } ?>

							<?php if((int)$row['price1'] !== 0){ 
								if((int)$row['price2'] !== 0){
									?>
									<div class="item-price">
										<span class="new-price"><?php echo number_format($row['price2']); ?> đ</span><span class="old-price"><?php echo number_format($row['price1']); ?> đ</span>
									</div>
								<?php }else{
									?>
									<div class="item-price">
										<span class="new-price"><?php echo number_format($row['price1']); ?> đ</span>
									</div>
									<?php
								}
							}else{ ?>
								<div>Liên hệ</div>
							<?php } ?>

						</div>

					</div>
				</div>
				<?php
			}
			?>
		</aside>
	</div>
</aside>
<script type="text/javascript">
	$('.tour-special').slick({
		dots: true,
		prevArrow: false,
		nextArrow: false,
		slidesToShow: 1,
		accessibility: false,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: 'linear',
		autoplay: true,
		autoplaySpeed: 2000,
	});
</script>