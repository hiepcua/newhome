<?php
define('OBJ_PAGE','ALBUM');
$strWhere="";
$GetID = isset($_GET['id']) ? (int)$_GET["id"] : 0;
$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';

/*Gán strWhere*/
if($get_q!=''){
	$flg_search = 1;
	$strWhere.=" AND title LIKE '%".$get_q."%'";
}

/*Begin pagging*/
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$total_rows=SysCount('tbl_album',$strWhere);
$max_rows = 20;

if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
}
$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
/*End pagging*/

$res_albums = SysGetList('tbl_album', array(), ' AND id='. $GetID);
if(count($res_albums) <= 0){
	echo 'Không có dữ liệu.'; 
	return;
}
$row = $res_albums[0];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"><?php echo $row['title'];?></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST.'album';?>">Danh sách album</a></li>
					<li class="breadcrumb-item active">Danh sách ảnh <?php echo $row['title'];?></li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class='container-fluid'>
		<div class="widget-frm-search">
			<form id='frm_search' method='get' action=''>
				<div class='row'>
					<div class='col-sm-3'>
						<div class='form-group'>
							<input type='text' id='txt_title' name='q' value="<?php echo $get_q;?>" class='form-control' placeholder="Tên..." />
						</div>
					</div>
					<div class="col-sm-7"></div>
					<div class="col-sm-2">
						<span class="btn btn-upload_images btn-primary float-sm-right">
							<i class="fa fa-upload" aria-hidden="true"></i>Upload ảnh
							<input type="file" id="upload_images" name="upload_images" multiple accept="image/x-png,image/gif,image/jpeg">
						</span>
					</div>
				</div>
			</form>
		</div>
		<div class="card">
			<div class="gallery-images">
				<div class="grid">
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
					<div class="w-14">
						<div class="wr-item">
							<div class="wrap-img">
								<img src="http://localhost/newhome/medias/albums/222.jpg" class="img">
							</div>
							<div class="wr-tool">
								<span class="bt bt-select"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
								<span class="bt bt-edit"><i class="fas fa-edit"></i></span>
								<span class="bt bt-dropdown"><i class="fa fa-times" aria-hidden="true"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<nav class="d-flex justify-content-center"><?php paging($total_rows,$max_rows,$cur_page);?></nav>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		// Hidden left sidebar
		$('#body').addClass('sidebar-collapse');

		$('.gallery-images .bt').on('click', function(){
			
		});
	})
</script>