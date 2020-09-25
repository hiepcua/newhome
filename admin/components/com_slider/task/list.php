<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','SLIDER');
// Init variables
$isAdmin=getInfo('isadmin');

if($isAdmin==1){
    $strWhere='';
    $keyword = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
    $action = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';

    // Gán strWhere
    if($keyword!='')
        $strWhere.=" AND ( `slogan` like '%$keyword%' )";
    if($action!='' && $action!='all' ){
        $strWhere.=" AND `isactive` = '$action'";
    }

    /*Begin pagging*/
    if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
        $_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
    }
    if(isset($_POST['txtCurnpage'])){
        $_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
    }

    $total_rows=SysCount('tbl_slider', $strWhere);
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
                    <h1 class="m-0 text-dark">Danh sách banner</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                        <li class="breadcrumb-item active">Danh sách banner</li>
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
                                <input type='text' id='txt_title' name='q' class='form-control' placeholder="Tên chuyên mục..." />
                            </div>
                        </div>
                        <div class="col-sm-1"><input type="submit" name="" class="btn btn-primary" value="Tìm kiếm"></div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-2">
                            <a href="<?php echo ROOTHOST.COMS;?>/add" class="btn btn-primary float-sm-right"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm mới</a>
                        </div>
                    </div>
                </form>
            </div>

            <table class="table table-bordered">
                <tr class="header">
                    <th width="30" align="center">#</th>
                    <th class="th-delete">Xóa</th>
                    <th>Hình ảnh</th>
                    <th>Slogan</th>
                    <th style="text-align: center;" width="80px">Hiển thị</th>
                    <th style="text-align: center;" width="80px">Sửa</th>
                </tr>
                <?php 
                if($total_rows > 0){
                    $star = ($cur_page - 1) * $max_rows;
                    $strWhere.=" LIMIT $star,".$max_rows;
                    $res_sliders = SysGetList('tbl_slider', [], $strWhere);

                    foreach ($res_sliders as $key => $rows) {
                        $ids=$rows['id'];
                        $link=$rows['link'];
                        $slogan= Substring($rows['slogan'], 0, 10);
                        $img=$rows['thumb'];
                        $order=$rows['order'];
                        
                        if($rows['isactive'] == 1) 
                            $icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
                        else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';
                        
                        echo "<tr name=\"trow\">";
                        echo "<td width=\"30\" align=\"center\">".($key+1)."</td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

                        echo "<td class='td-thumb'><img src='$img' class='img-obj pull-left'></td>";
                        echo "<td>$slogan</td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/active/$ids'>".$icon_active."</a></td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/edit/$ids'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>

            <nav class="d-flex justify-content-center">
                <?php 
                paging($total_rows, $max_rows, $cur_page);
                ?>
            </nav>
        </div>
    </section>
<?php }else{
    echo "<h3 class='text-center'>You haven't permission</h3>";
}
?>
