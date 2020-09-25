<?php
define('OBJ_PAGE','USERS');
$strWhere='';
$keyword    = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
$action = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';

if($keyword !== ''){
	$strWhere.= " AND username ='".$keyword."' OR fullname LIKE '%".$keyword."%'";
}
if($action !=='' && $action !== 'all'){
	$strWhere.=" AND `isactive` = '$action'";
}

/*Begin pagging*/
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$total_rows=SysCount('tbl_users',$strWhere);
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
				<h1 class="m-0 text-dark">Danh sách người dùng</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item active">Danh sách người dùng</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<form id="frm_list" method="get" action="<?php echo ROOTHOST.COMS;?>">
					<div class="frm-search-box form-inline pull-left">
						<input class="form-control" type="text" value="<?php echo $keyword?>" name="q" id="txtkeyword" placeholder="Từ khóa"/>
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
					<a href="<?php echo ROOTHOST.COMS;?>/add" class="btn btn-primary float-sm-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm mới</a>
				</div>
			</div>
		</div><br/>

		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="30">#</th>
						<th class="th-delete">Xóa</th>
						<th>Tên đăng nhập</th>
						<th>Tên người dùng</th>
						<th>Thông tin</th>
						<th class="text-center">Mật khẩu</th>
						<th class="text-center">Admin</th>
						<th class="th-display" colspan="2">Hành động</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if($total_rows>0){
						$star = ($cur_page - 1) * $max_rows;
						$strWhere.=" LIMIT $star,".$max_rows;
						$res_users = SysGetList('tbl_users', [], $strWhere);
						foreach ($res_users as $key => $row) {
							$username = stripslashes($row['username']);
							$fullname = $row["fullname"];
							$email = $row['email'];
							$phone = $row['phone'];

							if($row['isactive'] == 1) 
								$icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
							else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

							echo '<tr class="trow">';
							echo '<td width="center">'.($key + 1).'</td>';

							echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/delete?user=".$username."' onclick=\"return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

							echo '<td>'.$username.'</td>';

							echo '<td>'.$fullname.'</td>';

							echo '<td><div class="user">'.$email.'</div><div class="phone">'.$phone.'</div></td>';
							echo '<td class="text-center"><a href="javascript:void(0)" data-id="'.$username.'" class="change_pass"><i class="fa fa-key" aria-hidden="true"></i></a></td>';

							$checked = (int)$row['isadmin']!=1?"" : "checked=true";

							echo '<td class="text-center"><div class="custom-control custom-checkbox">
							<input class="custom-control-input chk_isadmin" '.$checked.' type="checkbox" id="chk_isadmin_'.$username.'" value="'.$username.'">
							<label for="chk_isadmin_'.$username.'" class="custom-control-label" style="margin-bottom: .5rem;">&nbsp;</label>
							</div></td>';

							echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/active?user=".$username."'>".$icon_active."</a></td>";

							echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/edit?user=".$username."'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";

							echo '</tr>';
						}
					}else{ echo 'Chưa có người dùng.';}?>
				</tbody>
			</table>
		</div>

		<nav class="d-flex justify-content-center">
			<?php paging($total_rows, $max_rows, $cur_page);?>
		</nav>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('.change_pass').on('click', function(){
			var id = $(this).attr('data-id');
			var _url="<?php echo ROOTHOST;?>ajaxs/user/change_pass.php";
			var _data={
				'user_id': id,
			}
			$.post(_url, _data, function(req){
				$('#popup_modal .modal-body').html(req);
				$('#popup_modal').modal('show');
			});
		});

		$('.chk_isadmin').click(function(){
			var ischeck = $(this).is(':checked')?'yes':'no';
			if(confirm('Bạn có chắc chắn thay đổi quyền của người dùng này?')){
				var _url="<?php echo ROOTHOST;?>ajaxs/user/change_isadmin.php";
				var _data={
					'user':$(this).val(),
					'ischeck':ischeck
				}
				$.post(_url,_data,function(req){
					/*alert('Change permission success!');*/
					window.location.reload();
				})
			}
		});
	})
</script>

