<?php
$get_id = isset($_GET['id']) ? antiData($_GET['id']) : 0;
$res_cons = SysGetList('tbl_content', [], "AND id='".$get_id."'");
if(count($res_cons) <= 0){
	echo "Không có dữ liệu";
	exit();
}
$row = $res_cons[0];
$res_cates = SysGetList('tbl_categories', [], "AND id='".$row['cat_id']."'");
$res_cate = $res_cates[0];
$cate_link = ROOTHOST.$res_cate['alias'];

$str_ids_parent = str_replace('_', ',', $res_cate['path']);
$res_children = SysGetList('tbl_categories', [], " AND `id` IN(".$str_ids_parent.")");
function convertDate($date){
	$thu = date('I');
	switch ($thu) {
		case '0':
		$day = 'Thứ hai';
		break;
		case '1':
		$day = 'Thứ ba';
		break;
		case '2':
		$day = 'Thứ tư';
		break;
		case '3':
		$day = 'Thứ năm';
		break;
		case '4':
		$day = 'Thứ sáu';
		break;
		case '5':
		$day = 'Thứ bảy';
		break;
		case '6':
		$day = 'Chủ nhật';
		break;
		
		default:
		$day = 'Thứ hai';
		break;
	}
	return $day.', '.date('d/m/Y, H:i');
}
?>
<section class="component">
	<div class="page page-detail">
		
		<div class="page-content">
			<div class="row">
				<div class="col-md-8 col-lg-9">
					<div class="header-content">
						<ol class="breadcrumb" style="margin-bottom: 5px;">
							<li class="breadcrumb-item"><a href="<?php echo ROOTHOST.'tin-tuc';?>">Tin tức</a></li>
							<?php
							foreach ($res_children as $key => $value) {
								$bre_title = $value['title'];
								$bre_link = ROOTHOST.$value['alias'];
								echo '<li class="breadcrumb-item"><a href="'.$bre_link.'">'.$bre_title.'</a></li>';
							}
							?>
						</ol>
						<span class="date"><?php echo convertDate($row['cdate']); ?></span>
					</div>

					<?php
					if($row['link_youtube'] != ''){
						echo '<div class="video-item">
						<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="'.$row['link_youtube'].'" allowfullscreen></iframe>
						</div>
						</div>';
					}
					?>

					<div class="page-header">
						<h1><?php echo $row['title'];?></h1>
					</div>
					
					<article class="post_detail"><?php echo $row['fulltext'];?></article>
					<br/>
					<p class="text-right"><strong><?php echo $row['pseudonym'];?></strong></p>

					<?php
					$res_relateds = SysGetList('tbl_content', [], "AND id <> ".$get_id." AND cat_id=".$res_cate['id']." AND status=4 LIMIT 0,3");
					if(count($res_relateds)>0){
						?>
						<div class="widget-related-posts">
							<?php
							foreach ($res_relateds as $key => $value) {
								$rel_link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
								$rel_title = $value['title'];
								$rel_thumb = getThumb('', 'img-fluid', $rel_title);
								$rel_sapo = Substring($value['sapo'], 0, 60);

								echo '<article class="post-item related">
								<p class="post-thumb post-thumb-120" data-src="'.$value['images'].'">
								<a href="'.$rel_link.'" title="'.$rel_title.'">'.$rel_thumb.'</a>
								</p>
								<h3 class="post-title"><a href="'.$rel_link.'" title="'.$rel_title.'">'.$rel_title.'</a></h3>
								<div class="post-sapo">'.$rel_sapo.'</div>
								</article>';
							}
							?>
						</div>
					<?php } ?>
				</div>
				<div class="col-md-4 col-lg-3">
					<aside class="wg-left-aside">
						<?php $tmp->loadModule('ads5') ;?>
						<aside class="aside"><?php $tmp->loadModule('ads3') ;?></aside>
						<aside class="aside"><?php $tmp->loadModule('ads4') ;?></aside>
					</aside>
				</div>
			</div>
		</div>
	</div>
</section>