<?php
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file='';
$GetID = isset($_GET['id']) ? (int)$_GET["id"] : 0;
$number = SysCount('tbl_feedback', " AND id=".$GetID);
if($number == 0){
	echo 'Không có dữ liệu.'; 
	return;
}

if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
	$Email 			= isset($_POST['txt_email']) ? addslashes($_POST['txt_email']) : '';
	$Name 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Comment 		= isset($_POST['txt_comment']) ? addslashes($_POST['txt_comment']) : '';
	$Career 		= isset($_POST['txt_career']) ? addslashes($_POST['txt_career']) : '';
	$Images 		= isset($_POST['txt_thumb2']) ? addslashes($_POST['txt_thumb2']) : '';

	if(isset($_FILES['txt_thumb']) && $_FILES['txt_thumb']['size'] > 0){
		$save_path 	= "../medias/images/";
		$obj_upload->setPath($save_path);
		$file = ROOTHOST_WEB.'medias/images/'.$obj_upload->UploadFile("txt_thumb", $save_path);
	}else{
		$file = $Images;
	}

	$arr=array();
	$arr['name'] = $Name;
	$arr['email'] = $Email;
	$arr['comment'] = $Comment;
	$arr['career'] = $Career;
	$arr['avatar'] = $file;
	
	$result = SysEdit('tbl_feedback', $arr, " id=".$GetID);

	if($result) $_SESSION['flash'.'com_'.COMS] = 1;
	else $_SESSION['flash'.'com_'.COMS] = 0;
}

$res_Feed = SysGetList('tbl_feedback', array(), ' AND id='. $GetID);
if(count($res_Feed) <= 0){
	echo 'Không có dữ liệu.'; 
	return;
}
$row = $res_Feed[0];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Cập nhật feedback</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách feedback</a></li>
					<li class="breadcrumb-item active">Cập nhật feedback</li>
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
				$msg->success('Cập nhật thành công.');
				echo $msg->display();
			}else if($_SESSION['flash'.'com_'.COMS] == 0){
				$msg->error('Có lỗi trong quá trình cập nhật.');
				echo $msg->display();
			}
			unset($_SESSION['flash'.'com_'.COMS]);
		}
		?>
		<div id='action'>
			<div class="card">
				<form name="frm_action" id="frm_action" action="" method="post" enctype="multipart/form-data">
					<div class="mess"></div>
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<label>Email address<font color="red">*</font></label>
								<input type="text" id="txt_email" name="txt_email" class="form-control" value="<?php echo $row['email'];?>" placeholder="Email address">
							</div>

							<div class="form-group">
								<label>Tên<font color="red">*</font></label>
								<input type="text" id="txt_name" name="txt_name" class="form-control" value="<?php echo $row['name'];?>" placeholder="Tên khách hàng">
							</div>

							<div class="form-group">
								<label>Chức danh<font color="red">*</font></label>
								<input type="text" id="txt_career" name="txt_career" class="form-control" value="<?php echo $row['career'];?>" placeholder="Chức danh">
							</div>

							<div class="form-group">
								<label>Comment</label>
								<textarea class="form-control" name="txt_comment" placeholder="Nội dung..." rows="2"><?php echo $row['comment'];?></textarea>
							</div>
						</div>

						<div class="col-md-3">
							<div class='form-group'>
								<div class="widget-fileupload fileupload fileupload-new" data-provides="fileupload">
									<label>Ảnh đại diện</label><small> (Dung lượng < 10MB)</small>
									<div class="widget-avatar mb-2">
										<div class="fileupload-new thumbnail">
											<?php
											if(strlen($row['avatar'])>0){
												echo '<img src="'.$row['avatar'].'" id="img_image_preview">';
											}else{
												echo '<img src="'.ROOTHOST.'global/img/no-photo.jpg" id="img_image_preview">';
											}
											?>
										</div>
										<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
										<input type="hidden" name="txt_thumb2" value="<?php echo $row['avatar'];?>">
									</div>
									<div class="control">
										<span class="btn btn-file">
											<span class="fileupload-new">Tải lên</span>
											<span class="fileupload-exists">Thay đổi</span>
											<input type="file" id="file_image" name="txt_thumb" accept="image/jpg, image/jpeg">
										</span>
										<a href="javascript:void(0)" class="btn fileupload-exists" data-dismiss="fileupload" onclick="cancel_fileupload()">Hủy</a>
									</div>
								</div>
							</div>
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