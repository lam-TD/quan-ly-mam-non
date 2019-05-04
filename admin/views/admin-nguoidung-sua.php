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
            <h3 class="page-title">Người Dùng</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h5 class="text-info">Sửa người dùng</h5>
                    <?php
                    //Kiểm tra ID có phải là kiểu số không
                        if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
                        {
                            $id=$_GET['id'];
                        }
                        else
                        {
                            header('Location: admin-nguoidung.php');
                            exit();
                        }
                        if($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $errors = array();
                            if(empty($_POST['txtTennguoidung']))
                            {
                                $errors[] = 'txtTennguoidung';
                            }
                            else
                            {
                                $name = $_POST['txtTennguoidung'];
                            }
                            if(empty($_POST['Nhanvien']))
                            {
                                $errors[] = 'Nhanvien';
                            }
                            else
                            {
                                $nhanvien = $_POST['Nhanvien'];
                            }
                            if(empty($_POST['txtMatkhau']))
                            {
                                $errors[] = 'txtMatkhau';
                            }
                            else
                            {
                                $matkhau = md5(trim($_POST['txtMatkhau']));
                            }
                            if(trim($_POST['txtMatkhau']) != trim($_POST['txtMatkhauXN']))
                            {
                                $errors[]='txtMatkhauXN';
                            }
                            $quyen = $_POST['slQuyen'];
                            if(empty($errors))
                            {
                                $query="UPDATE nguoidung
                                        SET mat_khau = '{$matkhau}',
                                            nhan_vien_id = $nhanvien,
                                            quyen = $quyen
                                        WHERE id = {$id}
                                ";
                                $results=mysqli_query($dbc,$query);
                                //Kiểm tra sửa thành công hay không    
                                if(mysqli_affected_rows($dbc)==1)
                                {
                                ?>
                                    <script>
                                        alert("Sửa thành công");
                                        window.location="admin-nguoidung.php";
                                    </script>
                                <?php
                                }
                                else
                                {
                                    echo "<script>";
                                    echo 'alert("Sửa không thành công")';
                                    echo "</script>";   
                                }
                            }
                        }
                        $query_id="SELECT ten_nguoi_dung, nhan_vien_id, quyen  FROM nguoidung WHERE id={$id}";
                        $result_id=mysqli_query($dbc,$query_id);
                        //Kiểm tra xem ID có tồn tại không
                        if(mysqli_num_rows($result_id)==1)
                        {
                            list($tennguoidung, $nhanvien, $quyen)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                        }
                        else
                        {
                            $message="<p class='required'>ID không tồn tại</p>";  
                        }
                        if(isset($message))
                        {
                            echo $message;
                        }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Tên người dùng *</label>
                            <input class="form-control" readonly="true" name="txtTennguoidung" placeholder="Vui lòng nhập tên người dùng" value = "<?php if(isset($tennguoidung)) {echo $tennguoidung;} ?>">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu *</label>
                            <input type="password" class="form-control" name="txtMatkhau" placeholder="Vui lòng nhập mật khẩu" value = "<?php if(isset($_POST['txtMatkhau'])) {echo $_POST['txtMatkhau'];} ?>">
                            <?php
                                if(isset($errors) && in_array('txtMatkhau',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập mật khẩu</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu Xác Nhận *</label>
                            <input type="password" class="form-control" name="txtMatkhauXN" placeholder="Vui lòng nhập mật khẩu xác nhận" value = "<?php if(isset($_POST['txtMatkhauXN'])) {echo $_POST['txtMatkhauXN'];} ?>">
                            <?php
                                if(isset($errors) && in_array('txtMatkhauXN',$errors))
                                {
                                    echo "<p class='text-danger'>Mật khẩu xác nhận không đúng</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label style="display:block">Nhân viên *</label>
                            <select class="form-control" name="Nhanvien">
                            <option value="">Vui Lòng Chọn Nhân Viên</option>
                            <?php 
                                $query_nv="SELECT * FROM nhanvien";
                                $nvs=mysqli_query($dbc,$query_nv);
                                foreach ($nvs as $item) 
                                {
                                    if($nhanvien == $item['id'])
                                    {
                                ?> 
                                        <option <?php echo 'selected = "selected"'; ?> value="<?php echo $item['id']?>"><?php echo $item['ho_ten'] ?></option>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                        <option value="<?php echo $item['id']?>"><?php echo $item['ho_ten'] ?></option>
                                <?php
                                    }
                                } 
                            ?>
                            </select>
                            <?php
                                if(isset($errors) && in_array('Nhanvien',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa chọn nhân viên</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Quyền</label>
                            <select class="form-control" name="slQuyen">
                                <option <?php if(isset($quyen) && $quyen == 1) {echo 'selected = "selected"';} ?> value="1">Admin</option>
                                <option <?php if(isset($quyen) && $quyen == 2) {echo "selected = 'selected'";} ?>  value="2">Nhân Viên</option>
                            </select> 
                        </div>
                            <button type="submit" class="btn btn-info">Sửa Thông Tin</button>
                    </form>
                </div>
            <!-- End thêm loại tin -->
            </div>
        </div>
    </div>
    <!-- End Default Light Table -->
</div>
<!-- End page content-->

<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer