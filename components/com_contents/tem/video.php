<?php
define('OBJ_PAGE','LIST_VIDEOS');
$cate_title=''; $strWhere = "";
$res_cates = SysGetList('tbl_categories', [], "AND alias='video'");

if(count($res_cates) > 0){
	$cate_title = $res_cates[0]['title'];
	$strWhere = "AND cat_id='".$res_cates[0]['id']."'";

	/*Begin pagging*/
	if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
	}
	if(isset($_POST['txtCurnpage'])){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
	}

	$total_rows=SysCount('tbl_content',$strWhere);
	$max_rows = 10;

	if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
	}
	$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
	/*End pagging*/

	$star = ($cur_page - 1) * $max_rows;
	$res_cons = SysGetList('tbl_content', [], $strWhere." ORDER BY cdate DESC LIMIT ".$star.",".$max_rows);
}
?>
<section class="component">
	<div class="page page-videos">
		<div class="page-content">
			<div class="row">
				<div class="col-md-8 col-lg-9">
					<div class="page-header">
						<h1><?php echo $cate_title;?></h1>
					</div>
					<div class="row custom-row">
						<?php
						if(count($res_cons) > 0){
							foreach ($res_cons as $key => $value) {
								$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
								$title = $value['title'];
								$thumb = getThumb('', 'img-fluid', $title);
								$sapo = Substring($value['sapo'], 0, 60);

								echo '<div class="col-md-6 custom-col">
								<div class="video-item">
								<a href="'.$link.'" title="'.$title.'">
								<div class="video-thumb wrap-thumb-220" data-src="'.$value['images'].'">'.$thumb.'</div>
								<div class="video-title">'.$title.'</div>
								</a>
								</div>
								</div>';
							}

							echo '<div class="pagging">';
							paging($total_rows,$max_rows,$cur_page);
							echo '</div>';
						}
						?>
					</div>
				</div>
				<div class="col-md-4 col-lg-3">
					<aside class="wg-left-aside">
						<?php $tmp->loadModule('ads5') ;?>
					</aside>
				</div>
			</div>
		</div>
	</div>
</section>