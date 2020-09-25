<?php
$res_cons = SysGetList('tbl_content', [], "AND status=4 ORDER BY cdate DESC LIMIT 0,5");
?>
<aside class="aside-lastest-news aside">
	<div class="header"><span class="name">Tin mới</span><span class="line"></span></div>
	<div class="content">
		<?php
		foreach ($res_cons as $key => $value) {
			$link = ROOTHOST.$value['alias'].'-'.$value['id'].'.html';
			$title = $value['title'];
			$thumb = getThumb('', 'img-fluid', $title);
			$sapo = Substring($value['sapo'], 0, 60);
			if($key==0){
				echo '<div class="big post-item">
				<div class="wr-thumb wrap-thumb" data-src="'.$value['images'].'">
				<a href="'.$link.'" title="'.$title.'">'.$thumb.'</a>
				</div>
				<div class="wr-meta">
				<h2><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h2>
				<div class="desc">'.$sapo.'</div>
				</div>
				</div>';
			}else{
				echo '<div class="post-item"><h3><a href="'.$link.'" title="'.$title.'">'.$title.'</a></h3></div>';
			}
		}
		?>
	</div>
</aside>