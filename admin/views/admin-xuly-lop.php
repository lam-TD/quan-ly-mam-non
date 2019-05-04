<?php
include "../../inc/myconnect.php";
include "../../inc/myfunction.php";

if(isset($_GET['ten_lop']) && $_GET['check_lop']) {
    $reslut = mysqli_query($dbc, "SELECT * FROM lophoc_chitiet WHERE mo_ta = '{$_GET['ten_lop']}'");
    if(mysqli_fetch_array($reslut)) echo 1;
    else echo -1;
}

if(isset($_POST['add'])) {
    $ten_lop = $_POST['ten_lop'];
    $id_lop = $_POST['id_lop'];
    $id_nien_khoa = $_POST['id_nien_khoa'];
    $arr_nhan_vien = $_POST['arr_nhan_vien'];

    $query="INSERT INTO lophoc_chitiet (lop_hoc_id, nien_khoa_id, mo_ta) VALUES ({$id_lop}, {$id_nien_khoa}, '{$ten_lop}')";
    $reslut = mysqli_query($dbc, $query);
    if($reslut) {
        echo 1;
    }
    else echo $query;

}