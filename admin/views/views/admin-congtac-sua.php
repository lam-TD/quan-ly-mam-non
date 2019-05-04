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
            <h3 class="page-title">Công Tác</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h5 class="text-info">Sửa công tác</h5>
                    <?php
                    //Kiểm tra ID có phải là kiểu số không, filter_var kiem tra có thuộc tính trim sẽ loại bỏ khoảng trắng
                        if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
                        {
                            $id=$_GET['id'];
                        }
                        else
                        {
                            header('Location: admin-congtac.php');
                            exit();
                        }
                        //Truy van bang hop dong dua theo cong_tac_id duoc truyen vao
                        $query_id="SELECT nhan_vien_id, ngay_bat_dau, ngay_ket_thuc, cong_viec, ghi_chu FROM congtac WHERE cong_tac_id={$id}";
                        $result_id=mysqli_query($dbc,$query_id);
                        //Kiểm tra xem ID có tồn tại không
                        if(mysqli_num_rows($result_id)==1)
                        {
                            list($nv_id, $ngay_bat_dau, $ngay_ket_thuc, $cong_viec, $ghi_chu)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                        }
                        else
                        {
                            $message="<p class='required'>ID không tồn tại</p>";  
                        }
                        //Lay ngay ket thuc co trong bang hop dong de so sanh
                        $query_id="SELECT ngay_ket_thuc FROM congtac WHERE nhan_vien_id = $nv_id ORDER BY ngay_ket_thuc DESC LIMIT 1,1";
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
                            if(empty($_POST['txtngaybatdau']) || (strtotime($_POST['txtngaybatdau']) <= strtotime($ngayktd)))
                            {
                                $errors[] = 'txtngaybatdau';
                            }
                            else
                            {
                                $ngaybatdau = $_POST['txtngaybatdau'];
                            }
                            if(empty($_POST['txtngayketthuc']) || (strtotime($_POST['txtngayketthuc']) < strtotime($_POST['txtngaybatdau'])))
                            {
                                $errors[] = 'txtngayketthuc';
                            }
                            else
                            {
                                $ngayketthuc = $_POST['txtngayketthuc'];
                            }
                            if(empty($_POST['txtcongviec']))
                            {
                                $errors[] = 'txtcongviec';
                            }
                            else
                            {
                                $congviec = $_POST['txtcongviec'];
                            }
                            $ghichu = $_POST['txtGhiChu'];
                            if(empty($errors))
                            {
                                //INSERT VÀO DATABASE
                                $query_tt = "UPDATE congtac
                                            SET ngay_bat_dau = '{$ngaybatdau}',
                                                ngay_ket_thuc = '{$ngayketthuc}',
                                                cong_viec = '{$congviec}',
                                                ghi_chu = '{$ghichu}'
                                            WHERE cong_tac_id = $id";
                                $results_tt = mysqli_query($dbc, $query_tt);
                                if(mysqli_affected_rows($dbc) == 1)
                                {
                                ?>
                                    <script>
                                        alert("Sửa thành công");
                                        window.location="admin-congtac.php?id=<?php echo $nv_id ?>";
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
                            <label>Ngày bắt đầu *</label>
                            <input type="date" class="form-control" name="txtngaybatdau" placeholder="Vui lòng nhập ngày bắt đầu" value = "<?php if(isset($ngay_bat_dau)) {echo $ngay_bat_dau;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtngaybatdau',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập ngày bắt đầu hoặc công tác trùng ngày công tác trước</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Ngày kết thúc *</label>
                            <input type="date" class="form-control" name="txtngayketthuc" placeholder="Vui lòng nhập ngày kết thúc" value = "<?php if(isset($ngay_ket_thuc)) {echo $ngay_ket_thuc;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtngayketthuc',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập ngày kết thúc hoặc ngày kết thúc phải lớn hơn ngày bắt đầu</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Công việc *</label>
                            <input class="form-control" name="txtcongviec" placeholder="Vui lòng nhập công việc" value = "<?php if(isset($cong_viec)) {echo $cong_viec;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtcongviec',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập công việc</p>";
                                }
                            ?>
                        </div>
                         <div class="form-group">
                            <label>Ghi Chú</label>
                            <input class="form-control" name="txtGhiChu" placeholder="Vui lòng nhập ghi chú" value = "<?php if(isset($ghi_chu)) {echo $ghi_chu;} ?>">
                        </div>
                            <button type="submit" class="btn btn-info">Sửa công tác</button>
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