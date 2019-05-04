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
            <h3 class="page-title">Hợp Đồng</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h5 class="text-info">Sửa hợp đồng</h5>
                    <?php
                    //Kiểm tra ID có phải là kiểu số không, filter_var kiem tra có thuộc tính trim sẽ loại bỏ khoảng trắng
                        if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
                        {
                            $id=$_GET['id'];
                        }
                        else
                        {
                            header('Location: admin-hopdong.php');
                            exit();
                        }
                        //Truy van bang hop dong dua theo hop_dong_id duoc truyen vao
                        $query_id="SELECT nhan_vien_id, ngay_ky, tu_ngay, den_ngay, loai_hop_dong, ghi_chu FROM hopdong WHERE hop_dong_id={$id}";
                        $result_id=mysqli_query($dbc,$query_id);
                        //Kiểm tra xem ID có tồn tại không
                        if(mysqli_num_rows($result_id)==1)
                        {
                            list($nv_id, $ngay_ky, $tu_ngay, $den_ngay, $loai_hop_dong, $ghi_chu)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                        }
                        else
                        {
                            $message="<p class='required'>ID không tồn tại</p>";  
                        }
                        //Lay ngay ket thuc co trong bang hop dong de so sanh
                        $query_id="SELECT den_ngay FROM hopdong WHERE nhan_vien_id = $nv_id ORDER BY den_ngay DESC LIMIT 1,1";
                        $result_id=mysqli_query($dbc,$query_id);
                        if(mysqli_num_rows($result_id)==1)
                        {
                            list($ngayktd)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                        }
                        else
                        {
                            list($ngayktd) = "";
                        }                                 
                        if($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $errors = array();
                            if(empty($_POST['txtTuNgay']) || (strtotime($_POST['txtTuNgay']) <= strtotime($ngayktd)))
                            {
                                $errors[] = 'txtTuNgay';
                            }
                            else
                            {
                                $tungay = $_POST['txtTuNgay'];
                            }
                            if(empty($_POST['txtDenNgay']) || (strtotime($_POST['txtDenNgay']) < strtotime($_POST['txtTuNgay'])))
                            {
                                $errors[] = 'txtDenNgay';
                            }
                            else
                            {
                                $denngay = $_POST['txtDenNgay'];
                            }
                            if(empty($_POST['txtLoaiHopDong']))
                            {
                                $errors[] = 'txtLoaiHopDong';
                            }
                            else
                            {
                                $loaihopdong = $_POST['txtLoaiHopDong'];
                            }
                            $ngayky = $_POST['txtNgayKy'];
                            $ghichu = $_POST['txtGhiChu'];
                            if(empty($errors))
                            {
                                //INSERT VÀO DATABASE
                                $query_tt = "UPDATE hopdong
                                            SET ngay_ky = '{$ngayky}',
                                                tu_ngay = '{$tungay}',
                                                den_ngay = '{$denngay}',
                                                loai_hop_dong = '{$loaihopdong}',
                                                ghi_chu = '{$ghichu}'
                                            WHERE hop_dong_id = $id";
                                $results_tt = mysqli_query($dbc, $query_tt);
                                if(mysqli_affected_rows($dbc) == 1)
                                {
                                ?>
                                    <script>
                                        alert("Sửa thành công");
                                        window.location="admin-hopdong.php?id=<?php echo $nv_id ?>";
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
                            else
                            {
                                $message="<p class='text-danger'>Bạn hãy nhập đầy đủ thông tin</p>";
                            }
                        } 
                        if(isset($message))
                        {
                            echo $message;
                        }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                        <?php            
                            $query_id="SELECT id, ho_ten FROM nhanvien WHERE id = $nv_id";
                            $result_id=mysqli_query($dbc,$query_id);
                            if(mysqli_num_rows($result_id)==1)
                            {
                                list($id,$name)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                            }                                       
                        ?>
                            <label>Tên nhân viên *</label>
                            <input class="form-control" name="txtTenNhanVien" value = "<?php echo $name ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Ngày ký</label>
                            <input type="date" class="form-control" name="txtNgayKy" placeholder="Vui lòng nhập ngày ký" value = "<?php if(isset($ngay_ky)) {echo $ngay_ky;} ?>">
                        </div>
                        <div class="form-group">
                            <label>Ngày bắt đầu *</label>
                            <input type="date" class="form-control" name="txtTuNgay" placeholder="Vui lòng nhập ngày bắt đầu" value = "<?php if(isset($tu_ngay)) {echo $tu_ngay;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtTuNgay',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập ngày bắt đầu hoặc hợp đồng trùng ngày hợp đồng trước</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Ngày kết thúc *</label>
                            <input type="date" class="form-control" name="txtDenNgay" placeholder="Vui lòng nhập ngày kết thúc" value = "<?php if(isset($den_ngay)) {echo $den_ngay;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtDenNgay',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập ngày kết thúc hoặc ngày kết thúc phải lớn hơn ngày bắt đầu</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Loại hợp động *</label>
                            <input class="form-control" name="txtLoaiHopDong" placeholder="Vui lòng nhập loại hợp đồng" value = "<?php if(isset($loai_hop_dong)) {echo $loai_hop_dong;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtLoaiHopDong',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập loại hợp đồng</p>";
                                }
                            ?>
                        </div>
                         <div class="form-group">
                            <label>Ghi Chú</label>
                            <input class="form-control" name="txtGhiChu" placeholder="Vui lòng nhập ghi chú" value = "<?php if(isset($ghi_chu)) {echo $ghi_chu;} ?>">
                        </div>
                            <button type="submit" class="btn btn-info">Sửa hợp đồng</button>
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