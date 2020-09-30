<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<link rel="stylesheet" href="<?php echo ROOTHOST.THIS_TEM_ADMIN_PATH;?>css/searchableOptionList.css">
<script src="<?php echo ROOTHOST.THIS_TEM_ADMIN_PATH;?>js/searchableOptionList.js"></script>
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
</script>

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

<div class="box-tabs col-md-12">
	<ul class="nav nav-tabs step-form" role="tablist">
		<li class="active">
			<a href="#home" role="tab" data-toggle="tab">
				<div class="item">
					<span class="ic-step">01</span>
					<p>Album</p>
					<label>Thông tin album</label>
				</div>
			</a>
		</li>

		<li class=""><a href="#about" role="tab" data-toggle="tab">
				<div class="item">
					<span class="ic-step">02</span>
					<p>Thư viện ảnh</p>
					<label>Upload ảnh</label>
				</div>
			</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade active in" id="home">
			<div class="row">
				<form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="" class="col-sm-3 form-control-label">Tên Album *</label>
							<div class="col-sm-9">
								<input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
								<div id="txt_name_err" class="mes-error"></div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class='form-group row'>
							<label class="col-sm-3 control-label">Hình ảnh *</label>
							<div class="col-sm-9">
								<div class="row">
									<div class="col-sm-9">
										<input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="" placeholder='' />
									</div>
									<div class="col-sm-3">
										<a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
									</div>
									<div id="txt_thumb_err" class="mes-error"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="form-control-label"> Tóm tắt</label>
							<textarea name="txt_intro" id="txt_intro" style="min-height: 80px" class="form-control" placeholder="Mô tả về album"></textarea>
						</div>
						<input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
						<div class="text-center toolbar">
							<div style="height: 20px;"></div>
							<a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<div class="tab-pane fade" id="about">
			<p>Nhập thông tin album trước khi Upload thư viện ảnh</p>
		</div>
	</div>
</div>
