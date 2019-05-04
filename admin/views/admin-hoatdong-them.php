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
            <h3 class="page-title">Hoạt động</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h5 class="text-info">Thêm hoạt động</h5>
                    <?php
                        if(isset($_POST['them']))
                        {
                            $errors = array();
                            if(empty($_POST['txtTieuDe']))
                            {
                                $errors[] = 'txtTieuDe';
                            }
                            else
                            {
                                $name = $_POST['txtTieuDe'];
                            }
                            $intro = $_POST['txtMota'];
                            $user_id = $_SESSION['uid'];
                            if(empty($errors))
                            {
                                //INSERT VÀO DATABASE hoat dong
                                $query_tt = "INSERT INTO hoatdong(tieu_de,mo_ta,nguoi_dang) VALUES('{$name}','{$intro}',$user_id) ";
                                $results_tt = mysqli_query($dbc, $query_tt);

                                $mangFile = $_FILES['img'];
                                for($i = 0; $i < count($mangFile["name"]); $i++)
                                {
                                    if($_FILES['img']['size'][$i]=='') 
                                    {
                                        $message="<p class='text-danger'>Hình ảnh không được bỏ trống</p>";
                                    }
                                    else if(($_FILES['img']['type'][$i]!="image/gif")
                                        &&($_FILES['img']['type'][$i]!="image/png")
                                        &&($_FILES['img']['type'][$i]!="image/jpeg")
                                        &&($_FILES['img']['type'][$i]!="image/jpg"))
                                    {
                                        $message="<p class='text-danger'>File không đúng định dạnh</p>";   
                                    }
                                    else if($_FILES['img']['size'][$i]>1000000) 
                                    {
                                        $message="<p class='text-danger'>Kich thước phải nhỏ hơn 1MB</p>";                     
                                    }
                                    
                                    else
                                    {
                                        $img=$_FILES['img']['name'][$i];
                                        $link_img = $img;
                                        move_uploaded_file($_FILES['img']['tmp_name'][$i],"../images/hinhhd/".$img); 
                                        //INSERT VÀO DATABASE hinh hoat dong
                                        $max = mysqli_query($dbc,"SELECT max(id) FROM hoatdong");
                                        $hoatdong_id = mysqli_fetch_array($max);
                                        //$hoatdong_id[0] lấy id dau tiên trong $max
                                        $query_img = "INSERT INTO hinhhoatdong(hoat_dong_id, hinh) VALUES({$hoatdong_id[0]}, '{$link_img}') ";
                                        $results_img = mysqli_query($dbc, $query_img);
                                        if(mysqli_affected_rows($dbc) == 1)
                                        {
                                        ?>
                                            <script>
                                                alert("Thêm thành công");
                                                window.location="admin-hoatdong.php";
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
                            <label>Tiêu Đề</label>
                            <input class="form-control" name="txtTieuDe" placeholder="Vui lòng nhập tên tiêu đề" value = "<?php if(isset($_POST['txtTieuDe'])) {echo $_POST['txtTieuDe'];} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtTieuDe',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên tin tức</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <input class="form-control" name="txtMota" placeholder="Vui lòng nhập tên tiêu đề" value = "<?php if(isset($_POST['txtMota'])) {echo $_POST['txtMota'];} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtMota',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên tin tức</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-info" id="addImages">Thêm Hình Ảnh</button>
                        </div>
                        <div id="insert">
                            <input type="file" name="img[]">
                        </div>
                            <br /><button type="submit" name="them" class="btn btn-info">Thêm Thông Tin</button>
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