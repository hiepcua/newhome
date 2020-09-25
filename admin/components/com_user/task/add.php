<?php
defined("ISHOME") or die("Can not acess this page, please come back!");
if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
    $Username       = isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
    $Fullname       = isset($_POST['txt_fullname']) ? addslashes($_POST['txt_fullname']) : '';
    $Group          = isset($_POST['cbo_group']) ? (int)$_POST['cbo_group'] : '';
    $Email          = isset($_POST['txt_email']) ? addslashes($_POST['txt_email']) : '';
    $Pass           = isset($_POST['txt_pass']) ? $_POST['txt_pass'] : '';
    $Phone          = isset($_POST['txt_phone']) ? addslashes($_POST['txt_phone']) : '';
    $Butdanh        = isset($_POST['txt_pseudonym']) ? addslashes($_POST['txt_pseudonym']) : $Username;

    $arr=array();
    $arr['username']    = $Username;
    $arr['group']       = $Group;
    $arr['email']       = $Email;
    $arr['phone']       = $Phone;
    $arr['fullname']    = $Fullname;
    $arr['pseudonym']   = $Butdanh;
    $arr['cdate']       = time();
    $pass = $Pass;
    $arr['password']=hash('sha256',$arr['username']).'|'.hash('sha256',md5($pass));

    SysAdd('tbl_users', $arr);
    echo "<script language=\"javascript\">window.location.href='".ROOTHOST.COMS."'</script>";
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Thêm mới người dùng</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách người dùng</a></li>
                    <li class="breadcrumb-item active">Thêm mới người dùng</li>
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
                $msg->success('Thêm mới thành công.');
                echo $msg->display();
            }else if($_SESSION['flash'.'com_'.COMS] == 0){
                $msg->error('Có lỗi trong quá trình thêm.');
                echo $msg->display();
            }
            unset($_SESSION['flash'.'com_'.COMS]);
        }
        ?>
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <div class="form-group">
                        <label>Tên đăng nhập </label><font color="red"> (*) </font><span id="checkExist"></span>
                        <input type="text" id="txt_name" name="txt_name" class="form-control" value="" placeholder="Tên đăng nhập" required="">
                        <input type="hidden" id="inp_checkExit" name="inp_checkExit" value="1">
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="text" id="txt_pass" name="txt_pass" class="form-control" value="" placeholder="Mật khẩu người dùng">
                    </div>

                    <div class="form-group">
                        <label>Tên người dùng</label>
                        <input type="text" id="txt_fullname" name="txt_fullname" class="form-control" value="" placeholder="Tên người dùng">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="text" id="txt_email" name="txt_email" class="form-control" value="">
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                        <label>Nhóm người dùng</label>
                        <select class='form-control' id='cbo_group' name="cbo_group">
                            <?php
                            foreach (GROUP_USER as $key => $value) {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-mobile-alt"></i> Số điện thoại</label>
                        <input type="text" id="txt_phone" name="txt_phone" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <label>Bút danh</label>
                        <input type="text" id="txt_pseudonym" name="txt_pseudonym" class="form-control" value="">
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

        $('#txt_name').on('change', function(){
            var username = $(this).val();
            var _url = '<?php echo ROOTHOST;?>ajaxs/user/checkExist.php';

            $.post(_url, {'username': username}, function(res){
                if(parseInt(res) == 0){
                    $('#checkExist').html('<i class="fa fa-check-square cgreen" aria-hidden="true"></i>');
                    $('#inp_checkExit').val('0');
                }else{
                    $('#checkExist').html('<i class="fa fa-times-circle cred" aria-hidden="true"></i> Tên đăng nhập đã có người sử dụng.');
                    $('#inp_checkExit').val('1');
                }
            });
        });
    });

    function validForm(){
        var flag = true;
        var title = $('#txt_name').val();
        var exits = $('#inp_checkExit').val();
        var pass = $('#txt_pass').val();

        if(title==''){
            alert('Các mục đánh dấu * không được để trống');
            flag = false;
        }

        if(pass.length < 6){
            alert('Mật khẩu phải có ít nhất 6 ký tự.');
            flag = false;
        }

        if(parseInt(exits) == 1){
            alert('Tên đăng nhập đã có người sử dụng');
            flag = false;
        }
        return flag;
    }
</script>