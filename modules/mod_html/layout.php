<?php 
$MOD='html';
$theme = 'default';
if($r['theme']!='') 
	$theme = $r['theme'];
?>
<div class="module module-html<?php echo " ".$r['class'];?>">
	<?php if($r['viewtitle']==1){?>
	<div class="title"><?php echo $r['title'];?></div>
	<?php }
	echo html_entity_decode($r['content']);
	?>
</div>
<?php
unset($obj); unset($r);
?>