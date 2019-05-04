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
                    <h5 class="text-info">Sửa hoạt động</h5>
                    <?php
                     //Kiểm tra ID có phải là kiểu số không
                        if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
                        {
                            $id=$_GET['id'];
                        }
                        else
                        {
                            header('Location: admin-hoatdong.php');
                            exit();
                        }
                        if(isset($_POST['sua']))
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
                                $query="UPDATE hoatdong
                                        SET tieu_de='{$name}',
                                            mo_ta = '{$intro}',
                                            nguoi_dang = {$user_id}
                                        WHERE id={$id}";
                                $results = mysqli_query($dbc, $query);
                                if(isset($_FILES['img']))
                                {
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
                                            $query_img = "INSERT INTO hinhhoatdong(hoat_dong_id, hinh) VALUES({$id}, '{$link_img}') ";
                                            $results_img = mysqli_query($dbc, $query_img);
                                        }
                                    }
                                }
                                
                                if(mysqli_affected_rows($dbc) == 1)
                                {
                                ?>
                                    <script>
                                        alert("Sửa thành công");
                                        window.location="admin-hoatdong.php";
                                    </script>
                                <?php
                                }
                                else
                                {
                                    header("Location: admin-hoatdong.php");   
                                } 
                            }
                            else
                            {
                                $message="<p class='text-danger'>Bạn hãy nhập đầy đủ thông tin</p>";
                            }
                        }
                        $query_id="SELECT tieu_de, mo_ta, nguoi_dang FROM hoatdong WHERE id={$id}";
                        $result_id=mysqli_query($dbc,$query_id);
                        //Kiểm tra xem ID có tồn tại không
                        if(mysqli_num_rows($result_id)==1)
                        {
                            list($name, $intro, $user_id)=mysqli_fetch_array($result_id,MYSQLI_NUM);
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
                            <label>Tiêu Đề</label>
                            <input class="form-control" name="txtTieuDe" placeholder="Vui lòng nhập tên tiêu đề" value = "<?php if(isset($name)) {echo $name;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtTieuDe',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên tin tức</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="txtMota" class="form-control" rows="3"><?php if(isset($intro)){ echo $intro;} ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="button" name="addImg" class="btn btn-info" id="addImages">Thêm Hình Ảnh</button>
                        </div>
                        <div id="insert">
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <?php
                            $query_simg="SELECT * FROM hinhhoatdong WHERE hoat_dong_id={$id}";
                            $result_simg=mysqli_query($dbc,$query_simg);
                            foreach ($result_simg as $item) {
                            ?>
                                <div class="form-group">
                                    <img width="100" src="../images/hinhhd/<?php echo $item['hinh'] ?>">
                                </div>
                                <div class="form-group">
                                    <a href="admin-hinhhoatdong-xoa.php?id=<?php echo $item['id'] ?>&idhoatdong=<?php echo $id ?>"><input type="button" class="btn" value="Xoá"></a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                           <button type="submit" name="sua" class="btn btn-info">Sửa Thông Tin</button>
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