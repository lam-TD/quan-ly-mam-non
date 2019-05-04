<?php 
include "../../inc/myconnect.php";
//Kiểm tra id
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
    //Truy van bang nhan vien de xem co id cua cong viec hay không, nếu có không thể xoá
    $query_nv="SELECT * FROM nhanvien WHERE cong_viec_id = $id";
    $result_nv=mysqli_query($dbc,$query_nv);
    if(mysqli_num_rows($result_nv) >= 1)
    {
    ?>
    	<script>
    		alert("Công việc đang có nhân viên làm, không thể xoá !!");
			window.location="admin-congviec.php";
    	</script>
    <?php
    }
    else
    {
    	//Xoa  bang cap
		$query="DELETE FROM congviec WHERE congviec_id ={$id}";
		$result=mysqli_query($dbc,$query);
		header('Location: admin-congviec.php');
		
	}	
}
else
{
	header('Location: admin-congviec.php');
	exit();
}
?>