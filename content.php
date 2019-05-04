<!-- Start Welcame Area -->
<section class="junior__welcome__area section-padding--md bg-pngimage--2">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="section__title text-center">
					<h2 class="title__line">Chào Mừng Bạn Đến Với Vành Khuyên</h2>
					<p>Với mục tiêu là phát triển tốt nhất về trí tuệ và nhân cách trẻ, Trường Mầm Non Vành Khuyên xem tri thức của giáo viên là yêu cầu quan trọng nhất để đạt được mục tiêu này.</p>
				</div>
			</div>
		</div>
	<?php
		$query = "SELECT * FROM tintuc WHERE tieude = 'Giới thiệu về Mầm Non Vành Khuyên' ";
		$result = mysqli_query($dbc, $query);
		foreach ($result as $item)
		{
	?>
		<div class="row jn__welcome__wrapper align-items-center">
			<div class="col-md-12 col-lg-6 col-sm-12">
				<div class="welcome__juniro__inner">
					<h3>Giới Thiệu</h3>
					<p class="wow flipInX"><?php echo $item['tomtat'] ?></p>
					<div class="wel__btn">
						<a class="dcare__btn" href="bai-viet-chi-tiet.php?id=<?php echo $item['id'] ?>">Xem thêm</a>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-6 col-sm-12 md-mt-40 sm-mt-40">
				<div class="jnr__Welcome__thumb wow fadeInRight">
					<img src="images/wel-come/1.png" alt="images">
					<a class="play__btn" href="https://www.youtube.com/watch?v=7RvUNEF6xYY&t=60s"><i class="fa fa-play"></i></a>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</section>
<!-- End Welcame Area -->

<!-- Start Our Service Area -->
<section class="junior__service bg-image--1 section-padding--bottom section--padding--xlg--top">
	<div class="container">
		<div class="row">
			<!-- Start Single Service -->
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="service bg--white border__color wow fadeInUp">
					<div class="service__icon">
						<img src="images/shape/sm-icon/1.png" alt="icon images">
					</div>
					<div class="service__details">
						<h6><a href="#">CHƯƠNG TRÌNH GIÁO DỤC</a></h6>
						<p>Chương trình GIÁO DỤC SỚM 0 TUỔI gồm 8 lĩnh vực phát triển toàn diện cho trẻ, được thiết kế dựa trên 56 chỉ số phát triển quan trọng nhằm xác định các mục tiêu học tập cơ bản.</p>
					</div>
				</div>
			</div>
			<!-- End Single Service -->
			<!-- Start Single Service -->
			<div class="col-lg-3 col-md-6 col-sm-6 col-12 xs-mt-60">
				<div class="service bg--white border__color border__color--2 wow fadeInUp" data-wow-delay="0.2s">
					<div class="service__icon">
						<img src="images/shape/sm-icon/2.png" alt="icon images">
					</div>
					<div class="service__details">
						<h6><a href="#">PHƯƠNG PHÁP GIÁO DỤC</a></h6>
						<p>Là nhóm mầm non tiên phong trong giáo dục sớm, Hệ thống nhóm trẻ ứng dụng "CHƯƠNG TRÌNH GIÁO DỤC SỚM 0 TUỔI" tích hợp các phương pháp giáo dục sớm tiên tiến trên thế giới hiện nay.</p>
					</div>
				</div>
			</div>
			<!-- End Single Service -->
			<!-- Start Single Service -->
			<div class="col-lg-3 col-md-6 col-sm-6 col-12 md-mt-60 sm-mt-60">
				<div class="service bg--white border__color border__color--3 wow fadeInUp" data-wow-delay="0.45s">
					<div class="service__icon">
						<img src="images/shape/sm-icon/3.png" alt="icon images">
					</div>
					<div class="service__details">
						<h6><a href="#">ĐỘI NGŨ GIẢNG VIÊN</a></h6>
						<p>Tất cả Giáo viên Việt Nam có bằng Cử nhân sư phạm Mầm non hệ chính quy (100% Giáo viên tốt nghiệp Đại học hoặc Cao đẳng sư phạm) với nhiều năm kinh nghiệm giảng dạy tại các trường mầm non.</p>
					</div>
				</div>
			</div>
			<!-- End Single Service -->
			<!-- Start Single Service -->
			<div class="col-lg-3 col-md-6 col-sm-6 col-12 md-mt-60 sm-mt-60">
				<div class="service bg--white border__color border__color--4 wow fadeInUp" data-wow-delay="0.65s">
					<div class="service__icon">
						<img src="images/shape/sm-icon/4.png" alt="icon images">
					</div>
					<div class="service__details">
						<h6><a href="#">TƯ VẤN GIÁO DỤC</a></h6>
						<p>Những bài viết, kiến thức về giáo dục sớm 0 tuổi. Những câu hỏi thường gặp, kinh nghiệm trong quá trình thực hiện phương pháp giáo dục sớm trước 0 tuổi! Sách tham khảo về chương trình giáo dục sớm 0 tuổi!</p>
					</div>
				</div>
			</div>
			<!-- End Single Service -->
		</div>
	</div>
</section>
<!-- End Our Service Area -->

<!-- Start Call To Action -->
<section class="jnr__call__to__action bg-pngimage--8">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<div class="jnr__call__action__wrap d-flex flex-wrap flex-md-nowrap flex-lg-nowrap justify-content-between align-items-center">
					<div class="callto__action__inner">
						<a class="wow flipInX" data-wow-delay="0.55s"><h1>TRƯỜNG MẦM NON VÀNH KHUYÊN</h1></a>
						<i >Liên Hệ Với Chúng Tôi Để Giải Đáp Những Thắc Mắc</i>
					</div>
					<div class="callto__action__btn">
						<a class="dcare__btn btn__white" href="lien-he.php">Liên Hệ</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Call To Action -->

<!-- Start our Class Area -->
<section class="junior__classes__area section-lg-padding--top section-padding--md--bottom bg--white">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="section__title text-center">
					<h2 class="title__line">BÀI VIẾT MỚI NHẤT</h2>
				</div>
			</div>
		</div>
		<?php
		$query_tt_mn = "SELECT * FROM tintuc ORDER BY id DESC LIMIT 0,3";
		$results_tt_mn = mysqli_query($dbc,$query_tt_mn);
		foreach($results_tt_mn as $item_tt)
		{
		?>
		<div class="row">
			<div class = col-3>
				<div class="junior__classes">
					<div class="classes__inner">
						<div class="classes__icon">
							<img src="images/class/star/1.png" alt="starr images">
							<span>Mới</span>
						</div>
					</div>
				</div>
				<a href="bai-viet-chi-tiet.php?id=<?php echo $item_tt['id'] ?>">
					<img style ="width : 100%; " src="admin/images/tintuc/<?php echo $item_tt['hinh'] ?>" alt="class images">
				</a>
			</div>
			<div class=" col-8">
				<h4><a href="bai-viet-chi-tiet.php?id=<?php echo $item_tt['id'] ?>"><?php echo $item_tt['tieude'] ?></a></h4>
				<p><?php echo $item_tt['tomtat']; ?></p>
			</div>
		</div>
		<br />
		<?php
		}
		?>
	</div>
</section>
<!-- End our Class Area -->

<!-- Start Testimonial Area -->
<section class="junior__testimonial__area bg-image--2 section-padding--lg">
	<div class="container">
		<div class="row">
			<div class="offset-lg-2 col-lg-8 col-md-12 col-sm-12">
				<div class="testimonial__container">
					<div class="tes__activation--1 owl-carousel owl-theme">
						<div class="testimonial__bg">
							<!-- Start Single Testimonial -->
							<div class="testimonial text-center">
								<div class="testimonial__inner">
									<div class="test__icon">
										<img src="images/testimonial/icon/1.png" alt="icon images">
									</div>
									<div class="client__details">
										<p>Tìm được một môi trường để có thể yên tâm rằng con em mình đang được chăm sóc, nuôi dưỡng và phát triển cả về trí tuệ lẫn nhân cách là một việc vô cùng khó khăn.... Và nhóm trẻ Vành Khuyên là lựa chọn của tôi.</p>
										<div class="client__info">
											<h6>Chị Nguyễn Thị Kim Dung</h6>
											<span>Viện phó Viện Nghiên Cứu Giáo dục Tp.HCM.</span>
										</div>
									</div>
								</div>
							</div>
							<!-- End Single Testimonial -->
						</div>
						<div class="testimonial__bg">
							<!-- Start Single Testimonial -->
							<div class="testimonial text-center">
								<div class="testimonial__inner">
									<div class="test__icon">
										<img src="images/testimonial/icon/1.png" alt="icon images">
									</div>
									<div class="client__details">
										<p>Nhóm trẻ đã giúp con trai tôi sau 3 năm học trở nên rất tự tin trong giao tiếp, biết chia sẻ, cảm thông. Đặc biệt, cháu rất cảm hứng trong học tập, có khả năng quan sát nhạy bén, thông minh.</p>
										<div class="client__info">
											<h6>Anh Sĩ Hoàng</h6>
											<span>Nhạc sỹ Nghệ Thuật, Họa Sỹ, Nhà thiết kế thời trang</span>
										</div>
									</div>
								</div>
							</div>
							<!-- End Single Testimonial -->
						</div>
						<div class="testimonial__bg">
							<!-- Start Single Testimonial -->
							<div class="testimonial text-center">
								<div class="testimonial__inner">
									<div class="test__icon">
										<img src="images/testimonial/icon/1.png" alt="icon images">
									</div>
									<div class="client__details">
										<p>Sau một tuần học thử, gia đình quyết định gắn bó với nhóm trẻ vì nhiều ưu điểm: gần nhà, có khoảng sân và cây xanh, đặc biệt là phương pháp giáo dục khuyến khích trẻ sáng tạo, tự lập của nhóm trẻ.</p>
										<div class="client__info">
											<h6>Anh Thanh Điền</h6>
											<span>MC + Biên tập viên kênh VOV giao thông đài tiếng nói Việt Nam</span>
										</div>
									</div>
								</div>
							</div>
							<!-- End Single Testimonial -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Testimonial Area -->
<!-- Start Our Gallery Area -->
<section class="junior__gallery__area bg--white section-padding--lg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<div class="section__title text-center">
					<h2 class="title__line">Hình Ảnh Hoạt Động</h2>
					<p></p>
				</div>
			</div>
		</div>
		<div class="row galler__wrap mt--40">
			<!-- Start Single Gallery -->
			<?php
			//Truy van bang hinh hoat dong
			$query_hhd = "SELECT * FROM hinhhoatdong ORDER BY id DESC LIMIT 0,6";
			$results_hhd = mysqli_query($dbc, $query_hhd);
			foreach($results_hhd as $item_hhd)
			{
				//Truy van bang hoat dong
				$query_hd = "SELECT * FROM hoatdong WHERE id = {$item_hhd['hoat_dong_id']}";
				$results_hd = mysqli_query($dbc, $query_hd);
				foreach($results_hd as $item_hd)
				{
			?>
				<div class="col-lg-4 col-md-6 col-sm-6 col-12">
					<div class="gallery wow fadeInUp">
						<div class="gallery__thumb">
							<a href="#">
								<img src="admin/images/hinhhd/<?php echo $item_hhd['hinh']; ?>" alt="gallery images">
							</a>
						</div>
						<div class="gallery__hover__inner">
							<div class="gallery__hover__action">
								<ul class="gallery__zoom">
									<li><a href="admin/images/hinhhd/<?php echo $item_hhd['hinh']; ?>" data-lightbox="grportimg" data-title="<?php echo $item_hd['tieu_de'] ?>"><i class="fa fa-search"></i></a></li>
									<li><a href="hoat-dong.php"><i class="fa fa-link"></i></a></li>
								</ul>
								<h4 class="gallery__title"><a href="#"><?php echo $item_hd['tieu_de'] ?></a></h4>
								<p><?php echo $item_hd['mo_ta']; ?></p>
							</div>
						</div>
					</div>	
				</div>
			<?php
				}
			}
			?>
			<!-- End Single Gallery -->
		</div>	
	</div>	
</section>

<!-- End Our Gallery Area -->