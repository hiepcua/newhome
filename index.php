<?php
ob_start();
session_start();
ini_set('display_errors',1);
define('incl_path','global/libs/');
define('libs_path','libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(libs_path.'cls.mysql.php');
require_once(libs_path.'cls.template.php');
define('ISHOME',true);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$tmp = new CLS_TEMPLATE();
$res_configs = SysGetList('tbl_configsite', []);
$res_config = $res_configs[0];

$res_seos = SysGetList('tbl_seo', [], "AND `link`='".$actual_link."'");
if(count($res_seos)>0){
	$res_seo = $res_seos[0];
	$seo_url = $res_seo['link'];
	$seo_title = $res_seo['title'];
	$seo_key = $res_seo['meta_key'];
	$seo_desc = $res_seo['meta_desc'];
	$seo_image = $res_seo['image'];
}else{
	$seo_url = $actual_link;
	$seo_title = $res_config['title'];
	$seo_key = $res_config['meta_keyword'];
	$seo_desc = $res_config['meta_descript'];
	$seo_image = $res_config['image'];
}

global $tmp;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $seo_title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:url"           content="<?php echo $seo_url;?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="<?php echo $seo_title;?>" />
	<meta property="og:description"   content="<?php echo $seo_desc;?>" />
	<meta property="og:image"         content="<?php echo $seo_image;?>" />

	<!-- CSS only -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/style.css">
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/fontawesome-free/css/all.min.css">
</head>
<body id="body">
	<div class="wrapper">
		<!-- Banner -->
		<?php include 'modules/home-banner.php';?>
		<!-- /.Banner -->

		<!-- Header Start -->
		<?php include 'modules/header.php';?>
		<!-- Header End -->

		<!-- Left Sidebar Start -->
		<?php include 'modules/left_sidebar.php';?>
		<!-- Left Sidebar End -->

		<!-- Content Wrapper. Contains page content -->
		<div id="main-content">
			<div class="container content-wrapper">
				<?php 
				$com=isset($_GET['com'])?$_GET['com']:'frontpage';
				include_once('components/com_'.$com.'/layout.php');
				?>
			</div>
		</div>
		<!-- /.content-wrapper -->

		<!-- Footer Start -->
		<?php include 'modules/footer.php';?>
		<!-- Footer End -->
	</div>
	<!-- Bootstrap 4 -->
	<!-- <script src="<?php echo ROOTHOST;?>global/plugins/moment/moment.min.js"></script>
	<script src="<?php echo ROOTHOST;?>global/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
	<!-- JS, Popper.js, and jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="<?php echo ROOTHOST;?>global/js/custom.js"></script>
</body>
</html>
