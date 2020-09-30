<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
    define('OBJ_PAGE','GALLERY');
    $strwhere='';

    $keyword = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
	$action = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';

	if($keyword !== ''){
		$strwhere.=" AND ( `name` like '%$keyword%' )";
	}
	if($action !== '' && $action !== 'all' ){
		$strwhere.=" AND `isactive` = '$action'";
	}

	// Begin pagging
	if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
	}
	if(isset($_POST['txtCurnpage'])){
	    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
	}

	$sqlC = "SELECT COUNT(*) AS count FROM tbl_album WHERE 1=1 ".$strwhere;
	$objmysql->Query($sqlC);
	$row_count = $objmysql->Fetch_Assoc();
	$total_rows = $row_count['count'];

	if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/MAX_ROWS_ADMIN)){
	    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/MAX_ROWS_ADMIN);
	}
	$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
	// End pagging
?>
<script language="javascript">
	function checkinput(){
		var strids=document.getElementById("txtids");
		if(strids.value == ""){
			alert('Bạn chưa lựa chọn đối tượng nào.');
			return false;
		}
		return true;
	}
</script>

<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo ROOTHOST_ADMIN;?>">Admin</a></li>
        <li class="active">Thư viện ảnh</li>
    </ol>
</div>

<div class="com_header color">
    <form id="frm_list" method="get" action="<?php echo ROOTHOST_ADMIN.COMS;?>">
        <div class="frm-search-box form-inline pull-left">
            <label class="mr-sm-2" for="">Từ khóa: </label>
            <input class="form-control" type="text" value="<?php echo $keyword?>" name="q" id="txtkeyword" placeholder="Từ khóa"/>&nbsp;
            <button type="submit" id="_btnSearch" class="btn btn-success">Tìm kiếm</button>
            <select name="cbo_action" class="form-control" id="cbo_action">
                <option value="all">Tất cả</option>
                <option value="1">Hiển thị</option>
                <option value="0">Ẩn</option>
                <script language="javascript">
                    cbo_Selected('cbo_action','<?php echo $action;?>');
                </script>
            </select>
        </div>
    </form>
    <div class="pull-right">
        <div id="menus" class="toolbars">
            <form id="frm_menu" name="frm_menu" method="post" action="">
                <input type="hidden" name="txtorders" id="txtorders" />
                <input type="hidden" name="txtids" id="txtids" />
                <input type="hidden" name="txtaction" id="txtaction" />
                <ul class="list-inline">
                    <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','public');"><i class="fa fa-check-circle-o cgreen" aria-hidden="true"></i> Hiển thị</button></li>
                    <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','unpublic');"><i class="fa fa-times-circle-o cred" aria-hidden="true"></i> Ẩn</button></li>
                    <li><a class="addnew btn btn-default" href="<?php echo ROOTHOST_ADMIN.COMS;?>/add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm mới</a></li>
                    <li><a class="delete btn btn-default" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="Xóa"><i class="fa fa-times-circle cred" aria-hidden="true"></i> Xóa</a></li>
                </ul>
            </form>
        </div>
    </div>
</div><br>
<div class="clearfix"></div>

<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<th width="30" align="center">#</th>
			<th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
			<th width="30" align="center">Xóa</th>
			<th align="center" width="140">Hình ảnh</th>
			<th align="center">Tên album</th>
			<th align="center">Mô tả</th>
			<td width="80" align="center"><b>Sắp xếp</b>
				<a href="javascript:saveOrder()"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
			</td>
			<th width="70" align="center">Hiện/Ẩn</th>
			<th width="30" align="center">Sửa</th>
		</thead>
		<tbody>
			<?php
			$star = 0; 
			$i = 0;
			if($cur_page > 1) {
				$star = ($cur_page-1) * MAX_ROWS;
			}
			$leng = MAX_ROWS;
			$sql = "SELECT * FROM `tbl_album` WHERE 1=1 $strwhere ORDER BY `id` DESC LIMIT $star,$leng";
			$objmysql->Query($sql);
			while($rows = $objmysql->Fetch_Assoc()){
				$i++;
				$id = $rows['id'];
				$order = $rows['order'];
				$ablum = Substring(stripslashes($rows['name']),0,10);
				$img = stripslashes($rows['thumb']);
	            $intro = Substring(stripslashes($rows['intro']),0,20);
				if($rows['isactive'] == 1) 
	                $icon_active="<i class='fa fa-check cgreen' aria-hidden='true'></i>";
	            else $icon_active='<i class="fa fa-times-circle-o cred" aria-hidden="true"></i>';
				
				echo "<tr name='trow'>";
				echo "<td width='30' align='center'>$i</td>";
				echo "<td width='30' align='center'><label>";
				echo "<input type='checkbox' name='chk' id='chk' onclick='docheckonce(\"chk\");' value='$id' />";
				echo "</label></td>";
				echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$id' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-trash cgray' aria-hidden='true'></i></a></td>";
	            echo '<td align="center"><img width="150" height="100" src="'.$img.'" ></td>';
				echo "<td>$ablum</td>";

				echo "<td>$intro &nbsp;</td>";
	            echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";
				echo "<td width='50' align='center'>";
				echo "<a href=\"".ROOTHOST_ADMIN.COMS."/active/$id\">";
	            echo $icon_active;
				echo "</a>";
				echo "</td>";
				echo "<td width='50' align='center'>";
				echo "<a href=\"".ROOTHOST_ADMIN.COMS."/edit/$id\">";
	            echo "<i class='fa fa-edit' aria-hidden='true'></i>";
				echo "</a>";
				echo "</td>";
			  	echo "</tr>";
			}
			?>
		</tbody>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
		<tr>
			<td align="center">
				<?php
				paging($total_rows,MAX_ROWS,$cur_page);
				?>
			</td>
		</tr>
	</table>
</div>
<?php //----------------------------------------------?>
