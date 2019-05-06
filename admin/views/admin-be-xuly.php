<?php
include "../../inc/myconnect.php";
include "../../inc/myfunction.php";


if(isset($_POST['get_data_lop_hoc'])) {
    $id_nien_khoa = (int)$_POST['id_nien_khoa'];
    $query = mysqli_query($dbc, "SELECT * FROM lophoc_chitiet WHERE nien_khoa_id = {$id_nien_khoa}");
    $result = array();

    if (mysqli_num_rows($query) > 0)
    {
        while ($row = mysqli_fetch_array($query)){
            $result[] = array(
                'id' => $row['id'],
                'mo_ta' => $row['mo_ta']
            );
        }
    }
    echo json_encode($result);
}