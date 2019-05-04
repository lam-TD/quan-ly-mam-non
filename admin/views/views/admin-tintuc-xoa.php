<?php 
include "../../inc/myconnect.php";
include "../../inc/myfunction.php";
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	//xóa hình ảnh trong thư mục upload
	$sql="SELECT hinh FROM tintuc WHERE id={$id}";
	$query_a=mysqli_query($dbc,$sql);
	$anhInfo=mysqli_fetch_assoc($query_a); //Hiện thị 1 bảng ghi, nếu nhiều bảng ghi thì sd list
	unlink('../images/tintuc/'.$anhInfo['hinh']);
	
	$query="DELETE FROM tintuc WHERE id={$id}";
	$result=mysqli_query($dbc,$query);
	header('Location: admin-tintuc.php');
}
else
{
	header('Location: admin-tintuc.php');	
}
?>