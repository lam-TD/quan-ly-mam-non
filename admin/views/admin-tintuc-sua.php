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
            <h3 class="page-title">Tin Tức</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h5 class="text-info">Sửa tin tức</h5>
                    <?php
                        //Kiểm tra ID có phải là kiểu số không
                        if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
                        {
                            $id=$_GET['id'];
                        }
                        else
                        {
                            header('Location: admin-tintuc.php');
                            exit();
                        }
                        if($_SERVER['REQUEST_METHOD'] == 'POST')
                        {
                            $errors = array();
                            if(empty($_POST['txtTenTinTuc']))
                            {
                                $errors[] = 'txtTenTinTuc';
                            }
                            else
                            {
                                $name = $_POST['txtTenTinTuc'];
                            }
                            if(empty($_POST['theloaicha']))
                            {
                                $errors[] = 'theloaicha';
                            }
                            else
                            {
                                $theloaicha = $_POST['theloaicha'];
                            }
                            $intro = $_POST['txtTomTat'];
                            $content = $_POST['txtNoiDung'];
                            $user_id = $_SESSION['uid'];
                            if(empty($errors))
                            {
                                if ($_FILES['img']['size']=='') 
                                {
                                     $link_img=$_POST['anh_hi'];
                                }
                                else
                                {
                                    if(($_FILES['img']['type']!="image/gif")
                                        &&($_FILES['img']['type']!="image/png")
                                        &&($_FILES['img']['type']!="image/jpeg")
                                        &&($_FILES['img']['type']!="image/jpg"))
                                    {
                                        $message="<p class='text-danger'>File không đúng định dạnh</p>";  
                                    }
                                    else if ($_FILES['img']['size']>1000000) 
                                    {
                                        $message="<p class='text-danger'>Kich thước phải nhỏ hn 1MB</p>";                     
                                    }
                                    else
                                    {
                                        $img=$_FILES['img']['name'];
                                        $link_img = $img;
                                        move_uploaded_file($_FILES['img']['tmp_name'],"../images/tintuc/".$img);
                                    }
                                    //xoa anh trong thu muc 
                                    $sql="SELECT hinh FROM tintuc WHERE id={$id}";
                                    $query_a=mysqli_query($dbc,$sql);
                                    $anhInfo=mysqli_fetch_assoc($query_a);
                                    unlink('../images/tintuc/'.$anhInfo['hinh']);
                                }
                                //UPDATE VÀO DATABASE
                                $query="UPDATE tintuc
                                        SET tieude='{$name}',
                                            tomtat='{$intro}',
                                            noidung = '{$content}',
                                            hinh = '{$link_img}',
                                            loai_tin_id ={$theloaicha},
                                            nguoi_dang = {$user_id}
                                        WHERE id={$id}";
                                $results=mysqli_query($dbc,$query);
                                if(mysqli_affected_rows($dbc) == 1)
                                {
                                ?>
                                    <script>
                                        alert("Sửa thành công");
                                        window.location="admin-tintuc.php";
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
                                $message="<p class='required'>Bạn hãy nhập đầy đủ thông tin</p>";
                            }
                        } 
                        $query_id="SELECT tieude, tomtat, noidung, hinh, loai_tin_id, nguoi_dang FROM tintuc WHERE id={$id}";
                        $result_id=mysqli_query($dbc,$query_id);
                        //Kiểm tra xem ID có tồn tại không
                        if(mysqli_num_rows($result_id)==1)
                        {
                            list($name,$intro, $content, $link_img, $theloaicha, $user_id)=mysqli_fetch_array($result_id,MYSQLI_NUM);
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
                            <label style="display:block">Thể Loại</label>
                            <select class="form-control" name="theloaicha">
                            <option value="0">Vui Lòng Chọn Thể Loại</option>
                            <?php 
                                selectCtrl_e($theloaicha); 
                                if(isset($errors) && in_array('theloaicha',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa chọn thể loại</p>";
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tên Tin Tức</label>
                            <input class="form-control" name="txtTenTinTuc" placeholder="Vui lòng nhập tên tin tức" value = "<?php if(isset($name)) {echo $name;} ?>">
                            <?php 
                                if(isset($errors) && in_array('txtTenTinTuc',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên tin tức</p>";
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <p><img width="100" src="../images/tintuc/<?php echo $link_img; ?>"></p>
                            <input type="hidden" name="anh_hi" value="<?php echo $link_img; ?>">
                            <input type="file" name="img">
                        </div>
                        <div class="form-group">
                            <label>Tóm Tắt</label>
                            <textarea name="txtTomTat" class="form-control" rows="3"><?php if(isset($intro)){ echo $intro;} ?></textarea>
                            <script>
                                var editor = CKEDITOR.replace('txtTomTat');
                            </script>
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea  name="txtNoiDung" class="form-control" rows="3"><?php if(isset($content)){ echo $content;} ?></textarea>
                            <script>
                                var editor = CKEDITOR.replace( 'txtNoiDung', {
                                    language : 'vi',
                                    filebrowserImageBrowseUrl : '../ckfinder/ckfinder.html?type=Images',
                                    filebrowserFlashBrowseUrl : '../ckfinder/ckfinder.html?type=Flash',
                                    filebrowserImageUploadUrl : '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                    filebrowserFlashUploadUrl : '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                                    filebrowserUploadUrl : '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
                                } );
                            </script>
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