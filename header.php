<?php ob_start();?>
<?php include "inc/myconnect.php"; ?>
<?php include "inc/myfunction.php"; ?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Nhóm Trẻ Mầm Non Vành Khuyên</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicons -->
	<link rel="shortcut icon" href="images/favicon.ico">
	<link rel="apple-touch-icon" href="images/icon.png">
	<!-- Google font (font-family: 'Lobster', Open+Sans;) -->
	<link rel="stylesheet" href="css/fonts.css">

	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/mystyle.css">
	<link rel="stylesheet" href="css/plugins.css">
	<link rel="stylesheet" href="style.css">

	<!-- Cusom css -->
   <link rel="stylesheet" href="css/custom.css">

	<!-- Modernizer js -->
	<script src="js/vendor/modernizr-3.5.0.min.js"></script>
</head>
<body>
	<!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->

	<!-- Add your site or application content here -->
	
	<!-- <div class="fakeloader"></div> -->

	<!-- Main wrapper -->
	<div class="wrapper" id="wrapper">
		<!-- Header -->
		<header id="header" class="jnr__header header--one clearfix">
			<!-- Start Header Top Area -->
			<div class="junior__header__top">
				<div class="container">
					<div class="row">
						<div class="col-12">
							<div class="form-inline float-right">
								<form action="tim-kiem.php" method="GET">
									<input type="text" name="ten" class="form-control" placeholder="Tìm Kiếm..."/>
									<input type="submit" class="form-control btn btn-primary" value="Tìm Kiếm" name="submit"/>
								</form>
							</div>
			<!-- End Search Bar -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Header Top Area -->
			<!-- Start Mainmenu Area -->
			<div class="mainmenu__wrapper bg__cat--1 poss-relative header_top_line sticky__header">
				<div class="container">
					<div class="row d-none d-lg-flex">
						<div class="col-sm-4 col-md-6 col-lg-2 order-1 order-lg-1">
							<div class="logo">
								<a href="index.php">
									<img src="images/logo/LOGO.png" alt="logo images">
								</a>
							</div>
						</div>
						<div class="col-sm-4 col-md-2 col-lg-10 order-3 order-lg-2">
							<div class="mainmenu__wrap">
								<nav class="mainmenu__nav">
                                    <ul class="mainmenu">
                                        <li class="drop"><a href="index.php">Trang Chủ</a></li>
                                    	<?php
                                    	//Danh mục trong loại tin
                                    	$menu_level_1 = "SELECT * FROM loaitin WHERE the_loai_cha = 0";
                                    	$results_level_1 = mysqli_query($dbc,$menu_level_1);
                                    	foreach($results_level_1 as $item_level_1)
                                    	{
                                    	?>
                                        <li class="drop"><a href="#"><?php echo $item_level_1['ten'] ?></a>
                                            <ul class="dropdown__menu">
                                            	<?php
                                            	$menu_level_2 = "SELECT * FROM loaitin WHERE the_loai_cha = {$item_level_1['id']}";
                                            	$results_level_2 = mysqli_query($dbc, $menu_level_2);
                                            	foreach($results_level_2 as $item_level_2)
                                            	{
													$menu_level_3 = "SELECT * FROM loaitin WHERE the_loai_cha = {$item_level_2['id']}";
                                            	$results_level_3 = mysqli_query($dbc, $menu_level_3);
													if ( mysqli_num_rows( $results_level_3 ) > 0 ) {
														?>
												<li class="drop">
													<a href="danh-muc-bai-viet.php?id=<?php echo $item_level_2['id'] ?>">
														<?php echo $item_level_2['ten'] ?>
													</a>
													<ul class="dropdown__menu" style="left: 100%; top: 0%;">
														<?php
														foreach ( $results_level_3 as $item_level_3 ) {
															?>
														<li>
															<a href="danh-muc-bai-viet.php?id=<?php echo $item_level_3['id'] ?>">
																<?php echo $item_level_3['ten'] ?>
															</a>
														</li>
														<?php
														}
														?>
													</ul>
												</li>
												<?php
												} else {
                                            	?>
                                                <li><a href="danh-muc-bai-viet.php?id=<?php echo $item_level_2['id'] ?>"><?php echo $item_level_2['ten'] ?></a></li>
                                                <?php
                                                }
													
													}
											if($item_level_1['id'] == 87){
														?><li><a href="hoat-dong.php">Hoạt động</a></li><?php }
                                                ?>
                                            </ul>
                                        </li>
                                        <?php
												
                                        }
                                        ?>
										<li><a href="tra-cuu.php">Tra Cứu</a></li>
										<li><a href="lien-he.php">Liên Hệ</a></li>
                                    </ul>
                                </nav>
							</div>
						</div>
					</div>
					<!-- Mobile Menu -->
                    <div class="mobile-menu d-block d-lg-none">
                    	<div class="logo">
                    		<a href="index.php"><img src="images/logo/LOGO.png" alt="logo"></a>
                    	</div>
                    </div>
                    <!-- Mobile Menu -->
				</div>
			</div>
			<!-- End Mainmenu Area -->
		</header>
		<!-- //Header -->
		<!-- Strat Slider Area -->
		<?php 
		if(strrpos($_SERVER['REQUEST_URI'],'index.php') > 0){
		?>
		<div class="slide__carosel owl-carousel owl-theme">
			<div class="slider__area bg-pngimage--1  d-flex fullscreen justify-content-start align-items-center">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12">
							<div class="slider__activation">
								<!-- Start Single Slide -->
								<div class="slide">
									<div class="slide__inner">
										<h1>VÀNH KHUYÊN</h1>
										<div class="slider__text">
											<h2>Nhóm Trẻ Mầm Non</h2>
										</div>
										
									</div>
								</div>
								<!-- End Single Slide -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
		}
		?>
		<!-- End Slider Area -->
			