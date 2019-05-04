<?php include "header.php" ?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$name=$_POST['name'];
	$email=$_POST['email'];
	$content=$_POST['content'];
	$message='Thông tin liên hệ
				Họ tên:'.$name.'
				Email:'.$email.'
				Nội dung: '.$content.'';
	$to = 'vanhkhuyenda3@gmail.com';
	$header = 'From: vanhkhuyenda3@gmail.com.vn';
	$subject = $_POST['subject'];
	if (mail($to, $subject, $message, $header) == true)
	{
		echo "<script>
				alert('Cám ơn bạn đã góp ý. Chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất');
			  </script> ";
	}
	else
	{
		echo "<script>alert('Lỗi');
		</script>";
	}
}
?>
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area">
    <div class="ht__bradcaump__container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Liên Hệ Chúng Tôi</h2>
                        <nav class="bradcaump-inner">
                          <a class="breadcrumb-item" href="index.html">Trang chủ</a>
                          <span class="brd-separetor"><img src="images/icons/brad.png" alt="separator images"></span>
                          <span class="breadcrumb-item active">Liên hệ</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<section class="page__contact bg--white section-padding--lg">
	<div class="container">
		<div class="row">
			<!-- Start Single Address -->
			<div class="col-md-6 col-sm-6 col-12 col-lg-4">
				<div class="address location">
					<div class="ct__icon">
						<i class="fa fa-home"></i>
					</div>
					<div class="address__inner">
						<h2>Địa chỉ</h2><p>Trường Mầm Non Vành Khuyên.<br>Quốc lộ 1A, Tx.Ngã Bảy-Hậu Giang</br></p>
						
						
					</div>
				</div>
			</div>
			<!-- End Single Address -->
			<!-- Start Single Address -->
			<div class="col-md-6 col-sm-6 col-12 col-lg-4 xs-mt-60">
				<div class="address phone">
					<div class="ct__icon">
						<i class="fa fa-phone"></i>
					</div>
					<div class="address__inner">
						<h2>Số điện thoại</h2>
						<ul>
							<li><a href="tell:+08097-654321">+08097-654321</a></li>
							<li><a href="tell:+08097-654321">+08097-654321</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- End Single Address -->
			<!-- Start Single Address -->
			<div class="col-md-6 col-sm-6 col-12 col-lg-4 md-mt-60 sm-mt-60">
				<div class="address email">
					<div class="ct__icon">
						<i class="fa fa-envelope"></i>
					</div>
					<div class="address__inner">
						<h2>Email</h2>
						<ul>
							<li><a href="mailto:+08097-654321">vanhkhuyen@gmail.com</a></li>
							<li><a href="mailto:+08097-654321">vanhkhuyen@yahoo.com.vn</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- End Single Address -->
		</div>
	</div>
</section>
<section class="contact__box section-padding--lg bg-image--27">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-sm-12 col-md-12">
				<div class="section__title text-center">
					<h2 class="title__line">Liên Hệ Với Chúng Tôi</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<form action="" method="POST">
					<div class="form-group">
						<label for="usr" >Họ tên:</label>
						<input name= "name" type="text" class="form-control" id="usr">
					</div>
					<div class="form-group">
						<label for="sbj">Tiêu đề thông điệp:</label>
						<input name ="subject" type="text" class="form-control" id="sbj">
					</div>
					<div class="form-group">
						<label for="email">Email:</label>
						<input name = "email" type="email" class="form-control" id="email">
					</div>
					 <div class="form-group">
						<label for="comment">Nội dung thông điệp:</label>
						<textarea name="content" class="form-control" rows="5" id="comment"></textarea>
					</div> 
				  <button type="submit" class="btn btn-primary">Gửi</button>
				</form> 
			</div>
		</div>
	</div>
</section>
<!-- End Contact Form -->
<?php include "footer.php" ?>