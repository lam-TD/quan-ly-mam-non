<?php
include "../../inc/myconnect.php";
//Kiểm tra ID có phải là kiểu số không, filter_var kiem tra có thuộc tính trim sẽ loại bỏ khoảng trắng
if(isset($_GET['idnv']) && filter_var($_GET['idnv'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    $nhan_vien_id = $_GET['idnv'];
}
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    $id=$_GET['id'];
    //Xoa hop dong
    $query = "DELETE FROM hopdong WHERE hop_dong_id = $id";
    $result= mysqli_query($dbc, $query);
    ?>
        <script>
            alert("Xoá thành công");
            window.location="admin-hopdong.php?id=<?php echo $nhan_vien_id ?>";
        </script>
    <?php
}
else
{
    ?>
        <script>
            alert("Xoá không thành công");
            window.location="admin-hopdong.php?id=<?php echo $nhan_vien_id ?>";
        </script>
    <?php
}

?>