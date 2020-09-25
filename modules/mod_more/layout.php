<?php
$MOD='more';
$theme = 'default';
if($r['theme']!='') $theme = $r['theme']; ?>
<div class="module <?php echo " ".$r['class'];?>">
	<?php if($r['viewtitle']==1){?>
	<div class="main-title"><?php echo $r['title'];?></div>
	<?php } ?>
	<?php include(MOD_PATH."mod_$MOD/brow/".$theme.".php");?>
</div>
<?php unset($obj); unset($r);?>