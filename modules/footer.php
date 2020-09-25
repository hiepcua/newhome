<?php
$res_configs = SysGetList('tbl_configsite', []);
$res_config = $res_configs[0];
?>
<footer>
	<div class="container bg-fff main-footer">
		<div class="line-vertical"></div>
		<div class="text-center">
			<ul class="list-social">
				<li><a href="<?php echo $res_config['facebook'];?>"><i class="fab fa-facebook-f"></i></a></li>
				<li><a href="<?php echo $res_config['twitter'];?>"><i class="fab fa-twitter"></i></a></li>
				<li><a href="<?php echo $res_config['youtube'];?>"><i class="fab fa-youtube"></i></a></li>
			</ul>
		</div>
		<div class="content">
				<div class="text-center">
					<h2 class="brand-name"><a href="<?php echo ROOTHOST;?>"><?php echo $res_config['title'];?></a></h2>
					<ul class="list-unstyle">
						<li><span class="lab">Số điện thoại:</span> <?php echo $res_config['tel'];?></li>
						<li><span class="lab">Email:</span> <?php echo $res_config['email'];?></li>
						<li><span class="lab">Thời gian làm việc:</span> <?php echo $res_config['work_time'];?></li>
						<li><span class="lab">Địa chỉ:</span> <?php echo $res_config['address'];?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright"><div class="container">Copyright © 2020 <strong>chunhatvang.vn</strong>. All rights reserved.</div></div>
</footer>