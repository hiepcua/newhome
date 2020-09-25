<section class="section-testmonial section">
	<div class="container">
		<div class="heading text-center">
			<h3 class="title h4">CẢM NHẬN CỦA KHÁCH HÀNG VỀ DỊCH VỤ CỦA CHÚNG TÔI</h3>
		</div>
		<div class="testmonials">
			<?php
			$objmysql = new CLS_MYSQL();
			$sql="SELECT * FROM tbl_feedback WHERE isactive = 1";
			$objmysql->Query($sql);
			while ($row = $objmysql->Fetch_Assoc()) {
				?>
				<div class="item testmonial-item">
					<div class="avatar">
						<img class="rounded-circle" src="<?php echo $row['avatar']; ?>" alt="<?php echo $row['name']; ?>">
					</div>
					<div class="desc">
						<blockquote><?php echo $row['comment']; ?></blockquote>
						<div class="author"><span><?php echo $row['name']; ?></span> - <?php echo $row['career']; ?></div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<script type="text/javascript">
	$('.testmonials').slick({
		speed: 700,
		prevArrow: false,
    	nextArrow: false,
		slidesToShow: 3,
		slidesToScroll: 3,
		dots: true,
		autoplay: true,
  		autoplaySpeed: 2000,
		responsive: [
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
		]
	});
</script>