<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$viewtype = "mainmenu";
$GetID = isset($_GET['id']) ? (int)$_GET["id"] : 0;

if(isset($_POST['cmdsave_tab1']) && $_POST['txttitle']!='') {
    $Cate_ID    = isset($_POST['cbo_cate']) ? (int)$_POST['cbo_cate'] : 0;
    $Con_ID     = isset($_POST['cbo_content']) ? (int)$_POST['cbo_content'] : 0;
    $MnuID      = isset($_POST['cbo_menutype']) ? (int)$_POST['cbo_menutype'] : 0;
    $ViewTitle  = isset($_POST['optviewtitle']) ? (int)$_POST['optviewtitle'] : 0;
    $isActive   = isset($_POST['optactive']) ? (int)$_POST['optactive'] : 0;
    $Title      = isset($_POST['txttitle']) ? addslashes($_POST['txttitle']) : '';
    $Type       = isset($_POST['cbo_type']) ? addslashes($_POST['cbo_type']) : '';
    $Theme      = isset($_POST['cbo_theme']) ? addslashes($_POST['cbo_theme']) : '';
    $HTML       = isset($_POST['txtcontent']) ? antiData($_POST['txtcontent'], 'html', false) : '';
    $Position   = isset($_POST['cbo_position']) ? addslashes($_POST['cbo_position']) : '';
    $Class      = isset($_POST['txtclass']) ? addslashes($_POST['txtclass']) : '';
    $Intro      = isset($_POST['txtintro']) ? addslashes($_POST['txtintro']) : '';

    $arr=array();
    $arr['title'] = $Title;
    $arr['type'] = $Type;
    $arr['category_id'] = $Cate_ID;
    $arr['content_id'] = $Con_ID;
    $arr['menu_id'] = $MnuID;
    $arr['viewtitle'] = $ViewTitle;
    $arr['isactive'] = $isActive;
    $arr['theme'] = $Theme;
    $arr['content'] = $HTML;
    $arr['position'] = $Position;
    $arr['class'] = $Class;
    $arr['intro'] = $Intro;

    $result = SysEdit('tbl_modules', $arr, "id=".$GetID);
    if($result){
        $_SESSION['flash'.'com_'.COMS] = 1;
    }else{
        $_SESSION['flash'.'com_'.COMS] = 0;
    }
}

$res_Cate = SysGetList('tbl_modules', array(), ' AND id='. $GetID);
if(count($res_Cate) <= 0){
    echo 'Không có dữ liệu.'; 
    return;
}
$row = $res_Cate[0];

if(isset($_POST["txt_type"])){
    $viewtype = $_POST["txt_type"];
}else{
    $viewtype = $row["type"];
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">SỬA MODULE</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Danh sách module</a></li>
                    <li class="breadcrumb-item active">Sửa module</li>
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
        <form id="frm_type" name="frm_type" method="post" action="" style="display:none;">
            <input type="text" name="txt_type" id="txt_type" />
        </form>

        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
            <p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
            <div class="row">
                <div class="col-md-9 col-sm-8">
                    <div class="form-group">
                        <label>Kiểu hiển thị<small class="cred"> (*)</small><span id="err1" class="mes-error"></span></label>
                        <select name="cbo_type" class="form-control" id="cbo_type" onchange="select_type();" style="width: 100%;">
                            <?php
                            $res_modtypes = MODULE_TYPES;
                            foreach ($res_modtypes as $key => $value) {
                                echo "<option value=".$key.">".$value."</option>";
                            }
                            ?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                cbo_Selected('cbo_type','<?php echo $viewtype;?>');
                            });
                        </script>
                    </div>

                    <div class="form-group">
                        <label>Tiêu đề<small class="cred"> (*)</small><span id="err2" class="mes-error"></span></label>
                        <input name="txttitle" type="text" id="txttitle" class="form-control" value="<?php echo $row['title'];?>">
                    </div>

                    <?php
                    if(array_key_exists($viewtype, MODULE_TYPES)){ 

                        if($viewtype == "mainmenu"){ ?>
                            <div class="form-group">
                                <label>Menu<small class="cred"> (*)</small><span id="err3" class="mes-error"></span></label>
                                <select name="cbo_menutype" class="form-control" id="cbo_menutype">
                                    <option value="1">Main menu</option>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        cbo_Selected('cbo_menutype','<?php echo $row['menu_id'];?>');
                                    });
                                </script>
                                <span id="menutype_err" class="check_error"></span>
                            </div>

                        <?php }else if($viewtype=="category"){ ?>
                            <div class="form-group">
                                <label>Nhóm tin</label>
                                <select name="cbo_cate" class="form-control" id="cbo_cate" style="width: 100%;">
                                    <option value="0">Chọn một nhóm tin</option>
                                    <?php echo getListComboboxCategories(0,0);?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        cbo_Selected('cbo_cate','<?php echo $row['category_id'];?>');
                                    });
                                </script>
                            </div>

                        <?php }else if($viewtype=="news"){ ?>
                            <div class="form-group">
                                <label>Bài tin</label>
                                <select name="cbo_content" class="form-control" id="cbo_content" style="width: 100%;">
                                    <option value="0">Chọn một bài tin</option>
                                    <?php
                                    $res_cons = SysGetList('tbl_content', [], "AND status=4");
                                    foreach ($res_cons as $key => $value) {
                                        echo '<option value="'.$value['id'].'">'.$value['title'].'</option>';
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        cbo_Selected('cbo_content','<?php echo $row['content_id'];?>');
                                    });
                                </script>
                            </div>

                        <?php }else if($viewtype=="html"){ ?>
                            <div class="form-group">
                                <label>Nội dung html</label>
                                <textarea name="txtcontent" id="txtcontent" class="form-control"><?php echo $row['content'];?></textarea>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    tinymce.init({
                                        selector: '#txtcontent',
                                        height: 400,
                                        plugins: [
                                        'link image imagetools table lists autolink fullscreen media hr code'
                                        ],
                                        image_title: true,
                                        automatic_uploads: true,
                                        toolbar: 'bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify |  numlist bullist | removeformat | insertfile image media link anchor codesample | outdent indent',
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
                            </script>
                        <?php } ?>
                    <?php } ?>

                    <div class="form-group">
                        <label>Giao diện</label>
                        <select name="cbo_theme" class="form-control" id="cbo_theme" style="width: 100%;">
                            <option value="">Chọn một giao diện</option>
                            <?php LoadModBrow("mod_".$viewtype);?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                cbo_Selected('cbo_theme','<?php echo $row['theme'];?>');
                            });
                        </script>
                    </div>
                </div>

                <div class="col-md-3 col-sm-4">
                    <div class="form-group">
                        <label>Vị trí</label>
                        <select class="form-control" name="cbo_position" id="cbo_position">
                            <option value="">-- Select position --</option>
                            <?php
                            $res_positions = POSITIONS;
                            foreach ($res_positions as $key => $value) {
                                echo '<option value="'.$value.'">'.$value.'</option>';
                            }
                            ?>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    cbo_Selected('cbo_position','<?php echo $row['position'];?>');
                                });
                            </script>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Class</label>
                        <input type="text" name="txtclass" id="txtclass" class="form-control" value="<?php echo $row['class'];?>" />
                    </div>

                    <div class="form-group">
                        <label>Hiển thị tiêu đề</label>
                        <div>
                            <label class="radio-inline"><input type="radio" name="optviewtitle" value="1">Có</label>
                            <label class="radio-inline"><input type="radio" name="optviewtitle" value="0" checked>Không</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Hiển thị</label>
                        <div>
                            <label class="radio-inline"><input type="radio" name="optactive" value="1" <?php if($row['isactive']==1) echo 'checked';?>>Có</label>
                            <label class="radio-inline"><input type="radio" name="optactive" value="0" <?php if($row['isactive']==0) echo 'checked';?>>Không</label>
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
        $("#cbo_type").select2();
        $("#cbo_cate").select2();
        $("#cbo_content").select2();
        $("#cbo_position").select2();
        $("#cbo_theme").select2();

        $('#txttitle').blur(function(){
            if($(this).val()=="") {
                $("#err2").fadeTo(200,0.1,function(){ 
                    $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
                });
            }
        });

        $('#frm_action').submit(function(){
            return validForm();
        });
    });

    function validForm(){
        if($('#txttitle').val()=="") {
            $("#err2").fadeTo(200,0.1,function(){ 
                $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
            });
            $('#txttitle').focus();
            return false;
        }
        if( $('#cbo_type').val()=="mainmenu") {
            if($('#cbo_menutype').val()=="") {
                $("#err3").fadeTo(200,0.1,function(){ 
                    $(this).html('Mời chọn kiểu Menu cần hiển thị').fadeTo(900,1);
                });
                $('#cbo_menutype').focus();
                return false;
            }
        }
        return true;
    }
    function select_type(){
        var txt_viewtype=document.getElementById("txt_type");
        var cbo_viewtype=document.getElementById("cbo_type");
        for(i=0;i<cbo_viewtype.length;i++){
            if(cbo_viewtype[i].selected==true)
                txt_viewtype.value=cbo_viewtype[i].value;
        }
        document.frm_type.submit();
    }
</script>