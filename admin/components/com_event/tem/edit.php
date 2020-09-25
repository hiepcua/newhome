<?php
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file=$strWhere='';
$GetID = isset($_GET['id']) ? (int)$_GET["id"] : 0;

$user 		= getInfo('username');
$isAdmin 	= getInfo('isadmin');
if($isAdmin) $strWhere.=' AND id='. $GetID;
else $strWhere.=' AND `author`="'.$user.'" AND id='. $GetID;

function convertYoutube($string) {
	return preg_replace(
		"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
		"https://www.youtube.com/embed/$2",
		$string
	);
}

if(isset($_POST['txt_name']) && $_POST['txt_name']!=='') {
	$Title 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Sapo 			= isset($_POST['txt_sapo']) ? addslashes($_POST['txt_sapo']) : '';
	$Cate 			= isset($_POST['cbo_cate']) ? (int)$_POST['cbo_cate'] : 0;
	$Images 		= isset($_POST['txt_thumb2']) ? addslashes($_POST['txt_thumb2']) : '';
	$Fulltext 		= isset($_POST['txt_fulltext']) ? addslashes($_POST['txt_fulltext']) : '';
	$seo_link 		= isset($_POST['txt_seo_link']) ? addslashes($_POST['txt_seo_link']) : '';
	$Youtube 		= isset($_POST['txt_link_youtube']) ? $_POST['txt_link_youtube'] : '';
	$Sdate 			= isset($_POST['txt_sdate']) ? strtotime($_POST['txt_sdate']) : '';

	if(isset($_FILES['txt_thumb']) && $_FILES['txt_thumb']['size'] > 0){
		$save_path 	= "../medias/events/";
		$obj_upload->setPath($save_path);
		$file = ROOTHOST_WEB.'medias/events/'.$obj_upload->UploadFile("txt_thumb", $save_path);
	}else{
		$file = $Images;
	}

	if($Youtube != ''){
		$Youtube = convertYoutube($Youtube);
	}

	$arr=array();
	$arr['title'] = $Title;
	$arr['alias'] = un_unicode($Title);
	$arr['sapo'] = $Sapo;
	$arr['fulltext'] = $Fulltext;
	$arr['cat_id'] = $Cate;
	$arr['images'] = $file;
	$arr['mdate'] = time();
	$arr['stime'] = $Sdate;
	$arr['link_youtube'] = $Youtube;

	$result = SysEdit('tbl_events', $arr, " id=".$GetID);

	$arr2=array();
	$arr2['title'] = $arr['title'];
	$arr2['link'] = ROOTHOST_WEB.'su-kien-'.$arr['alias'].'-'.$GetID;
	$arr2['image'] = $file;
	$arr2['meta_title'] = $arr['title'];
	$arr2['meta_key'] = $arr['title'];
	$arr2['meta_desc'] = $arr['sapo'];

	SysEdit('tbl_seo', $arr2, 'link="'.$seo_link.'"');

	if($result) $_SESSION['flash'.'com_'.COMS] = 1;
	else $_SESSION['flash'.'com_'.COMS] = 0;
}

$res_Cons = SysGetList('tbl_events', array(), $strWhere);
if(count($res_Cons) <= 0){
	echo 'Không có dữ liệu.'; 
	return;
}
$row = $res_Cons[0];

$seo_link = ROOTHOST_WEB.'su-kien-'.$row['alias'].'-'.$row['id'];
$res_seos = SysGetList('tbl_seo', [], "AND `link`='".$seo_link."'");
$meta_title = $meta_key = $meta_desc = '';
if(count($res_seos)){
	$res_seo = $res_seos[0];
	$meta_title = $res_seo['meta_title'];
	$meta_key = $res_seo['meta_key'];
	$meta_desc = $res_seo['meta_desc'];
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Cập nhật sự kiện</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách sự kiện</a></li>
					<li class="breadcrumb-item active">Cập nhật sự kiện</li>
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
					<input type="hidden" name="txt_seo_link" value="<?php echo $seo_link;?>">
					<input type="hidden" name="txtid" value="<?php echo $GetID;?>">
					<div class="row">
						<div class="col-md-9">
							<div  class="form-group">
								<label>Tên sự kiện<font color="red"><font color="red">*</font></font></label>
								<input type="text" id="txt_name" name="txt_name" class="form-control" value="<?php echo $row['title']; ?>" placeholder="Tên sự kiện">
							</div>

							<div class="form-group">
								<label>Sapo</label>
								<textarea class="form-control" id="txt_sapo" name="txt_sapo" placeholder="Sapo..." rows="3"><?php echo $row['sapo']; ?></textarea>
							</div>
							
							<div class="form-group">
								<label>Nội dung</label>
								<textarea class="form-control" id="txt_fulltext" name="txt_fulltext" placeholder="Nội dung chính..." rows="5"><?php echo $row['fulltext']; ?></textarea>
							</div>

						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Nhóm sự kiện<font color="red">*</font></label>
								<select class="form-control" name="cbo_cate" id="cbo_cate">
									<option value="0">-- Chọn một --</option>
									<?php getListComboboxGEvent(0, 0); ?>
								</select>
								<script type="text/javascript">
									$(document).ready(function(){
										cbo_Selected('cbo_cate', <?php echo $row['cat_id']; ?>);
									});
								</script>
							</div>

							<div class="form-group">
								<label>Thời gian bắt đầu</label>
								<input type="datetime-local" name="txt_sdate" value="<?php echo date("Y-m-d\TH:i", $row['stime']); ?>" class="form-control">
							</div>

							<div class="form-group">
								<label>Link Youtube</label>
								<input type="text" name="txt_link_youtube" value="<?php echo $row['link_youtube'];?>" class="form-control">
							</div>

							<div class='form-group'>
								<div class="widget-fileupload fileupload fileupload-new" data-provides="fileupload">
									<label>Ảnh đại diện</label><small> (Dung lượng < 10MB)</small>
									<div class="widget-avatar mb-2">
										<div class="fileupload-new thumbnail">
											<?php
											if(strlen($row['images'])>0){
												echo '<img src="'.$row['images'].'" id="img_image_preview">';
											}else{
												echo '<img src="'.ROOTHOST.'global/img/no-photo.jpg" id="img_image_preview">';
											}
											?>
										</div>
										<div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
										<input type="hidden" name="txt_thumb2" value="<?php echo $row['images'];?>">
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
		// Hidden left sidebar
		$('#body').addClass('sidebar-collapse');
		$('#frm_action').submit(function(){
			return validForm();
		});

		tinymce.init({
			selector: '#txt_fulltext',
			height: 600,
			plugins: [
			'link image imagetools table lists autolink fullscreen media hr code'
			],
			image_title: true,
			automatic_uploads: true,
			toolbar: 'bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify |  numlist bullist | removeformat | insertfile image media link anchor codesample | outdent indent',
			contextmenu: 'link image imagetools table spellchecker lists',
			content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
			image_caption: true,
			images_reuse_filename: true,
			images_upload_credentials: true,
			relative_urls : false,
			remove_script_host : false,
			convert_urls : true,
            
            // override default upload handler to simulate successful upload
            images_upload_handler: function (blobInfo, success, failure) {
            	var xhr, formData;

            	xhr = new XMLHttpRequest();
            	xhr.withCredentials = false;
            	xhr.open('POST', '<?php echo ROOTHOST;?>ajaxs/upload.php');

            	xhr.onload = function() {
            		console.log(xhr.responseText);
            		var json;

            		if (xhr.status != 200) {
            			failure('HTTP Error: ' + xhr.status);
            			return;
            		}

            		json = JSON.parse(xhr.responseText);

            		if (!json || typeof json.location != 'string') {
            			failure('Invalid JSON: ' + xhr.responseText);
            			return;
            		}

            		success(json.location);
            	};

            	formData = new FormData();
            	formData.append('file', blobInfo.blob(), blobInfo.filename());
            	formData.append('folder', 'events/');
            	xhr.send(formData);
            },
        });
	});

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

	function validForm(){
		var flag = true;
		var title = $('#txt_name').val();
		var cate = parseInt($('#cbo_cate').val());

		if(title=='' || cate==0){
			alert('Các mục đánh dấu * không được để trống');
			flag = false;
		}
		return flag;
	}
</script>