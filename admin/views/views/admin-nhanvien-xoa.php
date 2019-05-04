<?php
include "../../inc/myconnect.php";
//Kiểm tra ID có phải là kiểu số không, filter_var kiem tra có thuộc tính trim sẽ loại bỏ khoảng trắng
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    $nhan_vien_id = $_GET['id'];
    //Xoa nguoi dung
    $query_nd = "SELECT * FROM nguoidung WHERE nhan_vien_id = $nhan_vien_id";
    $results_nd= mysqli_query($dbc, $query_nd);
    if(mysqli_num_rows($results_nd) == 1)
    {
    ?>
        <script>
            alert("Nhân viên có tài khoản, không thể xoá");
            window.location="admin-nhanvien.php";
        </script>
    <?php
    }
    else
    {
        //Xoa hop dong
        $query_hd = "DELETE FROM hopdong WHERE nhan_vien_id = $nhan_vien_id";
        $results_hd= mysqli_query($dbc, $query_hd);
        //Xoa cong tac
        $query_ct = "DELETE FROM congtac WHERE nhan_vien_id = $nhan_vien_id";
        $results_ct= mysqli_query($dbc, $query_ct);
        //Xoá nhân viên
        $query_nv = "DELETE FROM nhanvien WHERE id = $nhan_vien_id";
        $results_nv = mysqli_query($dbc, $query_nv);
        ?>
            <script>
                alert("Xoá thành công");
                window.location="admin-nhanvien.php";
            </script>
        <?php
    }
}
else
{
    ?>
        <script>
            alert("Xoá không thành công");
            window.location="admin-nhanvien.php";
        </script>
    <?php
}

?>