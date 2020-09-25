<?php
define('OBJ_PAGE','SEARCH_CONTENT');
$cur_page = isset($_GET['page']) ? antiData($_GET['page']) : 1;
$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';
$strWhere = "";
if($get_q!==''){
	$strWhere .= "AND title LIKE '%".$get_q."%'";
}

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
$res_cons = SysGetList('tbl_content', [], $strWhere." LIMIT ".$star.",".$max_rows);
?>
<section class="component">
	<div class="page page-block-content">
		<div class="page-header">
			<h1>Tin tức</h1>
			<p style="font-size: 1.2em;">Tìm thấy <strong><?php echo count($res_cons);?></strong> bài viết liên quan đến từ khóa <strong><?php echo $get_q;?></strong>.</p>
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-md-8 col-lg-9">
					<div class="list-posts">
						<?php
						foreach ($res_cons as $key => $value) {
							$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
							$title = $value['title'];
							$thumb = getThumb($value['images'], 'img-fluid', $title);
							$sapo = Substring($value['sapo'], 0, 60);
							echo '<article class="post">
							<div class="post-content">
							<div class="post-thumb"><a href="'.$link.'" title="'.$title.'">'.$thumb.'</a></div>
							<div class="post-meta">
							<h3 class="title"><a href="'.$link.'" title="">'.$title.'</a></h3>
							<div class="desc">'.$sapo.'</div>
							</div>
							</div>
							</article>';
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