<?php
include "../../inc/myconnect.php";
include "../../inc/myfunction.php";

if(isset($_GET['ten_lop']) && $_GET['check_lop']) {
    $reslut = mysqli_query($dbc, "SELECT * FROM lophoc_chitiet WHERE mo_ta = '{$_GET['ten_lop']}'");
    if(mysqli_fetch_array($reslut)) echo 1;
    else echo -1;
}


// Thêm mới lớp học
if (isset($_POST['add'])) {
    $ten_lop = $_POST['ten_lop'];
    $id_lop = $_POST['id_lop'];
    $id_nien_khoa = $_POST['id_nien_khoa'];
    $arr_nhan_vien = (array)$_POST['arr_nhan_vien'];

    $query = "INSERT INTO lophoc_chitiet (lop_hoc_id, nien_khoa_id, mo_ta) VALUES ({$id_lop}, {$id_nien_khoa}, '{$ten_lop}')";
    $reslut = mysqli_query($dbc, $query);
    if ($reslut) {
        if (is_array($arr_nhan_vien) && count($arr_nhan_vien) > 0) {
            // lấy id lớp học mới được thêm vào
            $id_lop_hoc_moi_them = mysqli_fetch_row(mysqli_query($dbc, "SELECT id FROM lophoc_chitiet ORDER BY id DESC LIMIT 1"));

            // thêm nhân viên vào lớp học
            for ($i = 0; $i < count($arr_nhan_vien); $i++) {
                $query_insert = "INSERT INTO lophoc_nhanvien (nhan_vien_id, lop_hoc_chi_tiet_id) VALUES ({$arr_nhan_vien[$i]}, {$id_lop_hoc_moi_them[0]})";

                mysqli_query($dbc, $query_insert);
            }
        }
        echo 1;
    } else echo $query;

}

// Xóa lớp học
if(isset($_POST['delete']) && isset($_POST['id_chi_tiet_lop_hoc'])) {
    $id = (int)$_POST['id_chi_tiet_lop_hoc'];
    $query = "DELETE FROM lophoc_chitiet WHERE id = {$id}";
    if(mysqli_query($dbc, $query))  echo 1;
    else echo -1;
}

// Load chi tiết một lớp học
if (isset($_POST['load_info_item']) && isset($_POST['id_chi_tiet_lop_hoc'])) {
    $id = (int)$_POST['id_chi_tiet_lop_hoc'];
    //Load
    $data = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT * FROM lophoc_chitiet WHERE id = {$id}"));

    // Load thông tin nhân viên của lớp học
    $nhan_vien = (mysqli_query($dbc, "SELECT nhan_vien_id FROM lophoc_nhanvien WHERE lop_hoc_chi_tiet_id = {$id}"));
    $ar_nv = [];
    foreach ($nhan_vien as $item) {
        $ar_nv[] = $item['nhan_vien_id'];
    }
    $data['nv'] = $ar_nv;

    echo json_encode($data);
}

// Cập nhật lớp học
if (isset($_POST['edit'])) {
    $ten_lop = $_POST['ten_lop'];
    $id_lop = $_POST['id_lop'];
    $id_chi_tiet_lop = $_POST['id_chi_tiet_lop'];
    $id_nien_khoa = $_POST['id_nien_khoa'];
    $arr_nhan_vien = isset($_POST['arr_nhan_vien']) ? (array)$_POST['arr_nhan_vien'] : [];

    $query = "UPDATE lophoc_chitiet
              SET lop_hoc_id = {$id_lop}, nien_khoa_id = {$id_nien_khoa}, mo_ta = '{$ten_lop}'
              WHERE id = {$id_chi_tiet_lop} 
              ";
    $reslut = mysqli_query($dbc, $query);
    if ($reslut) {
        if (count($arr_nhan_vien) > 0) {

            // Xóa những nhân viên cũ trong lớp
            mysqli_query($dbc, "DELETE FROM lophoc_nhanvien WHERE lop_hoc_chi_tiet_id = {$id_chi_tiet_lop}");
            $query_xoa_nhan_vien = mysqli_affected_rows($dbc);

            // thêm nhân viên vào lớp học
            for ($i = 0; $i < count($arr_nhan_vien); $i++) {
                $query_insert = "INSERT INTO lophoc_nhanvien (nhan_vien_id, lop_hoc_chi_tiet_id) VALUES ({$arr_nhan_vien[$i]}, {$id_chi_tiet_lop})";

                mysqli_query($dbc, $query_insert);
            }
        }
        echo 1;
    } else echo -1;
}
