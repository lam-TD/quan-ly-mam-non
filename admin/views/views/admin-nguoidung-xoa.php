<?php 
include "../../inc/myconnect.php";
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
    //Lay nguoi dang tu bang hoat dong
    $query_hd="SELECT nguoi_dang FROM hoatdong WHERE nguoi_dang = $id";
    $result_hd=mysqli_query($dbc,$query_hd);
	//Lay nguoi dang tu bang tin tuc
	$query_tt="SELECT * FROM tintuc WHERE nguoi_dang = $id";
    $result_tt=mysqli_query($dbc,$query_tt);
    if(mysqli_num_rows($result_tt) >= 1 || mysqli_num_rows($result_hd) >= 1)
    {
    ?>
    	<script>
    		alert("Người dùng có bài đăng, không thể xoá");
			window.location="admin-nguoidung.php";
    	</script>
    <?php
    }
    else
    {
    	//Xoá người dùng
		$query="DELETE FROM nguoidung WHERE id={$id}";
		$result=mysqli_query($dbc,$query);
		header('Location: admin-nguoidung.php');
    }
}
else
{
	header('Location: admin-nguoidung.php');
	exit();
}
?>