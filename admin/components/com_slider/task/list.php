<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','SLIDER');
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
                    <div class="col-md-6">
                        <form id="frm_search" method="get" action="<?php echo ROOTHOST.COMS;?>">
                            <div class="frm-search-box form-inline pull-left">
                               <input type='text' id='txt_title' name='q' class='form-control' value="<?php echo $keyword;?>" placeholder="Tên banner..." />
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
            </form><br>
        </div>

        <table class="table table-bordered">
            <tr class="header">
                <th width="30" align="center">#</th>
                <th class="th-delete">Xóa</th>
                <th>Hình ảnh</th>
                <th>Slogan</th>
                <th class="order">Sắp xếp</th>
                <th style="text-align: center;" width="80px">Hiển thị</th>
                <th style="text-align: center;" width="80px">Sửa</th>
            </tr>
            <?php 
            if($total_rows > 0){
                $star = ($cur_page - 1) * $max_rows;
                $strWhere.=" ORDER BY `order` ASC LIMIT $star,".$max_rows;
                $res_sliders = SysGetList('tbl_slider', [], $strWhere);

                foreach ($res_sliders as $key => $rows) {
                    $ids=$rows['id'];
                    $link=$rows['link'];
                    $slogan= Substring($rows['slogan'], 0, 10);
                    $img=$rows['thumb'];

                    if($rows['isactive'] == 1) 
                        $icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
                    else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

                    echo "<tr name=\"trow\">";
                    echo "<td width=\"30\" align=\"center\">".($key+1)."</td>";

                    echo "<td align='center' width='10'><a href='".ROOTHOST.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

                    echo "<td class='td-thumb'><img src='$img' class='img-obj pull-left'></td>";
                    echo "<td>$slogan</td>";

                    $order = $rows['order'];
                    echo "<td width='50' align='center'><input style='width: 50px;' type='number' min='0' name='txt_order' value=\"$order\" size=\"4\" class=\"order text-center\" data-id='".$ids."'></td>";

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
<script type="text/javascript">
    $(document).ready(function(){
        $('.order').on('change', function() {
            var val = parseInt(this.value);
            var id = parseInt($(this).attr('data-id'));
            var _data = {
                "id" : id,
                "val" : val,
            }
            $.post('<?php echo ROOTHOST;?>ajaxs/ajax_order_slider.php', _data, function(res){
                if(parseInt(res)==1){
                    $(this).val(parseInt(res));
                }else{
                    $(this).val('error!');
                }
            });
        });
    })
</script>