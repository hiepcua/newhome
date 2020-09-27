<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$msg        = new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file='';

if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
    $Title          = isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
    $Link           = isset($_POST['txt_link']) ? addslashes($_POST['txt_link']) : '';
    $Meta_title     = isset($_POST['txt_metatitle']) ? addslashes(htmlentities($_POST['txt_metatitle'])) : '';
    $Meta_key       = isset($_POST['txt_metakey']) ? addslashes(htmlentities($_POST['txt_metakey'])) : '';
    $Meta_desc      = isset($_POST['txt_metadesc']) ? addslashes(htmlentities($_POST['txt_metadesc'])) : '';

    if(isset($_FILES['txt_thumb']) && $_FILES['txt_thumb']['size'] > 0){
        $save_path  = "../medias/images/";
        $obj_upload->setPath($save_path);
        $file = ROOTHOST_WEB.'medias/images/'.$obj_upload->UploadFile("txt_thumb", $save_path);
    }

    $arr=array();
    $arr['title'] = $Title;
    $arr['link'] = $Link;
    $arr['image'] = $file;
    $arr['meta_title'] = $Meta_title;
    $arr['meta_key'] = $Meta_key;
    $arr['meta_desc'] = $Meta_desc;
    $arr['image'] = $file;

    $result = SysAdd('tbl_seo', $arr);
    if($result){
        $_SESSION['flash'.'com_'.COMS] = 1;
    }else{
        $_SESSION['flash'.'com_'.COMS] = 0;
    }
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">THÊM MỚI META SEO</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách Meta SEO</a></li>
                    <li class="breadcrumb-item active">Thêm mới Meta SEO</li>
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
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Tiêu đề<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                        <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="Tên Meta SEO" required>
                    </div>
                    <div class="form-group">
                        <label>Link<small class="cred"> (*)</small><span id="err_link" class="mes-error"></span></label>
                        <input type="text" name="txt_link" class="form-control" id="txt_link" placeholder="link" required>
                    </div>
                    <div class='form-group'>
                        <label><strong>Meta Title</strong></label>
                        <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control'/>
                    </div>

                    <div class='form-group'>
                        <label><strong>Meta Keyword</strong></label>
                        <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"></textarea>
                    </div>

                    <div class='form-group'>
                        <label><strong>Meta Description</strong></label>
                        <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class='form-group'>
                        <div class="widget-fileupload fileupload fileupload-new" data-provides="fileupload">
                            <label>Ảnh đại diện</label><small> (Dung lượng < 10MB)</small>
                            <div class="widget-avatar mb-2">
                                <div class="fileupload-new thumbnail">
                                    <img src="<?php echo ROOTHOST;?>global/img/no-photo.jpg" id="img_image_preview">
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="line-height: 20px;"></div>
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
        if($("#txt_name").val()==""){
            $("#err_name").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tiêu đề').fadeTo(900,1);
            });
            return false;
        }

        if($("#txt_link").val()==""){
            $("#err_link").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập liên kết').fadeTo(900,1);
            });
            return false;
        }
        return true;
    }
</script>