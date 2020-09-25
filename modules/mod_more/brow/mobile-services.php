<?php
$objmysql = new CLS_MYSQL();
?>
<section class="section sec-service-type">
	<div class="container">
		<h2 class="sec-title">CÁC LĨNH VỰC NGÀNH NGHỀ CHÚNG TÔI CÓ THỂ DỊCH</h2>
		<div id="mobile-slide-service" class="owl-carousel owl-theme">
			<?php
			$sql = "SELECT * FROM tbl_service WHERE isactive = 1 ORDER BY `order` ASC";
			$objmysql->Query($sql);
			while ($row = $objmysql->Fetch_Assoc()) {
				$thumb 	= getThumb($row['thumb'], '', 'img-responsive');
				$link 	= ROOTHOST.'dich-vu/'.$row['code'].'.html';
				echo '<div class="item">
				<div class="wrap-thumb">'.$thumb.'</div>
				<div class="content">
				<h3 class="title"><a href="'.$link.'" title="'.$row['name'].'">'.$row['name'].'</a></h3>
				<div class="description">'.$row['sapo'].'</div>
				<a href="'.$link.'" title="'.$row['sapo'].'" class="view-detail">Xem chi tiết</a>
				</div>
				</div>';
			}
			?>
		</div>
		<div class="wrap-button text-center"><a href="<?php echo ROOTHOST; ?>order" title="Đặt dịch vụ" class="btn btn-view-detail">ĐẶT DỊCH VỤ</a></div>
	</div>
</section>
<script type="text/javascript">
	$("#mobile-slide-service").owlCarousel({
		loop:true,
		margin:0,
		responsiveClass:true,
		responsive:{
			0:{
				items:1,
				nav:true
			},
			600:{
				items:1,
				nav:false
			},
			1000:{
				items:1,
				nav:true,
				loop:false
			}
		},
		navText: ["<img src='<?php echo ROOTHOST; ?>images/icons/arrow_left.png'>","<img src='<?php echo ROOTHOST; ?>images/icons/arrow_right.png'>"],
	});
</script>