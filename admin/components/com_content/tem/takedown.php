<?php
define('OBJ_PAGE','CONTENT');
// Init variables
$user=getInfo('username');
$isAdmin=getInfo('isadmin');

if($isAdmin){
	$strWhere="AND status=5";
}else{
	$strWhere="AND status=5 AND author='".$user."'";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);

	if($_POST["txtaction"] == "delete"){
		$res_cons = SysGetList('tbl_content', [], "AND id in ('".$ids."')");

		foreach ($res_cons as $key => $value) {
			$seo_link = ROOTHOST_WEB.$value['alias'].'-'.$value['id'].'.html';
			$Cres_seos = SysCount('tbl_seo', "AND `link`='".$seo_link."'");
			SysDel('tbl_content', "id in ('".$ids."')");
			if($Cres_seos > 0){
				SysDel('tbl_seo', "link='".$seo_link."'");
			}
		}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."/takedown?status=5'</script>";
}

if($isAdmin==1){
	$strWhere.="";
}else{
	$strWhere.=" AND `author`='".$user."'";
}

$get_s = isset($_GET['s']) ? antiData($_GET['s']) : '';
$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';
$get_cate = isset($_GET['cate']) ? (int)antiData($_GET['cate']) : 0;

/*Gán strWhere*/
if($get_s!=''){
	$strWhere.=" AND status =".$get_s;
}
if($get_q!=''){
	$strWhere.=" AND title LIKE '%".$get_q."%'";
}
if($get_cate!=0){
	$strWhere.=" AND cat_id=".$get_cate;
}

/*Begin pagging*/
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$total_rows=SysCount('tbl_content',$strWhere);
$max_rows = 15;

if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
}
$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
/*End pagging*/
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Danh sách bài viết bị gỡ xuống</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách bài viết</a></li>
					<li class="breadcrumb-item active">Danh sách bài viết bị gỡ xuống</li>
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
				<input type='hidden' id='txt_status' name='s' value='' />
				<div class='row'>
					<div class='col-sm-3'>
						<div class='form-group'>
							<input type='text' id='txt_title' name='q' value="<?php echo $get_q;?>" class='form-control' placeholder="Tiêu đề..." />
						</div>
					</div>
					<div class='col-sm-3'>
						<div class='form-group'>
							<select class="form-control" name="cate" id="cbo_cate">
								<option value="">-- Chuyên mục --</option>
								<?php getListComboboxCategories(0,0); ?>
							</select>
							<script type="text/javascript">
								$(document).ready(function(){
									cbo_Selected('cbo_cate', <?php echo $get_cate; ?>);
								});
							</script>
						</div>
					</div>
					<div class="col-sm-1"><input type="submit" name="" class="btn btn-primary" value="Tìm kiếm"></div>
					<div class='col-sm-2'></div>
					<div class="col-sm-3">
						<a href="<?php echo ROOTHOST.COMS;?>/add" class="btn btn-primary float-sm-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm mới</a>
						<a class="delete btn btn-danger float-sm-right" href="#" style="margin-right: 10px;" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_actions','delete'); }" title="Xóa"><i class="fa fa-times-circle" aria-hidden="true"></i> Xóa</a>
					</div>
				</div>
			</form>
			<form id="frm_actions" method="post" action="">
				<input type="hidden" name="txtaction" id="txtaction"/>
				<input type="hidden" name="txtids" id="txtids" />
			</form>
		</div>
		<div class="card">
			<div class='table-responsive'>
				<table class="table table-bordered">
					<thead>                  
						<tr>
							<th style="width: 10px">#</th>
							<th width="30" class="text-center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);"/></th>
							<th>Tiêu đề</th>
							<th colspan="2" width="120px">Hành động</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($total_rows>0){
							$star = ($cur_page - 1) * $max_rows;
							$strWhere.=" ORDER BY cdate DESC LIMIT $star,".$max_rows;
							$obj=SysGetList('tbl_content',array(), $strWhere, false);
							$stt=0;
							while($r=$obj->Fetch_Assoc()){
								$stt++;
								$ids = $r['id'];
								$cates = SysGetList('tbl_categories', array('title'), ' AND id='.$r['cat_id']);
								$cate = count($cates)>0 ? $cates[0] : [];
								$cate_title = isset($cate['title']) ? $cate['title'] : '<i>N/A</i>';
								if($r['status'] == 4) 
									$icon_active    = "<i class='fas fa-toggle-on cgreen'></i>";
								else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

								$thumbnail = getThumb($r['images'], 'thumbnail', '');
								?>
								<tr>
									<td width='30' align='center' class="td-actions"><span class="action mt-3" style="border:0px"><?php echo $stt + $star;?></span></td>

									<td width='30' align='center' class="td-actions">
										<label class="action mt-3" style="border:0px"><input type='checkbox' name='chk' id='chk' onclick="docheckonce('chk');" value='<?php echo $ids;?>'/></label>
									</td>

									<td>
										<div class="widget-td-title">
											<div class="widget-thumbnail"><?php echo $thumbnail;?></div>
											<div class="widget-title">
												<?php echo Substring($r['title'], 0, 20);?>
												<div class="widget-list-info">
													<ul class="list-unstyle">
														<li><a href="" target="_blank"><?php echo $cate_title;?></a></li>
														<span class="td-public-time"><?php echo date('H:i | d-m-Y', $r['cdate']);?></span>
													</ul>
												</div>
											</div>
										</div>
									</td>
									
									<td class="text-center td-actions">
										<a class="action mt-3" href='<?php echo ROOTHOST.COMS."/delete/".$r['id'];?>' onclick='return confirm("Bạn có chắc muốn xóa?")'><i class='fa fa-trash cred' aria-hidden='true'></i></a>

										<a class="action mt-3" href="<?php echo ROOTHOST.COMS.'/edit/'.$r['id'];?>"><i class="fas fa-edit cblue"></i></a>
									</td>
								</tr>
							<?php }
						}else{
							?>
							<tr>
								<td colspan='6' class='text-center'>Dữ liệu trống!</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
		<nav class="d-flex justify-content-center">
			<?php 
			paging($total_rows,$max_rows,$cur_page);
			?>
		</nav>
	</div>
</section>
<script type="text/javascript">
	function checkinput(){
		var strids=document.getElementById("txtids");
		if(strids.value==""){
			alert('Bạn chưa lựa chọn đối tượng nào.');
			return false;
		}
		return true;
	}
</script>