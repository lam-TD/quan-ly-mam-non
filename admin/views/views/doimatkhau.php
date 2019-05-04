<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<!-- End header-->


<!-- Page content-->
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Đổi Mật Khẩu</h3>
        </div>
    </div>
    <!-- End Page Header -->

	<!-- Default Light Table -->
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
				<?php
                if($_SERVER['REQUEST_METHOD']=='POST') 
                {
                    $errors=array();
                    if(empty($_POST['txtDMatkhau']))
                    {
                        $errors[]='txtDMatkhau';
                    }
                    else
                    {
                        $dmatkhau = md5(trim($_POST['txtDMatkhau']));
                    }
                    if(trim($_POST['txtDMatkhau']) != trim($_POST['txtDMatkhauXN']))
                    {
                        $errors[]='txtDMatkhauXN';
                    }
                    if(empty($errors))
                    {
                        $query="UPDATE nguoidung
                                SET mat_khau='{$dmatkhau}'
                                WHERE id = {$_SESSION['uid']} 
                        ";
                        $results=mysqli_query($dbc,$query);
                        //Kiểm tra sửa thành công hay không    
                        if(mysqli_affected_rows($dbc)==1)
                        {
                        ?>
                        	<script>
                        		alert("Đổi mật khẩu thành công");
								window.location="index.php";
                        	</script>
                        <?php
                        }
                        else
                        {
                            echo "<script>";
                        	echo 'alert("Đổi mật khẩu không thành công")';
                        	echo "</script>";   
                        }
                    }
                }
                if(isset($message))
                {
                    echo $message;
                }
                ?>
				<div class="card-header border-bottom">
					<h5 class="text-info">Đổi mật khẩu</h5>
					<form action="" method="post">
						<div class="form-group">
							<label>Mật khẩu mới</label>
							<input type="password" class="form-control" name="txtDMatkhau" placeholder="Vui lòng nhập mật khẩu mới" >
                            <?php 
                                if(isset($errors) && in_array('txtDMatkhau',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập mật khẩu mới</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu xác nhận</label>
                            <input type="password" class="form-control" name="txtDMatkhauXN" placeholder="Vui lòng nhập mật khẩu xác nhận" >
                            <?php 
                                if(isset($errors) && in_array('txtDMatkhauXN',$errors))
                                {
                                    echo "<p class='text-danger'>Mật khẩu xác nhận chưa đúng</p>";
                                }
                            ?>
                        </div>
							<button type="submit" class="btn btn-info">Đổi mật khẩu</button>
					</form>
				</div>
			<!-- End sua bằng cấp -->
<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer