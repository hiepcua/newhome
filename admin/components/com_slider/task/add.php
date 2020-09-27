<?php
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file='';

if(isset($_POST['cmdsave_tab1'])) {
    $Slogan     = isset($_POST['txt_slogan']) ? addslashes($_POST['txt_slogan']) : '';
    $Intro      = isset($_POST['txt_intro']) ? addslashes($_POST['txt_intro']) : '';
    $Link       = isset($_POST['txt_link']) ? addslashes($_POST['txt_link']) : '';
    $isActive   = '1';

    if(isset($_FILES['txt_thumb']) && $_FILES['txt_thumb']['size'] > 0){
        $save_path  = "../medias/images/";
        $obj_upload->setPath($save_path);
        $file = ROOTHOST_WEB.'medias/images/'.$obj_upload->UploadFile("txt_thumb", $save_path);
    }

    $arr=array();
    $arr['slogan']      = $Slogan;
    $arr['intro']       = $Intro;
    $arr['link']        = $Link;
    $arr['isactive']    = $isActive;
    $arr['thumb']       = $file;

    $result = SysAdd('tbl_slider', $arr);
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
                <h1 class="m-0 text-dark">Thêm mới banner</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách banner</a></li>
                    <li class="breadcrumb-item active">Thêm mới banner</li>
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
                $msg->error('Có lỗi trong quá trình thêm mới.');
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
                                <input type="text" name="txt_link" class="form-control" id="txt_link">
                            </div>

                            <div class='form-group'>
                                <label>Slogan</label>
                                <input type="text" name="txt_slogan" class="form-control" id="txt_slogan">
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="txt_intro" id="txt_intro" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-3">
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
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#frm_action').submit(function(){
            return validForm();
        });

        tinymce.init({
            selector: '#txt_intro',
            height: 300,
            plugins: [
            'link image imagetools table lists autolink fullscreen media hr code'
            ],
            image_title: true,
            automatic_uploads: true,
            toolbar: 'bold italic underline | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify |  numlist bullist | removeformat | insertfile image media link anchor codesample | outdent indent fullscreen',
            contextmenu: 'link image imagetools table spellchecker lists',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            image_caption: true,
            images_reuse_filename: true,
            images_upload_credentials: true,
            relative_urls : false,
            remove_script_host : false,
            convert_urls : true,
            
            // override default upload handler to simulate successful upload
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;

                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '<?php echo ROOTHOST;?>ajaxs/upload.php');

                xhr.onload = function() {
                    console.log(xhr.responseText);
                    var json;

                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                formData.append('folder', 'images/');
                xhr.send(formData);
            },
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