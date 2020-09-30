<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo ROOTHOST_ADMIN;?>">Admin</a></li>
        <li><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Thư viện ảnh</a></li>
        <li class="active">Thêm thư viện ảnh</li>
    </ol>
</div>

<div class="com_header color" style="margin-bottom: 0px;">
    <h1>Thêm thư viện ảnh</h1>
    <div class="pull-right">
        <form id="frm_menu" name="frm_menu" method="post" action="">
            <input type="hidden" name="txtorders" id="txtorders" />
            <input type="hidden" name="txtids" id="txtids" />
            <input type="hidden" name="txtaction" id="txtaction" />

            <ul class="list-inline">
                <li><a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</a></li>
                <li><a class="btn btn-default"  href="<?php echo ROOTHOST_ADMIN.COMS;?>" title="Đóng"><i class="fa fa-sign-out" aria-hidden="true"></i> Đóng</a></li>
            </ul>
        </form>
    </div>
</div>
<div class="clearfix"></div>

<div class="box-tabs">
    <ul class="nav nav-tabs step-form" role="tablist">
        <li class="">
            <a href="#home" role="tab" data-toggle="tab">
                <div class="item">
                    <span class="ic-step">01</span>
                    <p>Album</p>
                    <label>Thông tin album</label>
                </div>
            </a>
        </li>

        <li class="active"><a href="#about" role="tab" data-toggle="tab">
                <div class="item">
                    <span class="ic-step">02</span>
                    <p>Thư viện ảnh</p>
                    <label>Upload ảnh</label>
                </div>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade " id="home">
            <div class="col-md-6">
                <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
                    <?php
                    $id=isset($_GET['id'])? (int)$_GET['id']:'';
                    $obj->getListAlbum(" WHERE `id`='".$id."'");
                    $row=$obj->Fetch_Assoc();
                    ?>
                    <input type="hidden" name="txtid" class="form-control"  value="<?php echo $row['id'];?>">
                    <div class="form-group row">
                        <label for="" class="col-sm-3 form-control-label">Tên album *</label>
                        <div class="col-sm-9">
                            <input type="text" name="txt_name" class="form-control" id="txt_name" value="<?php echo $row['name'];?>" placeholder="">
                            <div id="txt_name_err" class="mes-error"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 form-control-label">Hình ảnh*</label>
                        <div class="col-sm-9">
                            <input type="text" name="txtthumb" class="form-control" id="txtthumb" value="<?php echo $row['thumb'];?>" placeholder="">
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="form-group">
                        <label for="" class="form-control-label"> Tóm tắt</label>
                        <textarea name="txt_intro" id="txt_intro" style="min-height: 80px" class="form-control"><?php echo $row['intro'];?></textarea>
                    </div>
                    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
                </form>
            </div>
        </div>

        <div class="tab-pane fade active in" id="about">
            <form id="frm-upload-img" class="" enctype="multipart/form-data">
                <input type="hidden" name="album_id" class="form-control"  value="<?php echo $row['id'];?>">
                <input type="hidden" name="txt_parid" class="form-control"  value="<?php echo $row['id'];?>">
                <div class="box-select" style="margin-bottom: 12px;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h4 for="" class="form-control-label" style="margin-bottom: 15px; margin-top: 0px;">Upload thư viện ảnh</h4>

                            <div class="clearfix"></div>
                            <div class="row">
                                <div class='form-group col-md-8'>
                                    <input name="txt_image" type="text" id="txt_image" class="form-control" placeholder="Tên ảnh"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class='form-group col-md-8 col-action'>
                                    <input name="fileImg[]" type="file" id="file-img" class="form-control"/>
                                </div>
                                <div class='form-group col-md-4'>
                                    <input class="btn btn-success" type="submit" value="Upload">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <b>Lưu ý khi upload ảnh:</b><br/><br/>
                            1 - Chỉ được phép upload các định dạng: JPEG,PNG,JPG.<br/>
                            2 - Dung lượng ảnh <1M.<br/>
                            3 - Tên ảnh viết thường không dấu, không chứa dấu cách, các ký tự đặc biệt.<br/>
                            4 - Upload thư viện gallery theo tỉ lệ 16/9 để đảm bảo ảnh hiển thị đẹp, không bị bóp méo.<br/>
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
            </form>

            <h4 style="margin: 0px;">Danh sách ảnh Upload</h4>
            <div id="respon-img">
                <?php
                $sql = "SELECT * FROM `tbl_gallery` WHERE album_id = ".$id;
                $objmysql->Query($sql);
                while($rows = $objmysql->Fetch_Assoc()){
                    $id = $rows['id'];
                    $path = $rows['link'];
                    $name = Substring(stripslashes($rows['name']),0,4);
                    ?>
                    <div class="info-item">
                        <img src="<?php echo $path;?>" width="150px">
                        <div class="name"><?php echo $name;?></div>
                        <div class="wrap-item-info">
                            <div class="del-item" value="<?php echo $id;?>" title="Xóa"></div>
                            <div class="edit-item" value="<?php echo $id;?>" title="Đổi tên"></div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <script type="text/javascript">
                    /*del image*/
                    $('#respon-img .del-item').click(function(){
                        if(confirm("Bạn có muốn chắc xóa ảnh này")){
                            var imgId   = $(this).attr('value');
                            var par_id  = $('#par_id').val();
                            $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/delImage.php',{imgId, par_id}, function(response_data){
                                // console.log(response_data);
                            });
                            var parent= $(this).parent().parent();
                            parent.remove();
                        }
                        else return false;
                    });
                    $('#file-img').val("");

                    /*edit name image*/
                    $('.edit-item').click(function(){
                        var id=$(this).attr('value');
                        var par_id=$('#par_id').val();
                        $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/frm_edit.php',{id, par_id},function(response_data){
                            $('#myModalPopup').modal('show');
                            $('#myModalLabel').html('Rename');
                            $('#data-frm').html(response_data);
                        });
                    });

                </script>
            </div>
        </div>
    </div>
</div>

<script language="javascript">
	function checkinput(){
		if($("#txt_name").val()==""){
			$("#txt_name_err").fadeTo(200,0.1,function(){
				$(this).html('Vui lòng nhập tiêu đề').fadeTo(900,1);
			});
			$("#txt_name").focus();
			return false;
		}
		return true;
	}

    $(document).ready(function(){
		/* add gallery */
		$("#frm-upload-img").submit(function(event){
			if($('#txt_image').val()==''){
				alert('Tên ảnh là bắt buộc!');
				$('#txt_image').focus();
				return false;
			}
			if($('#file-img').val()!= ''){
				event.preventDefault();
				var formData = new FormData($(this)[0]);
				$.ajax({
					url: '<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/uploadImage.php',
					type: 'POST',
					data: formData,
					async: false,
					cache: false,
					contentType: false,
					processData: false,
					success: function (returndata) {
						$('#respon-img').html(returndata);
					}
				});
			}
			else{
				alert('Choose link Images is Require!')
			}
			$('#file-img').val("");
			$('#txt_image').val("");
			return false;
		});
   });
</script>
