<?php
$objmysql 	= new CLS_MYSQL();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file='';

$title =''; $desc=''; $key='';$email_contact=''; $nickyahoo=''; $nameyahoo='';
$footer=''; $contact=''; $banner=''; $gallery=''; $logo='';

if(isset($_POST['web_title']) && $_POST['web_title']!='') {
	var_dump($_POST);
	exit();

	$CompanyName 	= isset($_POST['company_name']) ? addslashes($_POST['company_name']) : '';
	$Title 			= isset($_POST['web_title']) ? addslashes($_POST['web_title']) : '';
	$Meta_descript 	= isset($_POST['web_desc']) ? addslashes($_POST['web_desc']) : '';
	$Meta_keyword 	= isset($_POST['web_keywords']) ? addslashes($_POST['web_keywords']) : '';
	$Email 			= isset($_POST['email_contact']) ? addslashes($_POST['email_contact']) : '';
	$Address 		= isset($_POST['address']) ? addslashes($_POST['address']) : '';
	$Phone 			= isset($_POST['txtphone']) ? addslashes($_POST['txtphone']) : '';
	$Tel 			= isset($_POST['txttel']) ? addslashes($_POST['txttel']) : '';
	$Fax 			= isset($_POST['txtfax']) ? addslashes($_POST['txtfax']) : '';
	$Twitter 		= isset($_POST['txttwitter']) ? addslashes($_POST['txttwitter']) : '';
	$Gplus 			= isset($_POST['txtgplus']) ? addslashes($_POST['txtgplus']) : '';
	$Facebook 		= isset($_POST['txtfacebook']) ? addslashes($_POST['txtfacebook']) : '';
	$Youtube 		= isset($_POST['txtyoutube']) ? addslashes($_POST['txtyoutube']) : '';
	$Work_time 		= isset($_POST['txt_work_time']) ? addslashes($_POST['txt_work_time']) : '';


	// $Notification	= isset($_POST['time_notification']) ? (int)$_POST['time_notification'] : '';
	$Gg_analytic	= isset($_POST['gg_analytic']) ? htmlspecialchars($_POST['gg_analytic']) : '';
	$Script_header	= isset($_POST['script_header']) ? htmlspecialchars($_POST['script_header']) : '';
	$Script_footer	= isset($_POST['script_footer']) ? htmlspecialchars($_POST['script_footer']) : '';
	$Images 		= isset($_POST['txt_thumb2']) ? addslashes($_POST['txt_thumb2']) : '';



	

	if(isset($_FILES['txt_thumb']) && $_FILES['txt_thumb']['size'] > 0){
		$save_path 	= "../images/";
		$obj_upload->setPath($save_path);
		$file = ROOTHOST_WEB.'images/'.$obj_upload->UploadFile("txt_thumb", $save_path);
	}else{
		$file = $Images;
	}

	$sql = "UPDATE tbl_configsite SET ";
	$sql .="title='".$Title."',";
	$sql .="company_name='".$CompanyName."',";
	$sql .="phone='".$Phone."',";
	$sql .="tel='".$Tel."',";
	$sql .="fax='".$Fax."',";
	$sql .="email='".$Email."',";
	$sql .="address='".$Address."',";
	$sql .="work_time='".$Work_time."',";
	$sql .="meta_keyword='".$Meta_keyword."',";
	$sql .="twitter='".$Twitter."',";
	$sql .="gplus='".$Gplus."',";
	$sql .="facebook='".$Facebook."',";
	$sql .="youtube='".$Youtube."',";
	$sql .="image='".$file."',";
	$sql .="gg_analytic='".$Gg_analytic."',";
	$sql .="script_header='".$Script_header."',";
	$sql .="script_footer='".$Script_footer."',";
	// $sql .="notification='".$Notification."',";
	$sql .="meta_descript='".$Meta_descript."' WHERE config_id=1";
	$result = $objmysql->Query($sql);
	if($result) $_SESSION['flash'.'com_'.COMS] = 1;
	else $_SESSION['flash'.'com_'.COMS] = 0;
}

$sql="SELECT * FROM `tbl_configsite` WHERE `config_id`=1";
$objmysql->Query($sql);

if($objmysql->Num_rows()<=0) {
	echo 'Dữ liệu trống.';
}else{
	$row = $objmysql->Fetch_Assoc();
	$title          = stripslashes($row['title']);
	$company_name   = stripslashes($row['company_name']);
	$desc           = stripslashes($row['meta_descript']);
	$key            = stripslashes($row['meta_keyword']);
	$email_contact  = stripslashes($row['email']);
	$address        = stripslashes($row['address']);
	$phone          = stripslashes($row['phone']);
	$tel            = stripslashes($row['tel']);
	$fax            = stripslashes($row['fax']);
	$facebook       = stripslashes($row['facebook']);
	$youtube        = stripslashes($row['youtube']);
	$gplus          = stripslashes($row['gplus']);
	$twitter        = stripslashes($row['twitter']);
	$work_time      = stripslashes($row['work_time']);
	// $notification   = (int)$row['notification'];
	$image   		= stripslashes($row['image']);
	$gg_analytic   	= json_decode(addslashes($row['gg_analytic']));
	$script_header  = json_decode(addslashes($row['script_header']));
	$script_footer  = json_decode(addslashes($row['script_footer']));
}
unset($objmysql);

// <script>(function(d, s, id) {
// var js, fjs = d.getElementsByTagName(s)[0];
// if (d.getElementById(id)) return;
// js = d.createElement(s); js.id = id;
// js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
// fjs.parentNode.insertBefore(js, fjs);
// }(document, 'script', 'facebook-jssdk'));</script>
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Cấu hình website</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item active">System configuration</li>
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
			<div class="wrap_tab_column">
				<div class="tab_column_control">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Website config</a>
						<a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Contact info</a>
						<!-- <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Set time notify</a> -->
						<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Social</a>
						<a class="nav-link" id="v-pills-script-tab" data-toggle="pill" href="#v-pills-script" role="tab" aria-controls="v-pills-script" aria-selected="false">Mã script</a>
					</div>
				</div>
				<div class="tab_column_container card">
					<form name="frm_action" id="frm_action" action="" method="post" enctype="multipart/form-data">
						<div class="tab-content" id="v-pills-tabContent">
							<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
								<div class="row">
									<div class="col-md-9">
										<div class="form-group">
											<label class="col-sm-3 col-md-2 control-label">Name<font color="red"><font color="red">*</font></font></label>
											<div class="col-md-12">
												<input type="text" name="web_title" class="form-control" id="web_title" value="<?php echo $title;?>" placeholder="">
												<div id="txt_name_err" class="mes-error"></div>
											</div>
											<div class="clearfix"></div>
										</div>
										<!-- <div class="form-group">
											<label class="col-sm-3 col-md-2 control-label">Tên công ty</label>
											<div class="col-md-12">
												<input type="text" name="company_name" class="form-control" value="<?php echo $company_name;?>" placeholder="">
											</div>
											<div class="clearfix"></div>
										</div> -->
										<div class="form-group">
											<label class="col-sm-3 col-md-2 control-label">Meta Description<font color="red"><font color="red">*</font></font></label>
											<div class="col-md-12">
												<input type="text" name="web_desc" class="form-control" id="web_desc" value="<?php echo $desc;?>" placeholder="">
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 col-md-2 control-label">Meta keys<font color="red">*</font></label>
											<div class="col-md-12">
												<input type="text" name="web_keywords" class="form-control" id="web_keywords" value="<?php echo $key;?>" placeholder="">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="col-md-3">
										<div class='form-group'>
											<div class="widget-fileupload fileupload fileupload-new" data-provides="fileupload">
												<label>Ảnh đại diện</label><small> (Dung lượng < 10MB)</small>
												<div class="widget-avatar mb-2">
													<div class="fileupload-new thumbnail">
														<?php
														if(strlen($row['image'])>0){
															echo '<img src="'.$row['image'].'" id="img_image_preview">';
														}else{
															echo '<img src="'.ROOTHOST.'global/img/no-photo.jpg" id="img_image_preview">';
														}
														?>
													</div>
													<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
													<input type="hidden" name="txt_thumb2" value="<?php echo $row['image'];?>">
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
							</div>

							<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Email contact<font color="red">*</font></label>
											<div>
												<input type="text" name="email_contact" class="form-control" id="email_contact" value="<?php echo $email_contact;?>" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Phone number</label>
											<div>
												<input type="text" name="txtphone" class="form-control" id="txtphone" value="<?php echo $phone;?>" placeholder="">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Tel number</label>
											<div>
												<input type="text" name="txttel" class="form-control" id="txttel" value="<?php echo $tel;?>" placeholder="Tel number">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Fax</label>
											<div>
												<input type="text" name="txtfax" class="form-control" id="txtfax" value="<?php echo $fax;?>" placeholder="Fax">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Working hours</label>
											<div>
												<input type="text" name="txt_work_time" class="form-control" value="<?php echo $work_time;?>" placeholder="Working hours">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-3 col-md-2 control-label">Address</label>
											<div class="col-md-12">
												<input type="text" name="address" class="form-control" id="address" value="<?php echo $address;?>" placeholder="Address">
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
								<div>Set how many minutes before the meeting starts to automatically send emails, and notify users.</div><hr size="1" style="margin:10px 0 20px;">
								<div class="row form-group">
									<div class="col-md-6">
										<label class="control-label">Notification</label>
										<input type="number" min="0" name="time_notification" class="form-control" id="time_notification" value="<?php echo $notification;?>" placeholder="Số phút">
									</div>
								</div>
							</div> -->

							<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
								<div>Social setting</div><hr size="1" style="margin:10px 0 20px;">
								<div class="row form-group">
									<div class="col-md-6">
										<label class="control-label">Facebook</label>
										<input type="text" name="txtfacebook" class="form-control" id="txtfacebook" value="<?php echo $facebook;?>" placeholder="Facebook link">
									</div>
									<div class="col-md-6">
										<label class="control-label">G+</label>
										<input type="text" name="txtgplus" class="form-control" id="txtgplus" value="<?php echo $gplus;?>"placeholder="G+ link">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-6">
										<label class="control-label">Twitter</label>
										<input type="text" name="txttwitter" class="form-control" id="txttwitter" value="<?php echo $twitter;?>" placeholder="Twitter link">
									</div>
									<div class="col-md-6">
										<label class="control-label">Youtube</label>
										<input type="text" name="txtyoutube" class="form-control" id="txtyoutube" value="<?php echo $youtube;?>" placeholder="Youtube link">
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="v-pills-script" role="tabpanel" aria-labelledby="v-pills-messages-tab">
								<div class="form-group">
									<div class="col-md-12">
										<label class="control-label">Google Analytic</label>
										<textarea name="gg_analytic" class="form-control" id="gg_analytic"><?php echo $gg_analytic;?></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<label class="control-label">Script Header</label>
										<textarea name="script_header" class="form-control" id="script_header"><?php echo $script_header;?></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12">
										<label class="control-label">Script Footer</label>
										<textarea name="script_footer" class="form-control" id="script_footer"><?php echo $script_footer;?></textarea>
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
	</div>
</section>
<script type="text/javascript">
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				var img = document.createElement("img");
				img.src = e.target.result;
				// Hidden fileupload new
				$('.fileupload').removeClass('fileupload-new');
				$('.fileupload').addClass('fileupload-exists');
				$('.fileupload-preview').html(img);
			}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	$("#file_image").on('change', function(){
		readURL(this);
	});

	function cancel_fileupload(){
		$('.fileupload').removeClass('fileupload-exists');
		$('.fileupload').addClass('fileupload-new');
		$('.fileupload-preview').empty();
		$("#file_image").val('');
	}
</script>
<!-- /.row -->
<!-- /.content-header -->