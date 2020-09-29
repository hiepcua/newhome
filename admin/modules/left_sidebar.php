<?php
$isAdmin=getInfo('isadmin');
$userLogin = getInfo('username');
$permis = [1,2,3,4,5,6,7,8,9];
if($isAdmin==1){
	$n_content1 = SysCount('tbl_content', 'AND status=1');
	$n_content4 = SysCount('tbl_content', 'AND status=4');
	$n_content5 = SysCount('tbl_content', 'AND status=5');
	$n_content6 = SysCount('tbl_content', 'AND ishot=1');
	$n_request 	= SysCount('tbl_request', 'AND isactive=1');
}else{
	$n_content1 = SysCount('tbl_content', 'AND status=1 AND author="'.$userLogin.'"');
	$n_content4 = SysCount('tbl_content', 'AND status=4 AND author="'.$userLogin.'"');
	$n_content5 = SysCount('tbl_content', 'AND status=5 AND author="'.$userLogin.'"');
	$n_content6 = SysCount('tbl_content', 'AND ishot=1 AND author="'.$userLogin.'"');
}

?>
<style type="text/css">
	.nav-sidebar>.nav-item .nav-icon.fa, .nav-sidebar>.nav-item .nav-icon.fab, .nav-sidebar>.nav-item .nav-icon.far, .nav-sidebar>.nav-item .nav-icon.fas, .nav-sidebar>.nav-item .nav-icon.glyphicon, .nav-sidebar>.nav-item .nav-icon.ion{font-size: 1rem;}
</style>
<nav class="mt-2 pb-5">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		<li class="nav-item menu-open">
			<a href="<?php echo ROOTHOST;?>content" class="nav-link <?php activeMenu('content', '', 'com');?>">
				<i class="nav-icon far fa-calendar-alt"></i>
				<p>Bài viết <i class="right fas fa-angle-left"></i></p>
			</a>
			<ul class="nav nav-treeview">
				<?php if(in_array('1', $permis)){ ?>
					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>content/add" class="nav-link <?php activeMenu('content','add','viewtype');?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Thêm mới</p>
						</a>
					</li>
				<?php } ?>

				<?php if(in_array('1', $permis)){ ?>
					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>content/write?status=1" class="nav-link <?php activeMenu('content','write','viewtype');?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Lưu nháp <span class="badge badge-info right"><?php echo $n_content1;?></span></p>
						</a>
					</li>
				<?php } ?>
				
				<?php if(in_array('4', $permis)){ ?>
					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>content/public?status=4" class="nav-link <?php activeMenu('content','waiting_public','viewtype'); activeVodMenuByStatus(4);?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Đã xuất bản <span class="badge badge-info right"><?php echo $n_content4;?></span></p>
						</a>
					</li>
				<?php } ?>
				
				<?php if(in_array('4', $permis)){ ?>
					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>content/takedown?status=5" class="nav-link <?php activeMenu('content','takedown','viewtype'); activeVodMenuByStatus(5);?>">
							<i class="far fa-circle nav-icon"></i>
							<p>Gỡ xuống <span class="badge badge-info right"><?php echo $n_content5;?></span></p>
						</a>
					</li>
				<?php } ?>
			</ul>
		</li>

		<li class="nav-item">
			<a href="<?php echo ROOTHOST;?>request" class="nav-link <?php activeMenu('request', '', 'com');?> ">
				<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-alarm-fill nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" d="M6 .5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H9v1.07a7.001 7.001 0 0 1 3.274 12.474l.601.602a.5.5 0 0 1-.707.708l-.746-.746A6.97 6.97 0 0 1 8 16a6.97 6.97 0 0 1-3.422-.892l-.746.746a.5.5 0 0 1-.707-.708l.602-.602A7.001 7.001 0 0 1 7 2.07V1h-.5A.5.5 0 0 1 6 .5zM.86 5.387A2.5 2.5 0 1 1 4.387 1.86 8.035 8.035 0 0 0 .86 5.387zM11.613 1.86a2.5 2.5 0 1 1 3.527 3.527 8.035 8.035 0 0 0-3.527-3.527zM8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
				</svg>
				<p>Yêu cầu liên hệ <span class="badge badge-info right"><?php echo $n_request;?></span></p>
			</a>
		</li>

		<?php if($isAdmin){ ?>
			<li class="nav-item menu-open <?php menuOpen(array('setting', 'categories', 'user', 'groupuser', 'mnuitem', 'seo', 'module', 'feedback', 'pages'), 'com'); ?>">
				<a href="<?php echo ROOTHOST;?>setting" class="nav-link <?php activeMenus(array('setting', 'categories', 'user', 'event_group'), 'com'); ?>">
					<i class="nav-icon fas fa-wrench" aria-hidden="true"></i>
					<p>Cấu hình<i class="right fas fa-angle-left"></i></p>
				</a>

				<ul class="nav nav-treeview">
					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>seo" class="nav-link <?php activeMenu('seo', '', 'com');?> ">
							<i class="nav-icon fa fa-server" aria-hidden="true"></i>
							<p>Quản lý SEO</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>categories" class="nav-link <?php activeMenu('categories', '', 'com');?> ">
							<i class="nav-icon fa fa-server" aria-hidden="true"></i>
							<p>Chuyên mục bài viết</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>pages" class="nav-link <?php activeMenu('pages', '', 'com');?> ">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-layout-text-sidebar-reverse nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M2 1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm12-1a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
								<path fill-rule="evenodd" d="M5 15V1H4v14h1zm8-11.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm0 3a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm0 3a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm0 3a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z"/>
							</svg>
							<p>Quản lý page tĩnh</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>feedback" class="nav-link <?php activeMenu('feedback');?>">
							<i class="nav-icon fas fa-comment-dots"></i>
							<p>Feedback</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>mnuitem/1" class="nav-link <?php activeMenu('mnuitem', '', 'com');?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-markdown-fill nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm11.5 1a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L11 9.293V5.5a.5.5 0 0 1 .5-.5zM3.56 7.01V11H2.5V5.001h1.208l1.71 3.894h.04l1.709-3.894h1.2V11H7.294V7.01h-.057l-1.42 3.239h-.773l-1.428-3.24H3.56z"/>
							</svg>
							<p>Quản lý menu</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>slider" class="nav-link <?php activeMenu('slider', '', 'com');?>">
							<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sliders nav-icon" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M14 3.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0zM11.5 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM7 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0zM4.5 10a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm9.5 3.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0zM11.5 15a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
								<path fill-rule="evenodd" d="M9.5 4H0V3h9.5v1zM16 4h-2.5V3H16v1zM9.5 14H0v-1h9.5v1zm6.5 0h-2.5v-1H16v1zM6.5 9H16V8H6.5v1zM0 9h2.5V8H0v1z"/>
							</svg>
							<p>Banner</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>user" class="nav-link <?php activeMenu('user', '', 'com');?>">
							<i class="nav-icon fas fa-user"></i>
							<p>Người dùng</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>module" class="nav-link <?php activeMenu('module', '', 'com');?>">
							<i class="fa fa-cubes nav-icon" aria-hidden="true"></i>
							<p>Modules</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>album" class="nav-link <?php activeMenu('album', '', 'com');?>">
							<i class="nav-icon far fa-circle "></i>
							<p>Album</p>
						</a>
					</li>

					<li class="nav-item">
						<a href="<?php echo ROOTHOST;?>setting" class="nav-link <?php activeMenu('setting', '', 'com');?>">
							<i class="nav-icon fas fa-wrench" aria-hidden="true"></i>
							<p>Cấu hình website</p>
						</a>
					</li>

					
				</ul>
			</li>
		<?php } ?>
	</ul>
</nav>
<script>
	$('.logout').click(function(){
		var _url="<?php echo ROOTHOST;?>ajaxs/user/logout.php";
		$.get(_url,function(){
			window.location.reload();
		})
	})
</script>