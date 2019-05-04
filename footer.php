<!-- Footer Area -->
		<footer id="footer" class="footer-area footer--2">
			<div class="footer__wrapper bg-image--16 section-padding--lg">
				<div class="container">
					<div class="row">
						<!-- Start Single Widget -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="footer__widget">
								<div class="ftr__details">
									<p>Trường mầm non Vành Khuyên</p>
								</div>
								<div class="ftr__address__inner">
									<div class="footer__social__icon">
										<ul class="dacre__social__link--2 d-flex justify-content-start">
											<li class="facebook"><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
											<li class="twitter"><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
											<li class="vimeo"><a href="https://vimeo.com/"><i class="fa fa-vimeo"></i></a></li>
											<li class="pinterest"><a href="https://www.pinterest.com/"><i class="fa fa-pinterest-p"></i></a></li>
										</ul>
									</div>
									<div class="ft__btm__title">
										<h4>Giới thiệu</h4>
									</div>
								</div>
							</div>
						</div>
						<!-- End Single Widget -->
						<!-- Start Single Widget -->
						<div class="col-lg-4 col-md-6 col-sm-12 sm-mt-40">
							<div class="footer__widget">
								<h4>Tin mới nhất</h4>
								<div class="footer__innner">
									<div class="ftr__latest__post">
										<!-- Start Single -->
										<?php
										$query_tt_mn = "SELECT * FROM tintuc ORDER BY id DESC LIMIT 0,3";
										$results_tt_mn = mysqli_query($dbc,$query_tt_mn);
										foreach($results_tt_mn as $item_tt)
										{
										?>
										<div class="single__ftr__post d-flex">
											<div class="ftr__post__details">
												<h6><a href="bai-viet-chi-tiet.php?id=<?php echo $item_tt['id'] ?>"><?php echo $item_tt['tieude']; ?></a></h6>
											</div>
										</div>
										<!-- End Single -->
										<?php
										}
										?>
									</div>
								</div>
							</div>
						</div>
						<!-- End Single Widget -->
						<!-- Start Single Wedget -->
						<div class="col-lg-2 col-md-6 col-sm-12 md-mt-40 sm-mt-40">
							<div class="footer__widget">
								<h4>DANH MỤC</h4>
								<div class="footer__innner">
									
									<div class="ftr__latest__post">
										<ul class="ftr__catrgory">
											<?php
											$query_dm = "SELECT * FROM loaitin WHERE the_loai_cha = 0";
											$results_dm = mysqli_query($dbc,$query_dm);
											foreach($results_dm as $item_dm)
											{
											?>
											<li><a href="#"><?php echo $item_dm['ten']; ?></a></li>
											<?php
											}
											?>
											<li><a href="#">Hoạt động</a></li>
											<li><a href="#">Liên hệ</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- End Single Wedget -->
						<!-- Start Single Widget -->
						<div class="col-lg-3 col-md-6 col-sm-12 md-mt-40 sm-mt-40">
							<div class="footer__widget">
								<h4>LIÊN HỆ</h4>
								<div class="footer__innner">
									<div class="dcare__twit__wrap">
										<!-- Start Single -->
										<div class="dcare__twit d-flex">
											<div class="dcare__twit__details">
												<span>SĐT: 0909090909</span>
												<br><span>EMAIL: vanhkhuyen@gmail.com</span></br>
											</div>
										</div>
										<!-- End Single -->
									</div>
								</div>
							</div>
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
			<div class="copyright  bg--theme" style="background: #0195e8">
				<div class="container">
					<div class="row align-items-center copyright__wrapper justify-content-center">
						<div class="col-lg-12 col-sm-12 col-md-12">
							<div class="coppy__right__inner text-center">
								<p>Tiểu Luận Tốt Nghiệp - Đề Tài: Trường Mầm Non Vành Khuyên</p>
								<p>SVTH:Nguyễn Minh Nhựt-1500606 &amp; Nguyễn Thị Yến Ly-1500863</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- //Footer Area -->

	</div><!-- //Main wrapper -->

	<!-- JS Files -->
	<script src="js/vendor/jquery-3.2.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>
	<script src="js/active.js"></script>
</body>
</html>
