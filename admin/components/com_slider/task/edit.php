<?php
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file='';
$GetID = isset($_GET['id']) ? (int)$_GET["id"] : 0;

if(isset($_POST['cmdsave_tab1'])) {
    $Slogan     = isset($_POST['txt_slogan']) ? addslashes($_POST['txt_slogan']) : '';
    $Intro      = isset($_POST['txt_intro']) ? addslashes($_POST['txt_intro']) : '';
    $Link       = isset($_POST['txt_link']) ? addslashes($_POST['txt_link']) : '';
    $Images     = isset($_POST['txt_thumb2']) ? addslashes($_POST['txt_thumb2']) : '';

    if(isset($_FILES['txt_thumb']) && $_FILES['txt_thumb']['size'] > 0){
        $save_path  = "../medias/images/";
        $obj_upload->setPath($save_path);
        $file = ROOTHOST_WEB.'medias/images/'.$obj_upload->UploadFile("txt_thumb", $save_path);
    }else{
        $file = $Images;
    }

    $arr=array();
    $arr['slogan']      = $Slogan;
    $arr['intro']       = $Intro;
    $arr['link']        = $Link;
    $arr['thumb']       = $file;

    $result = SysEdit('tbl_slider', $arr, "id=".$GetID);
    if($result){
        $_SESSION['flash'.'com_'.COMS] = 1;
    }else{
        $_SESSION['flash'.'com_'.COMS] = 0;
    }
}

$res_Sliders = SysGetList('tbl_slider', array(), ' AND id='. $GetID);
if(count($res_Sliders) <= 0){
    echo 'Không có dữ liệu.'; 
    return;
}
$row = $res_Sliders[0];
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cập nhật banner</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách banner</a></li>
                    <li class="breadcrumb-item active">Cập nhật banner</li>
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
        <div id='action'>
            <div class="card">
                <form id="frm_action" name="frm_action" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8 col-lg-9">
                            <div class='form-group'>
                                <label>link</label>
                                <input type="text" name="txt_link" class="form-control" value="<?php echo $row['link'];?>" id="txt_link">
                            </div>

                            <div class='form-group'>
                                <label>Slogan</label>
                                <input type="text" name="txt_slogan" class="form-control" value="<?php echo $row['slogan'];?>" id="txt_slogan">
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="txt_intro" id="txt_intro" class="form-control"><?php echo $row['intro'];?></textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-3">
                            <div class='form-group'>
                                <div class="widget-fileupload fileupload fileupload-new" data-provides="fileupload">
                                    <label>Ảnh đại diện</label><small> (Dung lượng < 10MB)</small>
                                    <div class="widget-avatar mb-2">
                                        <div class="fileupload-new thumbnail">
                                            <?php
                                            if(strlen($row['thumb'])>0){
                                                echo '<img src="'.$row['thumb'].'" id="img_image_preview">';
                                            }else{
                                                echo '<img src="'.ROOTHOST.'global/img/no-photo.jpg" id="img_image_preview">';
                                            }
                                            ?>
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
                                        <input type="hidden" name="txt_thumb2" value="<?php echo $row['thumb'];?>">
                                    </div>
                                    <div class="control">
                                        <span class="btn btn-file">
                                            <span class="fileupload-new">Tải lên</span>
                                            <span class="fileupload-exists">Thay đổi</span>
                                            <input type="file" id="file_image" name="txt_thumb" accept="image/jpg, image/jpeg">
                                        </span>
                                        <a href="javascript:void(0)" class="btn fileupload-exists" data-dismiss="fileupload" onclick="cancel_fileupload()">Hủy</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center toolbar">
                        <input type="submit" name="cmdsave_tab1" id="cmdsave_tab1" class="save btn btn-success" value="Lưu thông tin" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#frm_action').submit(function(){
            return validForm();
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement("img");
                img.src = e.target.result;
                // Hidden fileupload new
                $('.fileupload').removeClass('fileupload-new');
                $('.fileupload').addClass('fileupload-exists');
                $('.fileupload-preview').html(img);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#file_image").on('change', function(){
        readURL(this);
    });

    function cancel_fileupload(){
        $('.fileupload').removeClass('fileupload-exists');
        $('.fileupload').addClass('fileupload-new');
        $('.fileupload-preview').empty();
        $("#file_image").val('');
    }

    function validForm(){
        var flag = true;
        return flag;
    }
</script>