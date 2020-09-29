<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$GetID = isset($_GET['id']) ? (int)$_GET["id"] : 0;

if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
    $Title          = isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
    $Intro          = isset($_POST['txt_intro']) ? addslashes($_POST['txt_intro']) : '';
    $FullText       = isset($_POST['txt_fulltext']) ? addslashes($_POST['txt_fulltext']) : '';
    $seo_link       = isset($_POST['txt_seo_link']) ? addslashes($_POST['txt_seo_link']) : '';

    $arr=array();
    $arr['title'] = $Title;
    $arr['alias'] = un_unicode($Title);
    $arr['sapo'] = $Intro;
    $arr['fulltext'] = $FullText;
    $arr['cdate'] = time();

    $result = SysEdit('tbl_page', $arr, "id=".$GetID);

    $arr2=array();
    $arr2['title'] = $arr['title'];
    $arr2['link'] = ROOTHOST_WEB.$arr['alias'].'-p'.$GetID;
    $arr2['meta_title'] = $arr['title'];
    $arr2['meta_key'] = $arr['title'];
    $arr2['meta_desc'] = $arr['sapo'];

    SysEdit('tbl_seo', $arr2, 'link="'.$seo_link.'"');

    if($result) $_SESSION['flash'.'com_'.COMS] = 1;
    else $_SESSION['flash'.'com_'.COMS] = 0;
}

$sql="SELECT * FROM tbl_page WHERE id = ".$GetID;
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();

$seo_link = ROOTHOST_WEB.$row['alias'].'-p'.$row['id'];
$res_seos = SysGetList('tbl_seo', [], "AND `link`='".$seo_link."'");
$meta_title = $meta_key = $meta_desc = '';
if(count($res_seos)){
    $res_seo = $res_seos[0];
    $meta_title = $res_seo['meta_title'];
    $meta_key = $res_seo['meta_key'];
    $meta_desc = $res_seo['meta_desc'];
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cập nhật trang tĩnh</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách trang tĩnh</a></li>
                    <li class="breadcrumb-item active">Cập nhật trang tĩnh</li>
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

        <form id="frm_action" class="form-horizontal" method="post" enctype="multipart/form-data">
            <input type="hidden" name="txt_seo_link" value="<?php echo $seo_link;?>">
            <div class="form-group">
                <label>Tiêu đề<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                <input type="text" name="txt_name" class="form-control" id="txt_name" value="<?php echo $row['title'];?>" placeholder="Tiêu đề trang" required>
            </div>

            <div class="form-group">
                <label>Mô tả<small class="cred"> (*)</small><span id="err_link" class="mes-error"></span></label>
                <textarea class="form-control" id="txt_intro" name="txt_intro" rows="3"><?php echo $row['sapo'];?></textarea>
            </div>

            <div class="form-group">
                <label>Nội dung</label>
                <textarea class="form-control" id="txt_fulltext" name="txt_fulltext"><?php echo $row['fulltext'];?></textarea>
            </div>

            <div class="text-center toolbar">
                <input type="submit" name="cmdsave_tab1" id="cmdsave_tab1" class="save btn btn-success" value="Lưu thông tin" class="btn btn-primary">
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        // Hidden left sidebar
        $('#body').addClass('sidebar-collapse');
        $('#frm_action').submit(function(){
            return validForm();
        });

        tinymce.init({
            selector: '#txt_fulltext',
            height: 500,
            plugins: [
            'link image imagetools table lists autolink fullscreen media hr code'
            ],
            image_title: true,
            automatic_uploads: true,
            toolbar: 'bold italic underline | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify |  numlist bullist | removeformat | insertfile image media link anchor codesample | outdent indent fullscreen code',
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

    function validForm(){
        if($("#txt_name").val()==""){
            $("#err_name").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tiêu đề').fadeTo(900,1);
            });
            return false;
        }
        return true;
    }
</script>