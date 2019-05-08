<?php
include "../../inc/myconnect.php";
include "../../inc/myfunction.php";

if(isset($_POST['add'])) {
    $data = (object)$_POST['data'];

    foreach ($data as $key => $week) {
        if($week){
            foreach ($week as $item){
//                create_menu((object)$item, $key, $dbc);

                $query = "INSERT INTO menu ( buoi, t2, t3, t4, t5, t6, t7, chua_nhat, ngay_tao, tuan_trong_thang )
                          VALUES ( 
                          '{$item['buoi']}', 
                          '{$item['thu2']}',
                          '{$item['thu3']}',
                          '{$item['thu4']}',
                          '{$item['thu5']}',
                          '{$item['thu6']}',
                          '{$item['thu7']}',
                          '{$item['thu7']}',
                          NOW( ), 
                          '{$key}' 
                          )";
                mysqli_query($dbc, $query);
            }
        }
    }
    echo 1;
}


function create_menu ($item, $week, $dbc) {

    $query = "INSERT INTO menu ( buoi, t2, t3, t4, t5, t6, t7, chua_nhat, ngay_tao, tuan_trong_thang )
              VALUES ( 
              $item->buoi, 
              $item->thu2, 
              $item->thu3, 
              $item->thu4, 
              $item->thu5, 
              $item->thu6, 
              $item->thu7, 
              $item->thu7, 
              NOW( ), 
              $week 
              )";
    mysqli_query($dbc, $query);
    return 1;
}