<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<!-- End header-->
<script>
    $('#heading1 .panel-heading').attr('aria-expanded','true');
    $('#collapse1').addClass('show');
    $('#collapse1 .list-group a:nth-child(1)').addClass('cus-active');
</script>

<style>
    span.select2-container { width: 100% !important; }
    .error-message { color: #ff392a; }

    .custom-select2-selection {
        height: 35px !important;
        padding-top: 2px !important;
    }

    .select2-container--default .select2-selection--single {
        height: 35px !important;
        padding-top: 2px !important;
        font-size: .8125rem;
        color: #495057;
    }

    .select2-container--default .select2-selection--single { border: 1px solid #ddd; }
</style>

<?php

// lấy danh sách lớp học
$results_lop_hoc = mysqli_query($dbc,"SELECT * FROM lophoc_chitiet");

// lấy danh sách niên khóa
$results_nien_khoa = mysqli_query($dbc,"SELECT * FROM nienkhoa");

// Lấy danh sách nhân viên
$results_nhan_vien_them_moi = mysqli_query($dbc,"SELECT id, ho_ten FROM nhanvien WHERE id NOT IN (SELECT nhan_vien_id FROM lophoc_nhanvien)");
$results_nhan_vien_cap_nhat = mysqli_query($dbc,"SELECT id, ho_ten FROM nhanvien");


$query_load_hoc_phi = "SELECT be.ten, be.id, hoc_phi.so_tien, hoc_phi.ngay_thanh_toan, lophoc_chitiet.id as 'lop_hoc_chi_tiet_id', hoc_phi.nhan_vien_id, lophoc_chitiet.mo_ta, nienkhoa.ten_nien_khoa FROM be 
                        INNER JOIN lophoc_be ON be.id = lophoc_be.be_id
                        INNER JOIN lophoc_chitiet ON lophoc_be.lop_hoc_chi_tiet_id = lophoc_chitiet.id
                        INNER JOIN nienkhoa ON lophoc_chitiet.nien_khoa_id = nienkhoa.id
                        LEFT JOIN hoc_phi ON be.id = hoc_phi.be_id ";

$nien_khoa = isset($_GET['nien_khoa']) ? (int)$_GET['nien_khoa'] : 0;
$lop_hoc = isset($_GET['lop_hoc']) ? (int)$_GET['lop_hoc'] : 0;
$be = isset($_GET['be']) ? (int)$_GET['be'] : 0;

// Lấy danh sách bé
$results_be = mysqli_query($dbc, "SELECT * FROM be WHERE id IN (SELECT be_id FROM lophoc_be WHERE lophoc_be.lop_hoc_chi_tiet_id = {$lop_hoc})");

if ($nien_khoa > 0 && $lop_hoc > 0) {
    $query_load_hoc_phi .= " WHERE lophoc_chitiet.nien_khoa_id = {$nien_khoa} AND lophoc_chitiet.id = {$lop_hoc} ";

    if($be > 0) $query_load_hoc_phi .= " AND be.id = {$be}";
}

$query_load_hoc_phi .= " AND be.trangthai = 1";
$data_hoc_phi = mysqli_query($dbc, $query_load_hoc_phi);
$count_data = (int)count(mysqli_fetch_all($data_hoc_phi)); // đếm số lượng record kết quả
?>

<!-- Page content-->
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Quản lý học phí</h3>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <?php
                if(isset($_GET['them']))
                {
                    ?>
                    <!-- Thêm loại tin -->
                    <?php
                if(isset($_POST['xacnhanthem']))
                {
                    $errors = array();
                    if(empty($_POST['txtTenTheLoai']))
                    {
                        $errors[] = 'txtTenTheLoai';
                    }
                    else
                    {
                        $name = $_POST['txtTenTheLoai'];
                    }
                if(empty($errors))
                {
                    if($_POST['theloaicha']==0)
                    {
                        $theloaicha = 0;
                    }
                    else
                    {
                        $theloaicha = $_POST['theloaicha'];
                    }
                    $query = "INSERT INTO loaitin(ten,the_loai_cha) VALUES('{$name}',$theloaicha)";
                    $results = mysqli_query($dbc, $query);
                    //Kiem tra them moi thanh cong hay chua
                if(mysqli_affected_rows($dbc)==1)
                {
                    ?>
                    <script>
                        alert("thêm thành công");
                        window.location="admin-loaitin.php";
                    </script>
                <?php
                }
                else
                {
                    echo "<script>";
                    echo 'alert("Thêm không thành công")';
                    echo "</script>";
                }
                }
                }
                ?>
                <?php
                if(isset($message))
                {
                    echo $message;
                }
                ?>
                    <div class="card-header border-bottom">
                        <h5 class="text-info">Thêm lớp học</h5>
                        <form action="" method="post">
                            <div class="form-group">
                                <label style="display:block">Thể Loại</label>
                                <select class="form-control" name="theloaicha">
                                    <option value="0">Vui Lòng Chọn Thể Loại</option>
                                    <?php selectCtrl(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tên Thể Loại</label>
                                <input class="form-control" name="txtTenTheLoai" placeholder="Vui lòng nhập tên thể loại" value = "<?php if(isset($_POST['txtTenTheLoai'])) {echo $_POST['txtTenTheLoai'];} ?>">
                                <?php
                                if(isset($errors) && in_array('txtTenTheLoai',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên thể loại</p>";
                                }
                                ?>
                            </div>
                            <button type="submit" name="xacnhanthem" class="btn btn-info">Thêm Thông Tin</button>
                        </form>
                    </div>
                    <?php
                }
                ?>
                <!-- End thêm loại tin -->

                <!-- Danh sach hoc phi -->
                <div class="card-header border-bottom">
                    <h5 class="text-info">Danh sách học phí</h5>
                    <div class="row">
                        <form id="bo-loc-hoc-phi" action="" method="get" class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="">Danh sách niên khóa</label>
                                    <select name="nien_khoa" id="" class="form-control">
<!--                                        <option value="0">Chọn Niên khóa</option>-->
                                        <?php foreach ($results_nien_khoa as $item):?>
                                            <option <?php if(isset($_GET['nien_khoa']) && $_GET['nien_khoa'] == $item['id']) echo "selected";?> value="<?php echo $item['id']?>"><?php echo $item['ten_nien_khoa']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Danh sách lớp học</label>
                                    <select name="lop_hoc" id="" class="form-control">
                                        <option value="all">Chọn lớp học</option>
                                        <?php foreach ($results_lop_hoc as $item):?>
                                            <option <?php if(isset($_GET['lop_hoc']) && $_GET['lop_hoc'] == $item['id']) echo "selected";?> value="<?php echo $item['id']?>"><?php echo $item['mo_ta']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="">Danh sách bé</label>
                                    <select name="be" id="" class="form-control select-be">
                                        <?php if(count(mysqli_fetch_all($results_be)) > 0): ?>
                                            <option value="all">Tất cả bé</option>
                                            <?php foreach ($results_be as $item):?>
                                                <option <?php if(isset($_GET['be']) && $_GET['be'] == $item['id']) echo "selected";?> value="<?php echo $item['id']?>"><?php echo $item['ten']?></option>
                                            <?php endforeach;?>
                                        <?php else: ?>
                                            <option value="all">Không có bé nào trong lớp này</option>
                                        <?php endif;?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="" style="color: transparent;">Lọc danh sách</label>
                                    <button class="btn btn-outline-success w-100">Lọc danh sách</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Thanh toán học phí</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input id="id_chi_tiet_lop_hoc" type="hidden" value="">
                                    <div class="form-group">
                                        <label style="display:block">Tên lớp <span class="dot-required">*</span></label>
                                        <input name="ten_lop" onkeyup="check_ten_lop(this)" maxlength="255" type="text" class="form-control">
                                        <small style="display: none" class="error-message">Tên lớp này đã tồn tại</small>
                                        <small style="display: none" class="error-message e-1">Tên lớp có độ từ 5-255 ký tự</small>
                                    </div>
                                    <div class="form-group">
                                        <label style="display:block">Loại lớp <span class="dot-required">*</span></label>
                                        <select name="select_lop_hoc" id="" class="form-control">
                                            <!--                                            <option value="0">Chọn loại lớp học</option>-->
                                            <?php foreach ($results_lop_hoc as $item):?>
                                                <option value="<?php echo $item['id']?>"><?php echo $item['ten_lop']?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <small style="display: none" class="error-message e-2"><i>Vui lòng loại lớp học</i></small>
                                    </div>
                                    <div class="form-group">
                                        <label style="display:block">Niên khóa <span class="dot-required">*</span></label>
                                        <select name="select_nien_khoa" id="" class="form-control">
                                            <!--                                            <option value="0">Chọn Niên khóa</option>-->
                                            <?php foreach ($results_nien_khoa as $item):?>
                                                <option value="<?php echo $item['id']?>"><?php echo $item['ten_nien_khoa']?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <small style="display: none" class="error-message e-3"><i>Vui lòng niên khóa</i></small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-save" onclick="submit_lop_hoc()" type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body p-0 pb-3 text-center">
                    <table class="table mb-0">

                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0" style="width: 100px">STT</th>
                                <th scope="col" class="border-0 text-left">Họ và Tên Bé</th>
                                <th scope="col" class="border-0 text-left" style="width: 180px">Lớp</th>
                                <th scope="col" class="border-0" style="width: 120px">Niên khóa</th>
                                <th scope="col" class="border-0 text-right" style="width: 120px">Thành tiền</th>
                                <th scope="col" class="border-0" style="width: 150px">Ngày thanh toán</th>
                                <th scope="col" class="border-0" style="width: 120px">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                //đặt số bản ghi cần hiện thị
                                $limit = 10;
                                //Xác định vị trí bắt đầu
                                if (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                                    $start = $_GET['s'];
                                } else {
                                    $start = 0;
                                }
                                if (isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                                    $per_page = $_GET['p'];
                                }
                                else {
                                    //Nếu p không có, thì sẽ truy vấn CSDL để tìm xem có bao nhiêu page
//                                    $query_pg = "SELECT COUNT(id) FROM lophoc_chitiet ";
//                                    $results_pg = mysqli_query($dbc, $query_pg);
//                                    list($record) = mysqli_fetch_array($results_pg, MYSQLI_NUM);
                                    $record = count(mysqli_fetch_all($data_hoc_phi));
                                    //Tìm số trang bằng cách chia số dữ liệu cho số limit
                                    if ($record > $limit) {
                                        $per_page = ceil($record / $limit);
                                    } else {
                                        $per_page = 1;
                                    }
                                }
                            ?>

                            <?php if ($count_data > 0): ?>
                                <?php foreach ($data_hoc_phi as $key => $item) :?>
                                    <tr>
                                        <td><?php echo ($key + 1) ?></td>
                                        <td class="text-left"><?php echo $item['ten'] ?></td>
                                        <td class="text-left"><?php echo $item['mo_ta']?></td>
                                        <td><?php echo $item['ten_nien_khoa']?></td>
                                        <td class="text-right"><?php echo number_format($item['so_tien'])?></td>
                                        <td><?php if((int)$item['so_tien'] > 1000) echo date_format(date_create($item['ngay_thanh_toan']), 'd/m/Y'); else echo "Chưa thanh toán" ?></td>
                                        <td>
                                        <span style="cursor: pointer;" onclick="thanh_toan(<?php echo $item['id'];?>, <?php echo $item['lop_hoc_chi_tiet_id']?>, <?php echo $item['so_tien']?>)">
                                            <?php
                                            if((int)$item['so_tien'] > 1000) echo "<i style='color: #1cdf81' class='material-icons action-icon' title='Đã thanh toán'>check_box</i>";
                                            else echo "<i title='click để thanh toán' class='material-icons action-icon dot-required'>check_box_outline_blank</i>";
                                            ?>
                                        </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center dot-required">Không tìm thấy kết quả</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php
                        echo "<nav aria-label='Page navigation example'>";
                        echo "<ul class='pagination justify-content-center'>";
                        if($per_page > 1)
                        {
                            $current_page=($start/$limit) + 1;
                            //Nếu không phải là trang đầu thì hiện thị trang trước
                            if($current_page !=1)
                            {
                                echo "<li class='page-item' class='float-left'><a class='page-link' href='admin-lop.php?s=".($start - $limit)."&p={$per_page}'>Trở về</a></li>";
                            }
                            //hiện thị những phần còn lại của trang
                            for ($i=1; $i <= $per_page ; $i++)
                            {
                                if($i != $current_page)
                                {
                                    echo "<li class='page-item'><a class='page-link' href=admin-lop.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
                                }
                                else
                                {
                                    echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
                                }
                            }
                            //Nếu không phải trang cuối thì hiện thị nút next
                            if($current_page != $per_page)
                            {
                                echo "<li class='page-item' ><a class='page-link' href='admin-lop.php?s=".($start + $limit)."&p={$per_page}'>Tiếp</a></li>";
                            }
                        }
                        echo "</ul>";
                        echo "</nav>"
                    ?>
                </div>
                <!-- End danh sách loại tin -->
            </div>
        </div>
    </div>
    <!-- End Default Light Table -->

    <input type="hidden" id="flag_insert_update" value="1">

</div>
<!-- End page content-->

<script>
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };
    var lop_hoc_chi_tiet_id = getUrlParameter('lop_hoc');
    var be_id = getUrlParameter('be');


    $(document).ready(function () {
        // document.location = document.location.href + '?id=38';

        $('#btn-show-add').click(function () {
            $('#flag_insert_update').val(1); //bật cờ báo là đang ở form thêm mới lớp học
            // gán gia trị text về null để thêm mới
            $('#id_chi_tiet_lop_hoc').val("");
            $('input[name="ten_lop"]').val("");
            $('select[name="select_nien_khoa"]').val("");
            $('select[name="select_lop_hoc"]').val("");

            $('.select-nhannien-add').next(".select2-container").show();
            $('.select-nhannien-edit').next(".select2-container").hide();

            $('.select-nhannien-add').val("").trigger('change');
        })

        $('select[name="nien_khoa"]').change(function () {
            get_data_lop_hoc_theo_nien_khoa($(this).val());
            setTimeout(function () {
                $('select[name="lop_hoc"]').change();
            },500)
        });

        // lấy danh sách lớp theo niên khóa
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
                            if (id_lop_hoc == item.id){
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

        var nien_khoa_id = getUrlParameter('nien_khoa');
        lop_hoc_chi_tiet_id = getUrlParameter('lop_hoc');

        if(typeof nien_khoa_id == "undefined" || typeof lop_hoc_chi_tiet_id == "undefined"){
            get_data_lop_hoc_theo_nien_khoa($('select[name="nien_khoa"]').val())
            setTimeout(function () {
                $('#bo-loc-hoc-phi').submit();
            },500);
        }

        $('select[name="lop_hoc"]').change(function () {
            get_data_be_theo_lop($(this).val());
        });

        get_data_lop_hoc_theo_nien_khoa($('select[name="nien_khoa"]').val(), lop_hoc_chi_tiet_id);
    });



    // ajax load danh sach be theo lop
    function get_data_be_theo_lop(lop_id, id_be) {
        $.ajax({
            type: "POST",
            url: 'admin-xuly-lop.php',
            data: { 'get_list_be_theo_lop_hoc': 1, 'lop_hoc_id': lop_id },
            success: function (result) {
                var data = JSON.parse(result);
                var str = '<option value="all">Tất cả bé</option>';
                if(data.length > 0) {
                    data.forEach(function(item) {
                        if(id_be == item.id) str += '<option selected value="'+ item.id +'">'+ item.mo_ta +'</option>';
                        else str += '<option value="'+ item.id +'">'+ item.mo_ta +'</option>';
                    })
                }
                else str = '<option value="all">Không có bé nào trong lớp này</option>';
                $('select[name="be"]').html(str);
            }
        });
    }

    function thanh_toan(be_id, lop_hoc_chi_tiet_id, tien_hoc_phi) {
        console.log(be_id)
        console.log(lop_hoc_chi_tiet_id)
        if(typeof tien_hoc_phi == "undefined") {
            $('#myModal').modal('show');
        }
    }
</script>

<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer