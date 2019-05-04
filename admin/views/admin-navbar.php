<div class="main-navbar sticky-top bg-white">
    <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
        <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
            <div class="input-group input-group-seamless ml-3">
                <div class="input-group-prepend">
                </div>
            </div>
        </form>
        <?php
            include "../../inc/myconnect.php";
            $id_nd = $_SESSION['uid'];
            //Lay id nhan vien co session id
            $query="SELECT nhan_vien_id FROM nguoidung WHERE id = $id_nd";
            $result=mysqli_query($dbc,$query);
            //Kiểm tra xem ID có tồn tại không
            if(mysqli_num_rows($result)==1)
            {
                list($nhanvienid)=mysqli_fetch_array($result,MYSQLI_NUM);
            }
            //Lay ten nhan vien co nhan vien id
            $query_nv="SELECT ho_ten FROM nhanvien WHERE id = $nhanvienid";
            $result_nv=mysqli_query($dbc,$query_nv);
            //Kiểm tra xem ID có tồn tại không
            if(mysqli_num_rows($result_nv)==1)
            {
                list($hotennv)=mysqli_fetch_array($result_nv,MYSQLI_NUM);
            } 
        ?>
        <ul class="navbar-nav border-left flex-row ">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="d-none d-md-inline-block"><?php if(isset($hotennv)){ echo $hotennv;} ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="doimatkhau.php?id=<?php echo $id_nd; ?>">
                        <i class="material-icons"></i> Đổi mật khẩu </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="dangxuat.php">
                        <i class="material-icons text-danger">&#xE879;</i> Đăng xuất </a>
                </div>
            </li>
        </ul>
        <nav class="nav">
            <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                <i class="material-icons">&#xE5D2;</i>
            </a>
        </nav>
    </nav>
</div>