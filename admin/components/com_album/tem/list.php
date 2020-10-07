<?php
define('OBJ_PAGE','ALBUM');
// Init variables
$isAdmin=getInfo('isadmin');
if($isAdmin==1){
	$strWhere="";
	$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';
	$action = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';

	/*Gán strWhere*/
	if($get_q!=''){
		$flg_search = 1;
		$strWhere.=" AND title LIKE '%".$get_q."%'";
	}
	if($action !== '' && $action !== 'all' ){
	    $strWhere.=" AND `isactive` = '$action'";
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
	?>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Danh sách album</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
						<li class="breadcrumb-item active">Danh sách album</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<section class="content">
		<div class='container-fluid'>
			<div class="row widget-frm-search form-group">
				<div class="col-md-6">
					<form id="frm_search" method="get" action="<?php echo ROOTHOST.COMS;?>">
						<div class="frm-search-box form-inline pull-left">
							<input class="form-control" type="text" value="<?php echo $get_q?>" name="q" id="txtkeyword" placeholder="Từ khóa"/>
							&nbsp&nbsp&nbsp
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
							&nbsp&nbsp&nbsp
							<button type="submit" id="_btnSearch" class="btn btn-primary">Tìm kiếm</button>
						</div>
					</form>
				</div>
				<div class="col-md-6">
					<div class="pull-right">
						<form id="frm_actions" method="post" action="">
							<input type="hidden" name="txtaction" id="txtaction"/>
							<input type="hidden" name="txtids" id="txtids" />
						</form>
						<a href="<?php echo ROOTHOST.COMS;?>/add" class="btn btn-primary float-sm-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm mới</a>
					</div>
				</div>
			</div>

			<div class="card">
				<div class='table-responsive'>
					<table class="table table-bordered">
						<thead>                  
							<tr>
								<th style="width: 10px">#</th>
								<th>Xóa</th>
								<th>Tên</th>
								<th>Mô tả</th>
								<th style="text-align: center;" width="150">Danh sách ảnh</th>
								<th style="text-align: center;" width="80">Hiển thị</th>
								<th style="text-align: center;" width="80">Sửa</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($total_rows>0){
								$star = ($cur_page - 1) * $max_rows;
								$strWhere.=" LIMIT $star,".$max_rows;
								$res_events = SysGetList('tbl_album', array(), $strWhere, false);
								$i=0;
								while($rows = $res_events->Fetch_Assoc()){
									$i++;
									$ids=$rows['id'];
									$title = $rows['title'];
									$intro = Substring(stripslashes($rows['title']),0,10);

									if($rows['isactive'] == 1) 
										$icon_active    = "<i class='fas fa-toggle-on cgreen'></i>";
									else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

									echo "<tr name='trow'>";
									echo "<td width='30' align='center'>".$i."</td>";

									echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/delete/".$ids."' onclick='return confirm(\"Bạn có chắc muốn xóa?\")'><i class='fa fa-trash cred' aria-hidden='true'></i></a></td>";

									echo "<td>".$title."</td>";
									echo "<td>".$intro."</td>";

									echo "<td align='center'>";
									echo "<a href='".ROOTHOST.COMS."/".$rows['code']."-".$ids."'><i class='fa fa-list-ul' aria-hidden='true'></i></a></td>";

									echo "<td align='center'>";
									echo "<a href='".ROOTHOST.COMS."/active/".$ids."'>";
									echo $icon_active;
									echo "</a></td>";

									echo "<td align='center'>";
									echo "<a href='".ROOTHOST.COMS."/edit/".$ids."'>";
									echo "<i class='fa fa-edit' aria-hidden='true'></i>";
									echo "</a></td>";
									echo "</tr>";
								}
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
<?php }else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}
?>