<?php
$objmysql = new CLS_MYSQL();
?>
<section class="section sec-service-type">
	<div class="container">
		<h2 class="sec-title">CÁC LĨNH VỰC NGÀNH NGHỀ CHÚNG TÔI CÓ THỂ DỊCH</h2>
		<div class="row">
			<?php
			$sql = "SELECT * FROM tbl_service WHERE isactive = 1 ORDER BY `order` ASC";
			$objmysql->Query($sql);
			while ($row = $objmysql->Fetch_Assoc()) {
				$thumb 	= getThumb($row['thumb'], '', 'img-responsive');
				$link 	= ROOTHOST.'dich-vu/'.$row['code'].'.html';
				echo '<div class="col-md-3 col-sm-6 item">
				<div class="wrap-thumb">'.$thumb.'</div>
				<div class="content">
				<h3 class="title"><a href="'.$link.'" target="_blank" title="'.$row['name'].'">'.$row['name'].'</a></h3>
				<div class="description">'.$row['sapo'].'<br/>'.$row['sapo_en'].'</div>
				<a href="'.$link.'" title="'.$row['name'].'" target="_blank" class="view-detail">Xem chi tiết</a>
				</div>
				</div>';
			}
			?>
		</div>
		<div class="wrap-button text-center"><a href="<?php echo ROOTHOST; ?>order" target="_blank" title="Đặt dịch vụ" class="btn btn-view-detail">ĐẶT DỊCH VỤ</a></div>
	</div>
</section>