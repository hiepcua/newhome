<?php
$MOD='mainmenu';
$obj=new CLS_MODULE;
$obj->getList(' AND `id`='.$r["id"]);
$theme = 'brow1';
if($r['theme']!='') 
	$theme=$r['theme'];

?>
<div class="module <?php echo " ".$r['class'];?>">
	<?php if($r['viewtitle']==1){?>
	<div class="title"><?php echo $r['title'];?></div>
	<?php }
	include(MOD_PATH."mod_$MOD/brow/".$theme.".php");
	?>
</div>
<?php unset($obj); unset($r);?>