<?php
define('OBJ_PAGE','BLOCK_CONTENT');
$cur_page = isset($_GET['page']) ? antiData($_GET['page']) : 1;
$get_code = isset($_GET['code']) ? antiData($_GET['code']) : '';
$res_cates = SysGetList('tbl_categories', [], "AND alias='".$get_code."'");

if(count($res_cates) <= 0){
	echo "Không có dữ liệu";
	exit();
}
$res_cate = $res_cates[0];
$cate_link = ROOTHOST.$res_cate['alias'];
$strWhere = "AND cat_id=".$res_cate['id'];

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
?>
<section class="component">
	<div class="page page-block-content">
		<div class="page-header">
			<h1><?php echo $res_cate['title'];?></h1>
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-md-8 col-lg-9">
					<?php
					if(count($res_cons)>0){
						$b_post = $res_cons[0];
						$b_link = ROOTHOST.$b_post['alias'].'-'.$b_post['id'].'.html';
						$b_title = $b_post['title'];
						$b_thumb = getThumb('', 'img-fluid', $b_title);
						$b_sapo = Substring($b_post['sapo'], 0, 40);
						?>
						<article class="big-post">
							<div class="post-content">
								<div class="post-thumb big-post-thumb" data-src="<?php echo $b_post['images'];?>"><a href="<?php echo $b_link;?>" title="<?php echo $b_title;?>"><?php echo $b_thumb;?></a></div>
								<div class="post-meta">
									<h2 class="title"><a href="<?php echo $b_link;?>" title="<?php echo $b_title;?>"><?php echo $b_title;?></a></h2>
									<div class="desc"><?php echo $b_sapo;?></div>
								</div>
							</div>
						</article>
						<hr/>
					<?php } ?>
					<div class="list-posts">
						<?php
						foreach ($res_cons as $key => $value) {
							if($key > 0){
								$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
								$title = $value['title'];
								$thumb = getThumb('', 'img-fluid', $title);
								$sapo = Substring($value['sapo'], 0, 60);
								echo '<article class="post">
								<div class="post-content">
								<div class="post-thumb post-thumb-120" data-src="'.$value['images'].'"><a href="'.$link.'" title="'.$title.'">'.$thumb.'</a></div>
								<div class="post-meta">
								<h3 class="title"><a href="'.$link.'" title="">'.$title.'</a></h3>
								<div class="desc">'.$sapo.'</div>
								</div>
								</div>
								</article>';
							}
						}
						?>
					</div>
					<div class="pagging">
						<?php paging($total_rows,$max_rows,$cur_page); ?>
					</div>
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