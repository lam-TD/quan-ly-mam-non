<?php 
include "../../inc/myconnect.php";
//Kiểm tra id
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	//Xoa  bang cap
	$query="DELETE FROM bangcap WHERE bang_cap_id={$id}";
	$result=mysqli_query($dbc,$query);
	header('Location: admin-bangcap.php');
}
else
{
	header('Location: admin-bangcap.php');
}
?>