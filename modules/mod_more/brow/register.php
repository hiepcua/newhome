<?php
$objmysql = new CLS_MYSQL();
?>
<aside class="aside aside-register">
	<h3 class="aside-title"><i class="fa fa-circle" aria-hidden="true"></i><span>ĐĂNG KÝ NHẬN TIN</span></h3>
	<div class="content">
		<form id="frm-register" method="post" action="<?php echo ROOTHOST; ?>register">
			<div class="form-group">
				<input type="text" name="txt_name" class="form-control" placeholder="Họ và tên (*Bắt buộc)" required>
			</div>
			<div class="form-group">
				<input type="email" name="txt_email" class="form-control" placeholder="Email (*Bắt buộc)" required>
			</div>
			<div class="text-center">
				<input type="submit" name="save_register" class="btn btn-register" value="ĐĂNG KÝ NGAY">
			</div>
		</form>
	</div>
</aside>