<?php 
include "../../inc/myconnect.php";
//Kiểm tra id
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	//Xoa  bang cap
	$query="DELETE FROM phongban WHERE phong_ban_id={$id}";
	$result=mysqli_query($dbc,$query);
	header('Location: admin-phongban.php');
}
else
{
	header('Location: admin-phongban.php');
	exit();
}
?>