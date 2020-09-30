<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$clsimage = new SimpleImage();
$id=0;
if(isset($_GET["id"])) 
	$id = (int)$_GET["id"];
if(!isset($_SESSION["CUR_PAGE_CON"]))
	$_SESSION["CUR_PAGE_CON"]=1;
if(isset($_POST["txtCurnpage"])){	
	$_SESSION["CUR_PAGE_CON"]=$_POST["txtCurnpage"];
}
$cur_page=$_SESSION["CUR_PAGE_CON"];
	
if(!isset($objcat)) $objcat = new CLS_CATE;
$id = $id."','".$objcat->getCatIDChild('',$id);
unset($objcat);
?>
<div class="content_body">
<?php
$obj->getList(" AND `cat_id` in ('$id') ");
$total_rows=$obj->Num_rows();
if($total_rows>0){
	$start_r=($cur_page-1)*MAX_ITEM;
	$obj->getList(" AND `cat_id` in ('$id') ",' ORDER BY `modifydate` DESC '," LIMIT $start_r,".MAX_ITEM);
	while($rows=$obj->Fetch_Assoc()){
		$title = stripslashes($rows["title"]);
		$intro = stripslashes($rows["intro"]);
		$fulltext=stripslashes($rows["fulltext"]);
		$img = $rows["thumb_img"];
		if($img=='')
			$img=$clsimage->get_image($fulltext);
		$img='<img src="'.$img.'" title="'.$title.'" alt='.$title.' align="left" class="img_block"/>';
?>
<div class='item'>
<h2 class='title' title='<?php echo $title;?>'>
	<a class="news_title" href="<?php echo ROOTHOST;?><?php echo un_unicode($title);?>-a.<?php echo $rows["con_id"]; ?>.html">		
		<?php echo $title;?>
	</a>
</h2>
<div class='intro'>
	<?php echo $img.$intro;?>
</div>
</div>
<?php 
} 
?>
<div id="paging_index"><?php paging_index($total_rows,MAX_ROWS_INDEX,$cur_page); ?></div>
<?php
} 
else { echo 'Hệ thống đang cập nhật. Vui lòng quay lại mục này sau.';}?>
</div>