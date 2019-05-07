<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<!-- End header-->

<!-- LOAD DỮ LIỆU -->
<?php
$data_lop_hoc = mysqli_query($dbc,"SELECT * FROM lophoc_chitiet");

// lấy danh sách niên khóa
$data_nien_khoa = mysqli_query($dbc,"SELECT * FROM nienkhoa ORDER BY id DESC");
?>


<link rel="stylesheet" href="../styles/admin/style.css">
<!-- Page content-->
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Quản lý</span>
            <h3 class="page-title">Đào tạo</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4" style="padding: 40px 60px">
                <div class="card-header" style="padding-bottom: 0">
                    <h5 class="text-info">CẬP NHẬT THÔNG TIN CỦA BÉ</h5>
                </div>

                <div class="card-body" style="padding-top: 0;">
                    <?php
                    if (isset($_POST['btn-submit-be'])) {
                        $errors = array();
                        $have_dad = false;
                        $have_mom = false;
                        if ( empty( $_POST[ 'txtTenBe' ] ) ) {
                            $errors[] = 'txtTenBe';
                        } else {
                            $name = $_POST[ 'txtTenBe' ];
                        }
                        if ( isset($_POST[ 'txtNgaySinh' ]) && empty( $_POST[ 'txtNgaySinh' ] ) ) {
                            $errors[] = 'txtNgaySinh';
                        } else {
                            $ngaysinh = $_POST[ 'txtNgaySinh' ];
                        }
                        if ( empty( $_POST[ 'txtDiaChi' ] ) ) {
                            $errors[] = 'txtDiaChi';
                        } else {
                            $diachi = $_POST[ 'txtDiaChi' ];
                        }

                        if(empty($_POST['temp-image-input'])){
                            if($_FILES['hinhBe']['size'] == 0) {
                                $mesErrorHinhBe = "Bạn chưa chọn ảnh bé";
                            } else if ( ( $_FILES[ 'hinhBe' ][ 'type' ] != "image/gif" ) &&
                                ( $_FILES[ 'hinhBe' ][ 'type' ] != "image/png" ) &&
                                ( $_FILES[ 'hinhBe' ][ 'type' ] != "image/jpeg" ) &&
                                ( $_FILES[ 'hinhBe' ][ 'type' ] != "image/jpg" ) ) {
                                $mesErrorHinhBe = "File không đúng định dạnh";
                            } else if ( $_FILES[ 'hinhBe' ][ 'size' ] > 1000000 ) {
                                if(!in_array('hinhBe',$errors))
                                    $mesErrorHinhBe = "Kich thước phải nhỏ hơn 1MB";
                            } else {
                                $temp_file = "../images/temp-image/".$_FILES[ 'hinhBe' ]['name'];
                                copy($_FILES[ 'hinhBe' ]['tmp_name'],$temp_file);
                            }
                        }
                        else{
                            $temp_file = $_POST['temp-image-input'];
                        }
                        if(is_numeric($_POST[ 'txtChieuCao' ])){
                            if($_POST[ 'txtChieuCao' ]<=0)
                                $errors[] = 'txtChieuCao';
                            else{
                                $chieucao = $_POST[ 'txtChieuCao' ];
                            }
                        }
                        else{
                            $errors[] = 'txtChieuCao';
                        }
                        if(is_numeric($_POST[ 'txtCanNang' ])){
                            if($_POST[ 'txtCanNang' ]<=0)
                                $errors[] = 'txtCanNang';
                            else{
                                $cannang = $_POST[ 'txtCanNang' ];
                            }
                        }
                        else{
                            $errors[] = 'txtCanNang';
                        }

                        if ( !empty( $_POST[ 'txtTenCha' ]) || !empty( $_POST[ 'txtSDTCha' ] )){
                            if ( empty( $_POST[ 'txtTenCha' ] ) ) {
                                $errors[] = 'txtTenCha';
                            } else {
                                $tencha = $_POST[ 'txtTenCha' ];
                            }
                            if ( is_numeric( $_POST[ 'txtSDTCha' ] ) ) {
                                if ( strlen( $_POST[ 'txtSDTCha' ] ) != 10 )
                                    $errors[] = 'txtSDTCha2';
                                else
                                    $sdtCha = $_POST[ 'txtSDTCha' ];
                            } else {
                                $errors[] = 'txtSDTCha';
                            }
                            if(isset($tencha) && isset($sdtCha)){
                                $have_dad = true;
                            }
                        }

                        if ( !empty( $_POST[ 'txtTenMe' ]) || !empty( $_POST[ 'txtSDTMe' ] )){
                            if ( empty( $_POST[ 'txtTenMe' ] ) ) {
                                $errors[] = 'txtTenMe';
                            } else {
                                $tenme = $_POST[ 'txtTenMe' ];
                            }
                            if ( is_numeric( $_POST[ 'txtSDTMe' ] ) ) {
                                if ( strlen( $_POST[ 'txtSDTMe' ] ) != 10 )
                                    $errors[] = 'txtSDTMe2';
                                else
                                    $sdtMe = $_POST[ 'txtSDTMe' ];
                            } else {
                                $errors[] = 'txtSDTMe';
                            }
                            if(isset($tenme) && isset($sdtMe)){
                                $have_mom = true;
                            }
                        }
                        if(!$have_dad && !$have_mom){
                            $errors[] = 'parents';
                        }

                        if (!$_POST['nien_khoa']) {
                            $errors[] = 'nien_khoa';
                        }

                        if (!isset($_POST['lop_hoc']) || !$_POST['lop_hoc']) {
                            $errors[] = 'lop_hoc';
                        }

                        if ( empty( $errors )) {
                            if(!$have_dad){
                                $tencha = '';
                                $sdtCha = '';
                            }
                            if(!$have_mom){
                                $tenme = '';
                                $sdtMe = '';
                            }
                            $tinhtrangsuckhoe = $_POST['txtSucKhoe'];
                            $benh = $_POST['txtBenhBS'];
                            $gioitinh = $_POST[ 'slGioiTinh' ];
                            $trangthai = 1;

                            $query_tt = "UPDATE be 
                                        SET ten='{$name}', ngaysinh='{$ngaysinh}', gioitinh='{$gioitinh}', chieucao='{$chieucao}', cannang='{$cannang}', diachi='{$diachi}', tinhtrangsuckhoe='{$tinhtrangsuckhoe}', 
                                        benhbamsinh='{$benh}', tencha='{$tencha}', sdtcha='{$sdtCha}', tenme='{$tenme}', sdtme='{$sdtMe}', trangthai = 1";

                            if(!empty($temp_file)) {
                                $fileName = randomDigitsLame(4).'_'.randomDigitsLame(14).substr($temp_file,strrpos($temp_file, '.', -0));
                                copy($temp_file,"../images/hinhbe/".$fileName);
                                $query_tt .= ", hinhbe='{$fileName}'";
                            }
                            if (isset($_GET['id'])) $id_be = (int)$_GET['id'];
                            $query_tt .= " WHERE id={$id_be}";
                            echo $query_tt;
                            $results_tt = mysqli_query( $dbc, $query_tt );
                            if ( mysqli_affected_rows( $dbc ) >= 0 ) {
                                // xóa thông tin lớp của bé để cập nhật lại thông tin lớp mới
                                $delete_lop_hoc_cua_be = mysqli_query($dbc, "DELETE FROM lophoc_be WHERE be_id = {$id_be}");
                                $data_be = mysqli_affected_rows($dbc);
                                $lop_hoc_chi_tiet_id = $_POST['lop_hoc'];
                                if($data_be > 0 && $lop_hoc_chi_tiet_id){
                                    $insert_vao_lop_hoc = mysqli_query($dbc, "INSERT INTO lophoc_be (be_id, lop_hoc_chi_tiet_id) VALUES ({$id_be}, {$lop_hoc_chi_tiet_id})");
                                }
                                ?>
                                <script>
                                    alert( "Cập nhật thành công" );
                                    window.location = "admin-be-sua.php?id="+"<?php echo $_GET['id']?>";
                                </script>
                                <?php
                            } else {
                                echo "<script>";
                                echo 'alert("Cập nhật không thành công")';
                                echo "</script>";
                            }
                        } else {
                            $message = "<p class='text-danger'>Bạn hãy nhập đầy đủ thông tin</p>";
                        }
                    }
                    if ( isset( $message ) ) {
                        echo $message;
                    }
                    ?>

                    <!-- Lấy thông tin của bé theo id=? -->
                    <?php
                    $id_be = 0;
                    if (isset($_GET['id'])) {
                        $id_be = (int)$_GET['id'];
                        // thực hiện truy vấn nhiều bảng thông qua các khóa ngoại để lấy thông tin chi tiết của bé, thông tin lớp học
                        $query = "SELECT * FROM be 
                                  INNER JOIN lophoc_be ON be.id = lophoc_be.be_id 
                                  INNER JOIN lophoc_chitiet ON lophoc_be.lop_hoc_chi_tiet_id = lophoc_chitiet.id 
                                  WHERE be.id = {$id_be}";

                        $results = mysqli_query($dbc, $query);
                        $detail_be = mysqli_fetch_object($results); // chỉ lấy một dòng dữ liệu
                        if (empty($detail_be)) { // kiểm tra thông tin của bé nếu null thì thông báo
                            echo "Không tìm thấy thông tin của bé";
                            return;
                        }
                        $url_img = "../images/hinhbe/". $detail_be->hinhbe; // lấy đường dẫn ảnh của bé
                    }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data" style="margin-top: 0px">
                        <div class="row parent-zone">
                            <div class="title-absolute"><span>Thông tin bé</span></div>
                            <div class="row w-100">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Họ và tên bé <span class="dot-required">*</span></label>
                                        <input class="form-control" name="txtTenBe" placeholder="Vui lòng nhập tên bé" value="<?php if(isset($detail_be->ten)) {echo $detail_be->ten;} ?>">
                                        <?php
                                        if(isset($errors) && in_array('txtTenBe',$errors))
                                        {
                                            echo "<p class='text-danger'>Bạn chưa nhập tên bé</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Ngày sinh <span class="dot-required">*</span></label>
                                        <input type="date" class="form-control" name="txtNgaySinh" placeholder="Vui lòng nhập ngày sinh" value="<?php if(isset($detail_be->ngaysinh)) {echo $detail_be->ngaysinh;} ?>">
                                        <?php
                                        if(isset($errors) && in_array('txtNgaySinh',$errors))
                                        {
                                            echo "<p class='text-danger'>Bạn chưa nhập ngày sinh bé</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Giới tính  <span class="dot-required">*</span></label>
                                        <select class="form-control" name="slGioiTinh">
                                            <option <?php if(isset($detail_be->gioitinh) && $detail_be->gioitinh == 1) echo "selected"?> value="1">Nam</option>
                                            <option <?php if(isset($detail_be->gioitinh) && $detail_be->gioitinh == 2) echo "selected"?> value="2">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Chiều cao(cm) <span class="dot-required">*</span></label>
                                        <input class="form-control" name="txtChieuCao" placeholder="Vui lòng nhập chiều cao của bé" value="<?php if(isset($detail_be->chieucao)) {echo $detail_be->chieucao;} ?>">
                                        <?php
                                        if(isset($errors) && in_array('txtChieuCao',$errors))
                                        {
                                            echo "<p class='text-danger'>Chiều cao bé không hợp lệ</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Cân nặng(kg) <span class="dot-required">*</span></label>
                                        <input class="form-control" name="txtCanNang" placeholder="Vui lòng nhập cân nặng của bé" value="<?php if(isset($detail_be->cannang)) {echo $detail_be->cannang;} ?>">
                                        <?php
                                        if(isset($errors) && in_array('txtCanNang',$errors))
                                        {
                                            echo "<p class='text-danger'>Cân nặng bé không hợp lệ</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3" style="margin-right: -25px">
                                    <div>
                                        <div id="targetLayer" style="<?php if(isset($url_img) && !empty($url_img)) echo "background-image: url({$url_img})"?>">
                                            <button type="button"><span class="glyphicon glyphicon-picture"></span></button>
                                            <input type="file" id="hinhBe" name="hinhBe" onChange="showPreview(this);">
                                        </div>
                                        <?php if(isset($temp_file) && !empty($temp_file)) echo '<script>loadPhoto(sessionStorage.getItem("have-photo"));</script>'?>
                                        <input type="hidden" name='temp-image-input' value="<?php if(isset($temp_file) && !empty($temp_file)) echo $temp_file; else echo '';?>"/>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Địa chỉ <span class="dot-required">*</span></label>
                                        <input class="form-control" name="txtDiaChi" placeholder="Vui lòng nhập địa chỉ" value="<?php if(isset($detail_be->diachi)) {echo $detail_be->diachi;} ?>">
                                        <?php
                                        if(isset($errors) && in_array('txtDiaChi',$errors))
                                        {
                                            echo "<p class='text-danger'>Bạn chưa nhập địa chỉ</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Tình trạng sức khoẻ</label>
                                        <textarea rows="3" class="form-control" name="txtSucKhoe" placeholder="Vui lòng nhập tình trạng sức khoẻ"><?php if(isset($detail_be->tinhtrangsuckhoe)) {echo $detail_be->tinhtrangsuckhoe;}?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Bệnh bẩm sinh(nếu có)</label>
                                        <textarea rows="3" class="form-control" name="txtBenhBS" placeholder="Vui lòng nhập bệnh bẩm sinh"><?php if(isset($detail_be->benhbamsinh)) {echo $detail_be->benhbamsinh;} ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--  ====== THÔNG TIN CHA MẸ ===== -->
                        <div class="row parent-zone">
                            <div class="title-absolute"><span>Thông tin phụ huynh</span></div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Tên cha</label>
                                    <input class="form-control" name="txtTenCha" placeholder="Vui lòng nhập tên cha" value="<?php if(isset($detail_be->tencha)) {echo $detail_be->tencha;} ?>">
                                    <?php
                                    if(isset($errors) && in_array('txtTenCha',$errors))
                                    {
                                        echo "<p class='text-danger'>Bạn chưa nhập tên cha</p>";
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>Số điện thoại cha</label>
                                    <input class="form-control" name="txtSDTCha" placeholder="Vui lòng nhập số điện thoại cha" value="<?php if(isset($detail_be->sdtcha)) {echo $detail_be->sdtcha;} ?>">
                                    <?php
                                    if(isset($errors) && in_array('txtSDTCha',$errors))
                                    {
                                        echo "<p class='text-danger'>Vui lòng nhập số điện thoại cha</p>";
                                    }
                                    if(isset($errors) && in_array('txtSDTCha2',$errors))
                                    {
                                        echo "<p class='text-danger'>Số điện thoại hợp lệ có 10 số</p>";
                                    }
                                    ?>
                                </div>
                                <?php
                                if(isset($errors) && in_array('parents',$errors))
                                {
                                    echo "<div class='footer-detail text-danger' style='float:left;font-size:13px;'><span>Bắt buộc phải nhập cha hoặc mẹ</span></div>";
                                }?>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Tên mẹ</label>
                                    <input class="form-control" name="txtTenMe" maxlength="10" placeholder="Vui lòng nhập tên mẹ" value="<?php if(isset($detail_be->tenme)) {echo $detail_be->tenme;} ?>">
                                    <?php
                                    if(isset($errors) && in_array('txtTenMe',$errors))
                                    {
                                        echo "<p class='text-danger'>Bạn chưa nhập tên mẹ</p>";
                                    }
                                    ?>
                                </div>
                                <div class="form-group" style="margin-bottom: 7px;">
                                    <label>Số điện thoại mẹ</label>
                                    <input class="form-control" name="txtSDTMe" maxlength="10" placeholder="Vui lòng nhập số điện thoại mẹ" value="<?php if(isset($detail_be->sdtme)) {echo $detail_be->sdtme;} ?>">
                                    <?php
                                    if(isset($errors) && in_array('txtSDTMe',$errors))
                                    {
                                        echo "<p class='text-danger'>Vui lòng nhập số điện thoại mẹ</p>";
                                    }
                                    if(isset($errors) && in_array('txtSDTMe2',$errors))
                                    {
                                        echo "<p class='text-danger'>Số điện thoại hợp lệ có 10 số</p>";
                                    }
                                    ?>
                                </div>
                                <div class="footer-detail"><span>* Cho phép chỉ nhập cha hoặc mẹ</span></div>
                            </div>
                        </div>
                        <!--  ====== END THÔNG TIN CHA MẸ ===== -->

                        <!-- =========================== THÔNG TIN LOP HOC ===============================-->
                        <div class="row parent-zone">
                            <div class="title-absolute"><span>Thông Lớp học</span></div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Niên khóa</label>
                                    <select name="nien_khoa" id="" class="form-control">
                                        <option value="0">Chọn Niên khóa</option>
                                        <?php foreach ($data_nien_khoa as $item):?>
                                            <option <?php if($detail_be->nien_khoa_id == $item['id']) echo "selected"?> value="<?php echo $item['id']?>"><?php echo $item['ten_nien_khoa']?></option>
                                        <?php endforeach;?>
                                    </select>

                                    <?php
                                    if(isset($errors) && in_array('nien_khoa',$errors))
                                    {
                                        echo "<p class='text-danger'>Bạn chưa chọn niên khóa</p>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Lớp học</label>
                                    <select name="lop_hoc" id="" class="form-control">
                                        <option value="0">Chọn lớp học</option>
                                        <?php foreach ($data_lop_hoc as $item):?>
                                            <option <?php if($detail_be->lop_hoc_chi_tiet_id == $item['id']) echo "selected"?> value="<?php echo $item['id']?>"><?php echo $item['mo_ta']?></option>
                                        <?php endforeach;?>
                                    </select>

                                    <?php
                                    if(isset($errors) && in_array('lop_hoc',$errors))
                                    {
                                        echo "<p class='text-danger'>Bạn chưa chọn niên khóa</p>";
                                    }
                                    ?>

                                    <script>
                                        var id_lop_hoc = <?php echo $detail_be->lop_hoc_chi_tiet_id;?>
                                    </script>
                                </div>
                            </div>
                        </div>
                        <!-- =========================== END THÔNG TIN LOP HOC ===========================-->

                        <div class="row card-footer" style="padding-left: 0">
                            <button name="btn-submit-be" type="submit" class="btn btn-info" style="margin-right: 5px;">Cập nhật Thông Tin</button>
                            <a href="admin-be.php" class="btn btn-warning">Quay về</a>
                        </div>
                    </form>
                </div>
                <!-- End thêm loại tin -->
            </div>
        </div>
    </div>
    <!-- End Default Light Table -->
</div>
<!-- End page content-->

<script>
    $( document ).ready( function () {
        $( '#heading5 .panel-heading' ).attr( 'aria-expanded', 'true' );
        $( '#collapse5' ).addClass( 'show' );
        $( '#collapse5 .list-group a:nth-child(1)' ).addClass( 'cus-active' );


        $('select[name="nien_khoa"]').change(function () {
            get_data_lop_hoc_theo_nien_khoa($(this).val());
        });

        function get_data_lop_hoc_theo_nien_khoa(id_nien_khoa, id_lop_hoc) {
            $.ajax({
                type: "POST",
                url: 'admin-be-xuly.php',
                data: { 'get_data_lop_hoc' : 1, 'id_nien_khoa': id_nien_khoa },
                success : function (result){
                    var data = JSON.parse(result);
                    var str = "";
                    if(data.length > 0) {
                        data.forEach(function (item) {
                            if(item.id == id_lop_hoc) {
                                str += '<option selected value="'+ item.id +'">'+ item.mo_ta +'</option>';
                            }
                            else str += '<option value="'+ item.id +'">'+ item.mo_ta +'</option>';
                        });
                        $('select[name="lop_hoc"]').html(str);
                    }

                }
            });
            $('select[name="lop_hoc"]').removeAttr('disabled');
        }

        get_data_lop_hoc_theo_nien_khoa($('select[name="nien_khoa"]').val(), id_lop_hoc);
    } );

    function showPreview( objFileInput ) {
        var filename = objFileInput.value.split('.').pop().toLowerCase();
        var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        isValid = fileTypes.indexOf(filename) > -1;
        if (isValid) {
            //if ( objFileInput.files[ 0 ] ) {
            var fileReader = new FileReader();
            fileReader.onload = function ( e ) {
                $( "#targetLayer" ).addClass( 'have-photo' );
                $( "#targetLayer" ).css( 'background-image', 'url("' + e.target.result + '")' );
                sessionStorage.setItem('have-photo',e.target.result);
                $( '#targetLayer .glyphicon' ).fadeOut();
                $('input[name="temp-image-input"]').val('');
            }
            fileReader.readAsDataURL( objFileInput.files[ 0 ] );
        }
    };
    function loadPhoto(url){
        $( "#targetLayer" ).addClass( 'have-photo' );
        $( "#targetLayer" ).css( 'background-image', 'url("' + url + '")' );
        $( '#targetLayer .glyphicon' ).fadeOut();
    }
</script>


<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer