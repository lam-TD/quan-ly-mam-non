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
                    <h5 class="text-info">Thêm công tác</h5>
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
                        //Lay ngay ket thuc co trong bang hop dong de so sanh
                        $query_id="SELECT ngay_ket_thuc FROM congtac WHERE nhan_vien_id = $id AND ngay_ket_thuc = (SELECT MAX(ngay_ket_thuc) FROM congtac WHERE nhan_vien_id = $id)";
                        $result_id=mysqli_query($dbc,$query_id);
                        if(mysqli_num_rows($result_id)==1)
                        {
                            list($ngayktcu)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                        }
                        else
                        {
                            list($ngayktcu) = "";
                        }                                 
                        if($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $errors = array();
                            if(empty($_POST['txtngaybatdau']) || (strtotime($_POST['txtngaybatdau']) <= strtotime($ngayktcu)))
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
                            $nhanvienid = $id;
                            if(empty($errors))
                            {
                                //INSERT VÀO DATABASE
                                $query_tt = "INSERT INTO congtac(nhan_vien_id, ngay_bat_dau, ngay_ket_thuc, cong_viec, ghi_chu) VALUES($nhanvienid,'{$ngaybatdau}','{$ngayketthuc}','{$congviec}', '{$ghichu}') ";
                                $results_tt = mysqli_query($dbc, $query_tt);
                                if(mysqli_affected_rows($dbc) == 1)
                                {
                                ?>
                                    <script>
                                        alert("thêm thành công");
                                        window.location="admin-congtac.php?id=<?php echo $id ?>";
                                    </script>
                                <?php
                                }
                                else
                                {
                                    echo "<script>";
                                    echo 'alert("Thêm không thành công")';
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
                            $query_id="SELECT id, ho_ten FROM nhanvien WHERE id = $id";
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
                            <input type="date" class="form-control" name="txtngaybatdau" placeholder="Vui lòng nhập ngày bắt đầu" value = "<?php if(isset($_POST['txtngaybatdau'])) {echo $_POST['txtngaybatdau'];} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtngaybatdau',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập ngày bắt đầu hoặc nhân viên vẫn còn công tác</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Ngày kết thúc *</label>
                            <input type="date" class="form-control" name="txtngayketthuc" placeholder="Vui lòng nhập ngày kết thúc" value = "<?php if(isset($_POST['txtngayketthuc'])) {echo $_POST['txtngayketthuc'];} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtngayketthuc',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập ngày kết thúc hoặc ngày kết thúc phải lớn hơn ngày bắt đầu</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Công việc *</label>
                            <input class="form-control" name="txtcongviec" placeholder="Vui lòng nhập công việc" value = "<?php if(isset($_POST['txtcongviec'])) {echo $_POST['txtcongviec'];} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtcongviec',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập loại hợp đồng</p>";
                                }
                            ?>
                        </div>
                         <div class="form-group">
                            <label>Ghi Chú</label>
                            <input class="form-control" name="txtGhiChu" placeholder="Vui lòng nhập ghi chú" value = "<?php if(isset($_POST['txtGhiChu'])) {echo $_POST['txtGhiChu'];} ?>">
                        </div>
                            <button type="submit" class="btn btn-info">Thêm công tác</button>
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