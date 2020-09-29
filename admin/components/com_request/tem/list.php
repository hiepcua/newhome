<?php
$strWhere="";
$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';
$action = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';

/*Gán strWhere*/
if($get_q!=''){
	$strWhere.=" AND name LIKE '%".$get_q."%' OR email LIKE '%".$get_q."%'";
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

$total_rows=SysCount('tbl_request',$strWhere);
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
				<h1 class="m-0 text-dark">Yêu cầu liên hệ</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item active">Yêu cầu liên hệ</li>
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
                        <input type='text' id='txt_title' name='q' value="<?php echo $get_q;?>" class='form-control' placeholder="Email address, name..." />
                        &nbsp&nbsp&nbsp
                        <select name="cbo_action" class="form-control" id="cbo_action">
                            <option value="all">Tất cả</option>
                            <option value="1">Yêu cầu mới</option>
                            <option value="0">Đã xử lý</option>
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
			<div class="table-responsive">
            	<table class="table table-bordered">
					<thead>                  
						<tr>
							<th width="30" align="center">#</th>
							<!-- <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th> -->
							<th width="30" align="center">Xóa</th>
							<th>Tên</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Ngày tạo</th>
							<th width="80" class="text-center">Yêu cầu mới</th>
							<th width="80">Chi tiết</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($total_rows>0){
							$star = ($cur_page - 1) * $max_rows;
							$strWhere.=" LIMIT $star,".$max_rows;
							$obj=SysGetList('tbl_request',array(), $strWhere, false);
							$stt=0;
							while($r=$obj->Fetch_Assoc()){ 
								$stt++;
								if($r['isactive'] == 1) 
									$icon_active    = "<i class='fas fa-toggle-on cgreen'></i>";
								else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';
								?>
								<tr>
									<td><?php echo $stt;?></td>
									<!-- <td width="30" align="center"><input type="checkbox" name="chk" onclick="docheckonce('chk');" value="$ids"/></td> -->
									<td align="center" style="width: 50px;"><a href="<?php echo ROOTHOST.COMS.'/delete/'.$r['id'];?>" onclick="return confirm('Bạn có chắc muốn xóa ?')"><i class="fa fa-trash cred" aria-hidden="true"></i></a></td>
									<td><?php echo $r['name'];?></td>
									<td><?php echo $r['email'];?></td>
									<td><?php echo $r['phone'];?></td>
									<td><?php echo date('H:i | d-m-Y', $r['cdate']);?></td>
									<td align='center'><a href="<?php echo ROOTHOST.COMS.'/active/'.$r['id'];?>"><?php echo $icon_active;?></a></td>
									<td class="text-center"><a href="<?php echo ROOTHOST.COMS.'/edit/'.$r['id'];?>"><i class="fas fa-edit cblue"></i></a></td>
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