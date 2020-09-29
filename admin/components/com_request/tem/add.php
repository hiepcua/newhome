<?php
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
	$Email 			= isset($_POST['txt_email']) ? addslashes($_POST['txt_email']) : '';
	$Name 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Comment 		= isset($_POST['txt_comment']) ? addslashes($_POST['txt_comment']) : '';
	$Career 		= isset($_POST['txt_career']) ? addslashes($_POST['txt_career']) : '';

	$arr=array();
	$arr['name'] = $Name;
	$arr['email'] = $Email;
	$arr['comment'] = $Comment;
	$arr['career'] = $Career;
	$arr['cdate'] = time();

	$result = SysAdd('tbl_request', $arr);
	if($result){
		$_SESSION['flash'.'com_'.COMS] = 1;
	}else{
		$_SESSION['flash'.'com_'.COMS] = 0;
	}
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Thêm mới yêu cầu người dùng</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Yêu cầu người dùng</a></li>
					<li class="breadcrumb-item active">Thêm mới yêu cầu người dùng</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<?php
		if (isset($_SESSION['flash'.'com_'.COMS])) {
			if($_SESSION['flash'.'com_'.COMS] == 1){
				$msg->success('Thêm mới thành công.');
				echo $msg->display();
			}else if($_SESSION['flash'.'com_'.COMS] == 0){
				$msg->error('Có lỗi trong quá trình thêm mới.');
				echo $msg->display();
			}
			unset($_SESSION['flash'.'com_'.COMS]);
		}
		?>
		<div id='action'>
			<div class="card">
				<form name="frm_action" id="frm_action" action="" method="post" enctype="multipart/form-data">
					<div class="mess"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Email address<font color="red">*</font></label>
							<input type="text" id="txt_email" name="txt_email" class="form-control" value="" placeholder="Email address">
						</div>

						<div class="form-group">
							<label>Tên<font color="red">*</font></label>
							<input type="text" id="txt_name" name="txt_name" class="form-control" value="" placeholder="Tên khách hàng">
						</div>

						<div class="form-group">
							<label>Công ty/Đơn vị<font color="red">*</font></label>
							<input type="text" id="txt_career" name="txt_career" class="form-control" value="" placeholder="Tên công ty/đơn vị">
						</div>

						<div class="form-group">
							<label>Comment</label>
							<textarea class="form-control" name="txt_comment" placeholder="Nội dung..." rows="2"></textarea>
						</div>
					</div>
					
					<div class="text-center toolbar">
						<input type="submit" name="cmdsave_tab1" id="cmdsave_tab1" class="save btn btn-success" value="Lưu thông tin" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- /.row -->
<!-- /.content-header -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#frm_action').submit(function(){
			return validForm();
		})
	});

	function validForm(){
		var flag = true;
		var title = $('#txt_name').val();

		if(title==''){
			alert('Các mục đánh dấu * không được để trống');
			flag = false;
		}
		return flag;
	}
</script>