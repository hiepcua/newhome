<?php
require_once(libs_path."gfclass/cls.simple_image.php");
if(!isset($clsimage)) $clsimage = new SimpleImage();
if(!isset($objcon)) $objcon = new CLS_CONTENTS();
if(!isset($obj)) $obj = new CLS_MYSQL;

$objcon->getList($objmodule->CatID," order by `con_id` DESC LIMIT 0,1");
$class=$objmodule->Class;
?>
<div class="module <?php echo $objmodule->Class;?>">
    <div class="content">
    	<?php 
		$objcon->getAllList(" AND cat_id=".$objmodule->CatID." ORDER BY RAND() LIMIT 0,1" );
		$i=1;
		echo '<div class="know_intro">';
		while ($rows = $objcon->FetchArray()) {
			$title = stripslashes($rows["title"]);
			$intro = stripslashes(trim($rows["intro"]));
			$img = $rows["thumb_img"];
			$width="100%";
			if($img!='') $img='<img src="'.$img.'" title="'.$title.'" align="left" class="img_block"/>';
			
			if($i==2) $class='intro_right';
			else $class='';			
			?>
            <div class="news <?php echo $class;?>">
                <div class="intro">
                    <div class="news_content"><img src="<?php echo THIS_TEM_PATH; ?>images/open-quotes.png" /><?php echo $intro; ?><img src="<?php echo THIS_TEM_PATH; ?>images/open-quotes1.png" /></div>
                    <a class="btn_detail2" href="index.php?com=contents&viewtype=block&catid=75">Xem thêm</a>	
                </div>
            </div>
            
            <?php 
            if($i==2) echo '<div class="course_space">&nbsp;</div>';
            if($i==1) $i=2; else $i=1;
		}
		echo '</ul></div>';
		?>
    </div>
</div>


<?php
unset($obj);
unset($objcon);
unset($objmodule);
unset($clsimage);
?>