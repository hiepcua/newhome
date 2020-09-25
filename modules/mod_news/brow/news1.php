<?php 
require_once("libs/cls.category.php");
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($objcat)) $objcat = new CLS_CATEGORY();
?>
<div class="module <?php echo $r['class'];?>">
	<?php
	$catid = $str = '';
	$order = "ORDER BY cdate DESC";
	$limit = "LIMIT 0, 2"; 
	if($r['category_id'] > 0){
		$res_category = $objcat->getInfo(" AND id = " . $r['category_id']);
		$objcon->getList(" AND category_id = " . $r['category_id']," $order ");
	}
	?>

	<h3>Tin tức tại <span class="i-color">THC</span></h3>
	<div class="line-bottom"><img src="<?= ROOTHOST ?>images/hinh-anh/icon-1.png"></div>
	<div class="section-intro text-center">Thường xuyên theo rõi cập nhật tin tức tại THC để có những kiến thức về chăm sóc xe và các dịch vụ khuyến mãi từ chúng tôi</div>

	<?php
	if($objcon->Num_rows()>0) {
		$str.= '<div id="owl7" class="owl-carousel owl-theme">';
		while ($item = $objcon->Fetch_Assoc()) {
			$title = stripslashes($item["title"]);
			$code = stripslashes($item["code"]);
			$image = stripcslashes($item['thumb']);
			$link = ROOTHOST.Un_unicode($res_category['name']).'/'.stripslashes($item["code"]).'.html';
			$intro = Substring($item["intro"], 0, 20);

			$str.= '<div class="item">';
			$str.= '<a href="'.$link.'" title="'.$title.'"><img src="'.$image.'" class="thumb img-responsive"></a>';
			$str.= '<a href="'.$link.'" title="'.$title.'" class="title"><h4>'.$title.'</h4></a>';
			$str.= '<div class="p-meta">';
			$str.= '<p class="p-meta-intro">'.$intro.' [...]</p>';
			$str.= '<a href="'.$link.'" title="Xem thêm" class="btn_view_more">Xem thêm <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>';
			$str.= '</div>';
			$str.= '</div>';
		}
		$str.= '</div>';
	}

	echo $str;
	?>
</div>
