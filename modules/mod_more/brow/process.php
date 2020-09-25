<?php
$objmysql = new CLS_MYSQL();
?>
<section class="section sec-process">
	<div class="container">
		<h2 class="sec-title">QUY TRÌNH THỰC HIỆN</h2>
		<form method="get" action="<?php echo ROOTHOST; ?>order">
			<?php
			$sql3 = "SELECT * FROM tbl_languages WHERE isactive = 1 AND `default` = 1";
			$objmysql->Query($sql3);
			$row3 = $objmysql->Fetch_Assoc();
			echo '<input type="hidden" id="lang_df" data-name="'.$row3['name'].'" value="'.$row3['id'].'">';
			?>
			<div class="row">
				<div class="vertical-line"></div>
				<div class="hozirontal-line"></div>
				<div class="col-md-3 col-sm-3 process-item process1">
					<div class="header">
						<span class="number"><b>1</b></span>
						<div>Chọn ngôn ngữ</div>
					</div>
					<div class="content">
						<div id="lang_from">
							<span>Dịch từ:</span>
							<select class="form-control" name="from" onchange="change_trans_from(this)" required>
								<option value="">-- Chọn một ngôn ngữ --</option>
								<?php
								$sql="SELECT * FROM tbl_languages WHERE isactive = 1 ORDER BY `order` ASC";
								$objmysql->Query($sql);
								while ($row = $objmysql->Fetch_Assoc()) {
									echo '<option value="'.$row['id'].'">'.$row['name'].'('.$row['iso'].')</option>';
								}
								?>
							</select>
						</div>
						<div class="text-center"><img src="<?php echo ROOTHOST; ?>images/icons/arrow-down.png" class="arrow-down img-responsive"></div>
						<div id="lang_to">
							<span>Sang:</span>
							<select id="cbo_to" class="form-control" name="to" required>
								<option value="">-- Chọn ngôn ngữ --</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 process-item process2">
					<div class="header">
						<span class="number"><b>2</b></span>
						<div>Chọn lĩnh vực</div>
					</div>
					<div class="content">
						<?php
						$sql="SELECT * FROM tbl_service_type WHERE isactive = 1 ORDER BY `order` ASC";
						$objmysql->Query($sql);
						while ($row = $objmysql->Fetch_Assoc()) {
							echo '<div class="item">';
							echo '<img src="'.$row['icon'].'" data-toggle="tooltip" title="'.$row['name'].'" class="img-responsive">';
							echo '</div>';
						}
						?>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 process-item process3">
					<div class="header">
						<span class="number"><b>3</b></span>
						<div>Chọn thông tin chi tiết</div>
					</div>
					<div class="content">
						<div id="cout_page">
							<span>Số trang cần dịch:</span>
							<input type="number" name="numpage" min="1" class="form-control" required>
						</div>
						<div class="text-center"><img src="<?php echo ROOTHOST; ?>images/icons/arrow-down.png" class="arrow-down img-responsive"></div>
						<div id="cout_page">
							<span>Thời gian hoàn thành:</span>
							<select class="form-control" name="time">
								<option value="0">Bình thường</option>
								<option value="1">Gấp</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 process-item">
					<div class="header">
						<span class="number"><b>4</b></span>
						<div>Bắt đầu dịch</div>
					</div>
				</div>
			</div>
			<div class="text-center">
				<input type="submit" class="btn-basic" value="BẮT ĐẦU DỊCH NGAY">
			</div>
		</form>

		<div class="formats">
			<?php $this->loadModule('box5') ?>
		</div>
	</div>
</section>
<script type="text/javascript">
	function change_trans_from(attr){
		var id = attr.value;
		var lang_df = $('#lang_df').val();

		$.ajax({
			url : '<?php echo ROOTHOST.'ajaxs/get_language_to.php' ?>',
			type : 'POST',
			data : {
				'id' : id,
				'lang_df' : lang_df,
			},
			success: function (res) {
				$('#cbo_to').empty();
				$('#cbo_to').html(res);
			}
		})
	}
</script>