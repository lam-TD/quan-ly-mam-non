<?php
include "../../inc/myconnect.php";
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)) && isset($_GET['idhoatdong']) && filter_var($_GET['idhoatdong'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    $idhoatdong = $_GET['idhoatdong'];
    $id=$_GET['id'];
    //Xoá hình trong thư mục
    $sql="SELECT hinh FROM hinhhoatdong WHERE id={$id}";
	$query_a=mysqli_query($dbc,$sql);
	$anhInfo=mysqli_fetch_assoc($query_a); //Hiện thị 1 bảng ghi, nếu nhiều bảng ghi thì sd list
	unlink('../images/hinhhd/'.$anhInfo['hinh']);

    //Xoa bảng
    $query = "DELETE FROM hinhhoatdong WHERE id=$id";
    $result = mysqli_query($dbc, $query);
    header("Location: admin-hoatdong-sua.php?id=$idhoatdong");
}
else
{
	header("Location: admin-hoatdong-sua.php?id=$idhoatdong");	
}
?>
