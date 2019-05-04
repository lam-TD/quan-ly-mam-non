<?php
include "../../inc/myconnect.php";
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    $id=$_GET['id'];
    //Xoá hình trong thư mục
    $sql="SELECT hinh FROM hinhhoatdong WHERE hoat_dong_id={$id}";
    $query_a=mysqli_query($dbc,$sql);
    $anhInfo=mysqli_fetch_assoc($query_a); //Hiện thị 1 bảng ghi, nếu nhiều bảng ghi thì sd list
    unlink('../images/hinhhd/'.$anhInfo['hinh']);

    //Xoa bảng hình hoạt động
    $query_bh = "DELETE FROM hinhhoatdong WHERE hoat_dong_id =  $id";
    $result_bh = mysqli_query($dbc, $query_bh);

    //xoá bảng hoạt động
    $query = "DELETE FROM hoatdong WHERE id = $id";
    $result = mysqli_query($dbc, $query);

    header('Location: admin-hoatdong.php');
}
else
{
    header('Location: admin-hoatdong.php'); 
}