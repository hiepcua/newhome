<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','MODULE');

$strWhere="";
$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';
$get_position = isset($_GET['s']) ? antiData($_GET['s']) : '';
$action = isset($_GET['cbo_action']) ? antiData($_GET['cbo_action']) : '';
/*Gán strWhere*/
if($get_q!=''){
	$flg_search = 1;
	$strWhere.=" AND title LIKE '%".$get_q."%'";
}
if($get_position!=''){
	$strWhere.=" AND position='".$get_position."'";
}
if($action!='' && $action!='all'){
	$strWhere.=" AND isactive='".$action."'";
}

/*Begin pagging*/
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$total_rows=SysCount('tbl_categories',$strWhere);
$max_rows = 20;

if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
}
$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
/*End pagging*/
?>
<script language="javascript">
	function checkinput(){
		var strids=document.getElementById('txtids');
		if(strids.value==''){
			alert('Bạn chưa chọn đối tượng nào');
			return false;
		}
		return true;
	}
</script>

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Danh sách module</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item active">Danh sách module</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="widget-frm-search">
			<form id='frm_search' method='get' action=''>
				<div class='row'>
					<div class='col-sm-3'>
						<div class='form-group'>
							<input type='text' id='txt_title' name='q' class='form-control' value="<?php echo $get_q;?>" placeholder="Tên module..." />
						</div>
					</div>
					<div class='col-sm-2'>
						<div class='form-group'>
							<select name="cbo_action" class="form-control" id="cbo_action">
	                            <option value="all">Tất cả</option>
	                            <option value="1">Hiển thị</option>
	                            <option value="0">Ẩn</option>
	                            <script language="javascript">
	                            	$(document).ready(function(){
										cbo_Selected('cbo_action','<?php echo $action;?>');
									});
	                            </script>
	                        </select>
						</div>
					</div>
					<div class='col-sm-2'>
						<div class='form-group'>
							<select class="form-control" name="s" id="cbo_position">
								<option value="">-- Select position --</option>
								<?php
								$res_positions = SysGetList('tbl_position', []);
								foreach ($res_positions as $key => $value) {
									echo '<option value="'.$value['name'].'">'.$value['name'].'</option>';
								}
								?>
							</select>
							<script type="text/javascript">
								$(document).ready(function(){
									cbo_Selected('cbo_position', "<?php echo $get_position;?>");
								});
							</script>
						</div>
					</div>
					<div class="col-sm-1"><input type="submit" name="" class="btn btn-primary" value="Tìm kiếm"></div>
					<div class="col-sm-2"></div>
					<div class="col-sm-2">
						<a href="<?php echo ROOTHOST.COMS;?>/add" class="btn btn-primary float-sm-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm mới</a>
					</div>
				</div>
			</form>
		</div>

		<table class="table table-bordered">
			<tr class="header">
				<th width="30" align="center">STT</th>
				<th class="th-delete">Xóa</th>
				<th align="center">Tiêu đề</th>
				<th width="75" align="center">Kiểu</th>
				<th>Giao diện</th>
				<th width="75" align="center">Vị trí</th>
				<th class="th-display">Hiển thị</th>
				<th class="th-edit">Sửa</th>
			</tr>
			<?php
			$i = 0;
			$start = ($cur_page-1) * 20;
			$res_modules = SysGetList('tbl_modules', [], $strWhere." ORDER BY `position` ASC, `order` ASC LIMIT ".$start.",20");
			foreach ($res_modules as $key => $rows) {
				$ids = $rows['id'];
				if($rows['isactive'] == 1) 
					$icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
				else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';
				?>
				<tr>
					<td align='center'><?php echo $key+1;?></td>
					<td align='center' width='10'><a href='<?php echo ROOTHOST.COMS;?>/delete/<?php echo $rows["id"];?>' onclick='return confirm("Bạn có chắc muốn xóa?")'><i class='fa fa-trash cred' aria-hidden='true'></i></a></td>
					<td><?php echo stripslashes($rows['title']);?></td>
					<td align='center'><?php echo $rows['type'];?></td>
					<td><?php echo $rows['theme'];?></td>
					<td align='center'><?php echo $rows['position'];?></td>

					<td align='center' width='10'><a href='<?php echo ROOTHOST.COMS.'/active/'.$ids;?>'><?php echo $icon_active; ?></a></td>

					<td align='center' width='10'><a href='<?php echo ROOTHOST.COMS.'/edit/'.$ids;?>'><i class='fa fa-edit' aria-hidden='true'></i></a></td>
				</tr>
				<?php } ?>
		</table>

		<nav class="d-flex justify-content-center">
			<?php 
			paging($total_rows,20,$cur_page);
			?>
		</nav>
	</div>
</section>
<?php //----------------------------------------------?>