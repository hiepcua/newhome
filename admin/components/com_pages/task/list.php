<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','PAGES');
$strwhere='';

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
    $ids=trim($_POST["txtids"]);
    if($ids!='')
        $ids = substr($ids,0,strlen($ids)-1);
    $ids=str_replace(",","','",$ids);
    switch ($_POST["txtaction"]){
        case "public": 
            $sql_active = "UPDATE `tbl_page` SET `isactive`='1' WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_active);
            break;
        case "unpublic":
            $sql_unactive = "UPDATE `tbl_page` SET `isactive`='0' WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_unactive);
            break;
        case "delete":
            $sql_del = "DELETE FROM `tbl_page` WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_del);
            break;
        case 'order':
            $sls = explode(',',$_POST['txtorders']); 
            $ids = explode(',',$_POST['txtids']);
            $n = count($ids);
            for($i=0;$i<$n;$i++){
                $sql_order = "UPDATE `tbl_page` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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

$total_rows=SysCount('tbl_page', $strwhere);
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
                <h1 class="m-0 text-dark">Danh sách trang tĩnh</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item active">Danh sách trang tĩnh</li>
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
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th width="30" align="center">STT</th>
                    <th class="th-delete">Xóa</th>
                    <th>Tiêu đề</th>
                    <th class="th-display">Hiển thị</th>
                    <th class="th-edit">Sửa</th>
                </thead>
                <tbody>
                    <?php
                    $star = ($cur_page - 1) * $max_rows;
                    $sql = "SELECT * FROM tbl_page WHERE 1=1 $strwhere ORDER BY `id` DESC LIMIT $star,".$max_rows;
                    $objmysql->Query($sql);
                    $i = 0;
                    while($rows = $objmysql->Fetch_Assoc()){
                        $i++;
                        $ids        = $rows['id'];
                        $title      = $rows['title'];

                        if($rows['isactive'] == 1) 
                            $icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
                        else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

                        echo "<tr name='trow'>";
                        echo "<td width='30' align='center'>$i</td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

                        echo "<td>$title</td>";

                        echo "<td align='center'><a href='".ROOTHOST.COMS."/active/$ids'>".$icon_active."</a></td>";

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
<?php //----------------------------------------------?>