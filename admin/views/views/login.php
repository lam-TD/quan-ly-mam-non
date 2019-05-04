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
</head>
<body id="LoginForm">
    <?php
        if($_SERVER['REQUEST_METHOD']=='POST') 
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
                    header('Location: '.((isset($_GET['redirect']) && strlen(trim($_GET['redirect']))>0)?$_GET['redirect']:'index.php'));
                }
                else
                {
                    $message="<p class='text-danger'>Tài khoản hoặc mật khẩu không đúng</p>";
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
                            </form>
                        </div>
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
