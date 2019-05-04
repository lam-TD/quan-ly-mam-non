<?php 
include "../../inc/myconnect.php";
//Kiểm tra id
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	//xoa cac bai viet co the loai  giong id
	$query_tt = "DELETE FROM tintuc WHERE loai_tin_id = $id";
	$result_tt = mysqli_query($dbc, $query_tt);
	//Xoa the loai id
	$query="DELETE FROM loaitin WHERE id={$id}";
	$result=mysqli_query($dbc,$query);
	header('Location: admin-loaitin.php');
}
else
{
	header('Location: admin-loaitin.php');
}
?>