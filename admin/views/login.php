<?php ob_start();?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<?php
session_start();
if(isset($_SESSION['uid']))
{
    header('Location: index.php');
}
?>
<!doctype html>
<html class="no-js h-100" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Trang quản trị - vành khuyên</title>
    <meta name="description" content="A high-quality &amp; free Bootstrap admin dashboard template pack that comes with lots of templates and components.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../css/all.css" rel="stylesheet">
    <link href="../css/icon.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" id="main-stylesheet" data-version="1.1.0" href="../styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="../styles/extras.1.1.0.min.css">
    <script async defer src="js/buttons.js"></script>
    <link rel="stylesheet" href="../../css/mystyle.css">
    <script src="../ckeditor/ckeditor.js"></script>
    <script src="../ckfinder/ckfinder.js"></script>
    <link rel="stylesheet" type="text/css" href="../styles/admin/style.css">
	<script language="JavaScript" type="text/javascript" src="../js/jquery2.min.js"></script>
</head>
<body id="LoginForm">
    <?php
        if(isset($_POST['btnDangNhap'])) 
        {
            $errors=array();
            if(empty($_POST['txtTaikhoan']))
            {
                $errors[]='txtTaikhoan';
            }
            else
            {
                $taikhoan=$_POST['txtTaikhoan'];
            }
            if(empty($_POST['txtMatkhau']))
            {
                $errors[]='txtMatkhau';
            }
            else
            {
                $matkhau=md5($_POST['txtMatkhau']);
            }
            if(empty($errors))
            {
                $query="SELECT id, ten_nguoi_dung, mat_khau, quyen FROM nguoidung WHERE ten_nguoi_dung='{$taikhoan}' AND mat_khau='{$matkhau}' AND ( quyen = 1 OR quyen = 2 )";
                $result=mysqli_query($dbc,$query);
                if(mysqli_num_rows($result)==1)
                {
                    list($id, $taikhoan, $matkhau, $quyen)=mysqli_fetch_array($result,MYSQLI_NUM);
                    $_SESSION['uid']=$id;
                    $_SESSION['username']=$taikhoan;
                    $_SESSION['matkhau']=$matkhau;
                    $_SESSION['quyen']=$quyen;
					//clear temp file
					$files = glob('../images/temp-image/*'); 
					foreach($files as $file){ 
					  if(is_file($file))
						unlink($file); 
					}
                    header('Location: '.((isset($_GET['redirect']) && strlen(trim($_GET['redirect']))>0)?$_GET['redirect']:'index.php'));
                }
                else
                {
                    $message="<p class='text-danger'>Tài khoản hoặc mật khẩu không đúng</p>";
                }
            }
        }
		if(isset($_POST['btnQuenMatKhau'])) 
        {
			 $errors=array();
			
            if(empty($_POST['txtTaikhoan']))
            {
                $errors[]='txtTaikhoan';
            }
            else
            {				
                $taikhoan=$_POST['txtTaikhoan'];
				$results = mysqli_fetch_assoc(mysqli_query( $dbc,'select count(*) as "count" from nguoidung where ten_nguoi_dung = "'.$taikhoan.'"'));
				if($results['count'] == 0){
					$errors[]='txtTaikhoan2';
				}
            }
            if(empty($_POST['txtEmailConfirm']) || empty(filter_var($_POST['txtEmailConfirm'], FILTER_VALIDATE_EMAIL)))
            {
                $errors[]='txtEmailConfirm';
            }
            else
            {
                $email=$_POST['txtEmailConfirm'];
            }
            if(empty($errors))
            {
				$query="select count(*) as 'count' from nhanvien nv, nguoidung nd where nv.id = nd.nhan_vien_id and nd.ten_nguoi_dung = '{$taikhoan}' and nv.email = '{$email}'";
                $result=mysqli_fetch_assoc(mysqli_query($dbc,$query));

                if($result['count'] == 1){	
					echo '<script>$("#formForgetPassword input").prop("disabled","true");$("#formForgetPassword button").prop("disabled","true");</script>';
					$matkhaumoi=randomDigitsLame(12);
					$matkhaumoiMD5 = md5($matkhaumoi);
					$results = mysqli_query( $dbc, "update nguoidung set mat_khau = '{$matkhaumoiMD5}' where ten_nguoi_dung = '{$taikhoan}'");
					require("PHPMailer.php");
					require("SMTP.php");
					require("Exception.php");
					$mail = new PHPMailer\PHPMailer\PHPMailer();
					$mail->IsSMTP(); 
					$mail->SMTPDebug = 0; 
					$mail->SMTPAuth = true; 
					$mail->SMTPSecure = 'ssl'; 
					$mail->Host = "smtp.gmail.com";
					$mail->Port = 465; 
					$mail->IsHTML(true);
					$mail->Username = "vanhkhuyenda3@gmail.com";
					$mail->Password = "vanhkhuyen123456";
					$mail->SetFrom("vanhkhuyenda3@gmail.com");
					$mail->Subject = '=?utf-8?B?'.base64_encode('Khôi phục tài khoản thành công').'?=';
					$mail->Body = "<h3 style='font-weight: 400;'>Tài khoản <b>{$taikhoan}</b> của bạn đã khôi phục thành công! Nếu thay đổi này không phải do bạn thực hiện hãy liên hệ với quản trị viên để được hỗ trợ.</h3><h4>Mật khẩu mới của bạn là <span style='color:red;'>{$matkhaumoi}</span>, vui lòng đổi mật khẩu ngay sau khi đăng nhập.</h4><br/><h5 style='font-weight: 400;color:#717171;'><sub>*</sub>Mail được gửi tự động từ Trường Mầm non Vành Khuyên - vui lòng không phản hồi mail này</h5>";
					$mail->AddAddress($email);
					$mail->send();
					$confirmSuccess = true;
				}	
				else{
					$confirmSuccess = false;
				}
			}
		}
    ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">            
            <div class="row">
                <div class="col-md-6 mx-auto mt-5">
                    <!-- form card login -->
                    <div class="card rounded-0">
						<?php if(isset($_GET['forgetPassword'])){?>
						<div class="card-header">
                            <h2 class="text-center ">Quên mật khẩu</h2>
                        </div>
                        <div class="card-body">
                            <?php
                            if(isset($confirmSuccess) && $confirmSuccess)
                            {
                                echo '<h3 style="color: red;text-align: center;">Khôi phục tài khoản thành công!</h3><h6 style="color: black;text-align: center;margin-top: 20px;">Kiểm tra email đã đăng ký để nhận mật khẩu mới.</h6><a href="login.php" style="float:right;">Bấm vào đây để đăng nhập</a>';
                            }
							else{
                            ?>	
							<script>								
									$("#formForgetPassword input").removeAttr("readonly");
									$("#formForgetPassword button").css("pointer-events","unset");
									$("#formForgetPassword button").css("opacity","1");
							</script>
                            <form class="form" role="form" autocomplete="off" id="formForgetPassword" novalidate="" method="POST">
                                <div class="form-group">
                                    <label>Tài khoản</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="txtTaikhoan"
										   <?php if(isset($taikhoan)) echo 'value="'.$taikhoan.'"' ?>>
                                    <?php
                                        if(isset($errors) && in_array('txtTaikhoan', $errors))
                                        {
                                            echo "<p class='text-danger'>Tài khoản không được bỏ trống</p>";
                                        }
										else if(isset($errors) && in_array('txtTaikhoan2', $errors)){
											echo "<p class='text-danger'>Tài khoản không tồn tại</p>";
										}
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>Email đăng ký</label>
                                    <input type="mail" class="form-control form-control-lg rounded-0" name="txtEmailConfirm">
                                    <?php
                                        if(isset($errors) && in_array('txtEmailConfirm', $errors))
                                        {
                                            echo "<p class='text-danger'>Email không hợp lệ</p>";
                                        }
										if(isset($confirmSuccess) && !$confirmSuccess)
                                        {
                                            echo "<p class='text-danger'>Email đăng ký không đúng</p>";
                                        }
                                    ?>
                                </div>
                                <div class="text-center">
                                	<button type="submit" class="btn btn-success btn-lg" name="btnQuenMatKhau">Xác nhận</button>
                                </div>
                            </form>
							<script>
								$('#formForgetPassword button[name="btnQuenMatKhau"]').on("click",function(){
									$("#formForgetPassword input").prop("readonly","true");
									$("#formForgetPassword button").css("pointer-events","none");
									$("#formForgetPassword button").css("opacity",".5");
								});								
							</script>
							<?php } ?>
                        </div>
						<?php } 
						else
						{?>
                        <div class="card-header">
                            <h2 class="text-center ">Đăng nhập</h2>
                        </div>
                        <div class="card-body">
                            <?php
                            if(isset($message))
                            {
                                echo $message;
                            }
                            ?>
                            <form class="form" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">
                                <div class="form-group">
                                    <label>Tài khoản</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="txtTaikhoan">
                                    <?php
                                        if(isset($errors) && in_array('txtTaikhoan', $errors))
                                        {
                                            echo "<p class='text-danger'>Tài khoản không được bỏ trống</p>";
                                        }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="txtMatkhau">
                                    <?php
                                        if(isset($errors) && in_array('txtMatkhau', $errors))
                                        {
                                            echo "<p class='text-danger'>Mật khẩu không được bỏ trống</p>";
                                        }
                                    ?>
                                </div>
                                <div class="text-center">
                                	<button type="submit" class="btn btn-success btn-lg" name="btnDangNhap">Xác nhận</button>
									
                                </div>
								<div class="labelQuenMatKhau"><a href="?forgetPassword" >Quên mật khẩu</a></div>
								<style>
									.labelQuenMatKhau a{
										float: right;
										outline: none;
										overflow: hidden;
									}
								</style>
                            </form>
                        </div>
						<?php }?>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->
                </div>
            </div>
            <!--/row-->
        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
</body>
</html>
