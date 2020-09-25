<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','SEO');
$strwhere='';

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
    $ids=trim($_POST["txtids"]);
    if($ids!='')
        $ids = substr($ids,0,strlen($ids)-1);
    $ids=str_replace(",","','",$ids);
    switch ($_POST["txtaction"]){
        case "public": 
            $sql_active = "UPDATE `tbl_seo` SET `isactive`='1' WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_active);
            break;
        case "unpublic":
            $sql_unactive = "UPDATE `tbl_seo` SET `isactive`='0' WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_unactive);
            break;
        case "delete":
            $sql_del = "DELETE FROM `tbl_seo` WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_del);
            break;
        case 'order':
            $sls = explode(',',$_POST['txtorders']); 
            $ids = explode(',',$_POST['txtids']);
            $n = count($ids);
            for($i=0;$i<$n;$i++){
                $sql_order = "UPDATE `tbl_seo` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
                $objmysql->Exec($sql_order);
            }
    }
    echo "<script language=\"javascript\">window.location='".ROOTHOST.COMS."'</script>";
}

// Khai báo SESSION
$keyword = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
$action = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';

// Gán strwhere
if($keyword !== ''){
    $strwhere.=" AND ( `title` like '%$keyword%' )";
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

$total_rows=SysCount('tbl_seo', $strwhere);
$max_rows = 20;

if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
}
$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
// End pagging
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Danh sách Meta SEO</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item active">Danh sách Meta SEO</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row widget-frm-search form-group">
            <div class="col-md-6">
                <form id="frm_search" method="get" action="<?php echo ROOTHOST.COMS;?>">
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
                    <form id="frm_actions" method="post" action="">
                        <input type="hidden" name="txtaction" id="txtaction"/>
                        <input type="hidden" name="txtids" id="txtids" />
                    </form>
                    <a href="<?php echo ROOTHOST.COMS;?>/add" class="btn btn-primary float-sm-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm mới</a>
                    <a class="delete btn btn-danger float-sm-right" href="#" style="margin-right: 10px;" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_actions','delete'); }" title="Xóa"><i class="fa fa-times-circle" aria-hidden="true"></i> Xóa</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th width="30" align="center">#</th>
                    <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
                    <th class="th-delete">Xóa</th>
                    <th>Tiêu đề</th>
                    <th>Link</th>
                    <th class="th-display">Hiển thị</th>
                    <th class="th-edit">Sửa</th>
                </thead>
                <tbody>
                    <?php
                    $star = ($cur_page - 1) * $max_rows;
                    $res_seos = SysGetList('tbl_seo', [], $strwhere." ORDER BY `title` asc LIMIT $star,".$max_rows);
                    foreach ($res_seos as $key => $rows) {
                        $ids        = $rows['id'];
                        $title      = Substring(stripslashes($rows['title']),0,10);
                        $link       = stripslashes($rows['link']);
                        $order      = number_format($rows['order']);

                        if($rows['isactive'] == 1) 
                            $icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
                        else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

                        echo "<tr name='trow'>";
                        echo "<td width='30' align='center'>".($key+1)."</td>";
                        echo "<td width='30' align='center'><label>";
                        echo "<input type='checkbox' name='chk' id='chk' onclick=\"docheckonce('chk');\" value='$ids'/>";
                        echo "</label></td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

                        echo "<td>$title</td>";
                        echo "<td>$link</td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/active/$ids'>".$icon_active."</a></td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/edit/$ids'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <nav class="d-flex justify-content-center">
                <?php 
                paging($total_rows,$max_rows,$cur_page);
                ?>
            </nav>
        </div>
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
<?php //----------------------------------------------?>
