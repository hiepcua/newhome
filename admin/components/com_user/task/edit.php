<?php
defined("ISHOME") or die("Can not acess this page, please come back!");
$GetUser = isset($_GET['user']) ? $_GET["user"] : '';
if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
    $Fullname       = isset($_POST['txt_fullname']) ? addslashes($_POST['txt_fullname']) : '';
    $Group          = isset($_POST['cbo_group']) ? (int)$_POST['cbo_group'] : '';
    $Email          = isset($_POST['txt_email']) ? addslashes($_POST['txt_email']) : '';
    $Pass           = isset($_POST['txt_pass']) ? $_POST['txt_pass'] : '';
    $Phone          = isset($_POST['txt_phone']) ? addslashes($_POST['txt_phone']) : '';
    $Butdanh        = isset($_POST['txt_pseudonym']) ? addslashes($_POST['txt_pseudonym']) : $Username;

    $arr=array();
    $arr['group']       = $Group;
    $arr['email']       = $Email;
    $arr['phone']       = $Phone;
    $arr['fullname']    = $Fullname;
    $arr['pseudonym']   = $Butdanh;

    if(strlen($Pass) >= 6){
        $pass = $Pass;
        $arr['password']=hash('sha256',$arr['username']).'|'.hash('sha256',md5($pass));
    }

    $result = SysEdit('tbl_users', $arr, "username='".$GetUser."'");
    if($result){
        $_SESSION['flash'.'com_'.COMS] = 1;
    }else{
        $_SESSION['flash'.'com_'.COMS] = 0;
    }
}

$res_Users = SysGetList('tbl_users', array(), ' AND username="'.$GetUser.'"');
if(count($res_Users) <= 0){
    echo 'Không có dữ liệu.'; 
    return;
}
$row = $res_Users[0];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cập nhật người dùng</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách người dùng</a></li>
                    <li class="breadcrumb-item active">Cập nhật người dùng</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php
        if (isset($_SESSION['flash'.'com_'.COMS])) {
            if($_SESSION['flash'.'com_'.COMS] == 1){
                $msg->success('Cập nhật thành công.');
                echo $msg->display();
            }else if($_SESSION['flash'.'com_'.COMS] == 0){
                $msg->error('Có lỗi trong quá trình cập nhật.');
                echo $msg->display();
            }
            unset($_SESSION['flash'.'com_'.COMS]);
        }
        ?>
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <div class="form-group">
                        <label>Tên đăng nhập </label>
                        <input type="text" id="txt_name" name="txt_name" class="form-control" value="<?php echo $row['username'];?>" placeholder="Tên đăng nhập" readonly>
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu</label> <small>(Mật khẩu phải có ít nhất 6 ký tự thì hệ thống mới cập nhật lại mật khẩu)</small>
                        <input type="text" id="txt_pass" name="txt_pass" class="form-control" value="" placeholder="Mật khẩu người dùng">
                    </div>

                    <div class="form-group">
                        <label>Tên người dùng</label>
                        <input type="text" id="txt_fullname" name="txt_fullname" class="form-control" value="<?php echo $row['fullname'];?>" placeholder="Tên người dùng">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="text" id="txt_email" name="txt_email" class="form-control" value="<?php echo $row['email'];?>">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label>Nhóm người dùng</label>
                        <select class='form-control' id='cbo_group' name="cbo_group">
                            <?php
                            foreach (GROUP_USER as $key => $value) {
                                if($key == (int)$row['group']){
                                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                }else{
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-mobile-alt"></i> Số điện thoại</label>
                        <input type="text" id="txt_phone" name="txt_phone" class="form-control" value="<?php echo $row['phone'];?>">
                    </div>

                    <div class="form-group">
                        <label>Bút danh</label>
                        <input type="text" id="txt_pseudonym" name="txt_pseudonym" class="form-control" value="<?php echo $row['pseudonym'];?>">
                    </div>
                </div>
            </div>
            <div class="text-center toolbar">
                <input type="submit" name="cmdsave_tab1" id="cmdsave_tab1" class="save btn btn-success" value="Lưu thông tin" class="btn btn-primary">
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#frm_action').submit(function(){
            return validForm();
        });
    });

    function validForm(){
        var flag = true;
        var title = $('#txt_name').val();

        if(title==''){
            alert('Các mục đánh dấu * không được để trống');
            flag = false;
        }

        return flag;
    }
</script>