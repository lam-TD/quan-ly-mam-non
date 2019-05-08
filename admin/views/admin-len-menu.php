<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

<!-- End header-->
<script>
    $('#heading4 .panel-heading').attr('aria-expanded','true');
    $('#collapse4').addClass('show');
    $('#collapse4 .list-group a:nth-child(1)').addClass('cus-active');

    function add_them_row(tuan_trong_thang) {
        var row = '<tr class="tr-con tr-week-'+ tuan_trong_thang +'"><td><input type="text" class="form-control form-control-sm buoi"></td>\n' +
            '                                                    <td><input type="text" class="form-control form-control-sm thu2"></td>\n' +
            '                                                    <td><input type="text" class="form-control form-control-sm thu3"></td>\n' +
            '                                                    <td><input type="text" class="form-control form-control-sm thu4"></td>\n' +
            '                                                    <td><input type="text" class="form-control form-control-sm thu5"></td>\n' +
            '                                                    <td><input type="text" class="form-control form-control-sm thu6"></td>\n' +
            '                                                    <td><input type="text" class="form-control form-control-sm thu7"></td>\n' +
            '                                                    <td><button onclick="remove_row(this)" class="btn btn-sm btn-danger w-100"><i class="glyphicon glyphicon-remove"></i></button></td></tr>';
        $('.tboy-week-' + tuan_trong_thang).append(row);
    }

    function remove_row(item) {
        $(item).parent().parent().remove();
    }
</script>

<style>
    span.select2-container { width: 100% !important; }
    .error-message { color: #ff392a; }
    .modal { z-index: 99999999; }
    .modal-lg { min-width: 1000px !important; }
</style>

<?php
// lấy danh sách lớp học
$results_lop_hoc = mysqli_query($dbc,"SELECT * FROM lophoc");

// lấy danh sách niên khóa
$results_nien_khoa = mysqli_query($dbc,"SELECT * FROM nienkhoa ORDER BY nam_ket_thuc DESC");

// Lấy danh sách nhân viên
$results_nhan_vien_them_moi = mysqli_query($dbc,"SELECT id, ho_ten FROM nhanvien WHERE id NOT IN (SELECT nhan_vien_id FROM lophoc_nhanvien)");
$results_nhan_vien_cap_nhat = mysqli_query($dbc,"SELECT id, ho_ten FROM nhanvien");

?>

<!-- Page content-->
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Quản lý Menu</h3>
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
                        <h5 class="text-info">Lên món</h5>
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
                <!-- Danh sach loại tin -->
                <div class="card-header border-bottom">
                    <form action="admin-loaitin.php" method="get" class="row">
                        <div class="col-md-12">
                            <h5 class="text-info">Danh sách Menu</h5>
                        </div>
                        <div class="col-md-2"><button id="btn-show-add" type="button" name="them" data-toggle="modal" data-target="#myModal" class="btn btn-info w-100">Thêm mới Menu</button></div>
<!--                        <div class="col-md-1"><button id="btn-show-add-nien-khoa" type="button" name="them" data-toggle="modal" data-target="#Modal_NIEN_KHOA" class="btn btn-success">Thêm mới niên khóa</button></div>-->
                        <div class="col-md-6"></div>
                        <div class="form-group col-md-2">
                            <input name="date_start" onkeyup="check_ten_lop(this)" maxlength="255" type="text" class="form-control date-start">
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    $('.date-start').datepicker({
                                        format: "mm/yyyy",
                                        startView: "months",
                                        minViewMode: "months",
                                        autoclose: true
                                    }).on("change", function () {

                                    });
                                });
                            </script>
                        </div>

                        <div class="col-md-2">
                            <select name="" id="" class="form-control">
                                <option value="0">Trong tháng</option>
                                <option value="1">Tuần 1</option>
                                <option value="2">Tuần 2</option>
                                <option value="3">Tuần 3</option>
                                <option value="4">Tuần 4</option>
                            </select>
                        </div>
                    </form>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Thông tin Menu</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input id="id_chi_tiet_lop_hoc" type="hidden" value="">
                                    <div class="form-group">
                                        <label for="">Tháng <span class="dot-required">*</span></label>
                                        <input name="date_menu" maxlength="255" type="text" class="form-control date-menu">
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('.date-menu').datepicker({
                                                    format: "mm/yyyy",
                                                    startView: "months",
                                                    minViewMode: "months",
                                                    autoclose: true
                                                }).on("change", function () {

                                                });
                                            });
                                        </script>
                                    </div>

                                    <div class="panel panel-success">
                                        <div id="week-1" class="panel-heading">Tuần 1</div>
                                        <div class="panel-body">
                                            <table id="tuan-1" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Buổi</th>
                                                    <th>Thứ 2</th>
                                                    <th>Thứ 3</th>
                                                    <th>Thứ 4</th>
                                                    <th>Thứ 5</th>
                                                    <th>Thứ 6</th>
                                                    <th>Thứ 7</th>
                                                    <th>
                                                        <button onclick="add_them_row(1)" class="btn btn-sm btn-info w-100"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="tboy-week-1">

                                                <tr class="tr-week-1">
                                                    <td><input type="text" class="form-control form-control-sm buoi"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu2"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu3"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu4"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu5"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu6"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu7"></td>
                                                    <td><button onclick="remove_row(this)" class="btn btn-sm btn-danger w-100"><i class="glyphicon glyphicon-remove"></i></button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="panel panel-success">
                                        <div id="week-1" class="panel-heading">Tuần 2</div>
                                        <div class="panel-body">
                                            <table id="tuan-2" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Buổi</th>
                                                    <th>Thứ 2</th>
                                                    <th>Thứ 3</th>
                                                    <th>Thứ 4</th>
                                                    <th>Thứ 5</th>
                                                    <th>Thứ 6</th>
                                                    <th>Thứ 7</th>
                                                    <th>
                                                        <button onclick="add_them_row(2)" class="btn btn-sm btn-info w-100"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="tboy-week-2">

                                                <tr class="tr-week-2">
                                                    <td><input type="text" class="form-control form-control-sm buoi"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu2"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu3"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu4"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu5"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu6"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu7"></td>
                                                    <td><button onclick="remove_row(this)" class="btn btn-sm btn-danger w-100"><i class="glyphicon glyphicon-remove"></i></button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="panel panel-success">
                                        <div id="week-3" class="panel-heading">Tuần 3</div>
                                        <div class="panel-body">
                                            <table id="tuan-3" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Buổi</th>
                                                    <th>Thứ 2</th>
                                                    <th>Thứ 3</th>
                                                    <th>Thứ 4</th>
                                                    <th>Thứ 5</th>
                                                    <th>Thứ 6</th>
                                                    <th>Thứ 7</th>
                                                    <th>
                                                        <button onclick="add_them_row(3)" class="btn btn-sm btn-info w-100"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="tboy-week-3">

                                                <tr class="tr-week-3">
                                                    <td><input type="text" class="form-control form-control-sm buoi"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu2"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu3"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu4"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu5"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu6"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu7"></td>
                                                    <td><button onclick="remove_row(this)" class="btn btn-sm btn-danger w-100"><i class="glyphicon glyphicon-remove"></i></button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="panel panel-success">
                                        <div id="week-4" class="panel-heading">Tuần 4</div>
                                        <div class="panel-body">
                                            <table id="tuan-4" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Buổi</th>
                                                    <th>Thứ 2</th>
                                                    <th>Thứ 3</th>
                                                    <th>Thứ 4</th>
                                                    <th>Thứ 5</th>
                                                    <th>Thứ 6</th>
                                                    <th>Thứ 7</th>
                                                    <th>
                                                        <button onclick="add_them_row(4)" class="btn btn-sm btn-info w-100"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="tboy-week-4">

                                                <tr class="tr-week-4">
                                                    <td><input type="text" class="form-control form-control-sm buoi"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu2"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu3"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu4"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu5"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu6"></td>
                                                    <td><input type="text" class="form-control form-control-sm thu7"></td>
                                                    <td><button onclick="remove_row(this)" class="btn btn-sm btn-danger w-100"><i class="glyphicon glyphicon-remove"></i></button></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button id="btn-save" type="button" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-body p-0 pb-3 text-center">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse-a">Collapsible panel</a>
                                </h4>
                            </div>
                            <div id="collapse-a" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <table  class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Firstname</th>
                                            <th>Lastname</th>
                                            <th>Email</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>John</td>
                                            <td>Doe</td>
                                            <td>john@example.com</td>
                                        </tr>
                                        <tr>
                                            <td>Mary</td>
                                            <td>Moe</td>
                                            <td>mary@example.com</td>
                                        </tr>
                                        <tr>
                                            <td>July</td>
                                            <td>Dooley</td>
                                            <td>july@example.com</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Tuần 1</button>
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
    $( '.select-nhannien-add' ).select2( {
        placeholder: {
            id: '',
            text: 'Vui lòng chọn nhân viên'
        },
        maximumSelectionLength: 3
    } );

    $( '.select-nhannien-edit' ).select2( {
        placeholder: {
            id: '',
            text: 'Vui lòng chọn nhân viên'
        },
        maximumSelectionLength: 3
    } );

    $(document).ready(function () {
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

        $('#btn-save').click(function () {
            submit_menu();
        });

        function submit_menu() {
            var arr_cha = {};
            var arr1 = [];
            var arr2 = [];
            var arr3 = [];
            var arr4 = [];
            $('.tboy-week-1 tr').each(function (index) {
                var buoi = $(this).find('.buoi').val();
                var thu2 = $(this).find('.thu2').val();
                var thu3 = $(this).find('input.thu3').val();
                var thu4 = $(this).find('input.thu4').val();
                var thu5 = $(this).find('input.thu5').val();
                var thu6 = $(this).find('input.thu6').val();
                var thu7 = $(this).find('input.thu7').val();
                var item = {
                    buoi: buoi,
                    thu2: thu2,
                    thu3: thu3,
                    thu4: thu4,
                    thu5: thu5,
                    thu6: thu6,
                    thu7: thu7,
                }
                arr1.push(item);
            });

            $('.tboy-week-2 tr').each(function (index) {
                var buoi = $(this).find('.buoi').val();
                var thu2 = $(this).find('.thu2').val();
                var thu3 = $(this).find('.thu3').val();
                var thu4 = $(this).find('.thu4').val();
                var thu5 = $(this).find('.thu5').val();
                var thu6 = $(this).find('.thu6').val();
                var thu7 = $(this).find('.thu7').val();
                var item = {
                    buoi: buoi,
                    thu2: thu2,
                    thu3: thu3,
                    thu4: thu4,
                    thu5: thu5,
                    thu6: thu6,
                    thu7: thu7,
                }
                arr2.push(item);
            });

            $('.tboy-week-3 tr').each(function (index) {
                var buoi = $(this).find('.buoi').val();
                var thu2 = $(this).find('.thu2').val();
                var thu3 = $(this).find('.thu3').val();
                var thu4 = $(this).find('.thu4').val();
                var thu5 = $(this).find('.thu5').val();
                var thu6 = $(this).find('.thu6').val();
                var thu7 = $(this).find('.thu7').val();
                var item = {
                    buoi: buoi,
                    thu2: thu2,
                    thu3: thu3,
                    thu4: thu4,
                    thu5: thu5,
                    thu6: thu6,
                    thu7: thu7,
                }
                arr3.push(item);
            });

            $('.tboy-week-4 tr').each(function (index) {
                var buoi = $(this).find('.buoi').val();
                var thu2 = $(this).find('.thu2').val();
                var thu3 = $(this).find('.thu3').val();
                var thu4 = $(this).find('.thu4').val();
                var thu5 = $(this).find('.thu5').val();
                var thu6 = $(this).find('.thu6').val();
                var thu7 = $(this).find('.thu7').val();
                var item = {
                    buoi: buoi,
                    thu2: thu2,
                    thu3: thu3,
                    thu4: thu4,
                    thu5: thu5,
                    thu6: thu6,
                    thu7: thu7,
                }
                arr4.push(item);
            });


            arr_cha.week1 = arr1;
            arr_cha.week2 = arr2;
            arr_cha.week3 = arr3;
            arr_cha.week4 = arr4;
            console.log(arr_cha)

            $.ajax({
                type: "POST",
                url: 'admin-len-menu-xuly.php',
                data: { add: 1, data: arr_cha },
                success: function (result) {
                    console.log(result);
                    if(result == "1") alert("Thêm menu thành công");
                    else{
                        alert("Thêm menu thất bại");
                    }
                }
            });
        }
    });

    function check_ten_lop(item) {
        $.get( "admin-xuly-lop.php?ten_lop=" + $(item).val() + "&check_lop=1", function( data ) {
            if(data == "1"){
                $('.erro-ten-lop').css('display','block');
                $('#btn-save').attr('disabled','disabled');
            }
            else {
                $('.erro-ten-lop').css('display','none');
                $('#btn-save').removeAttr('disabled');
            }
        });
    }

    function insert_lop_hoc() {
        // kiểm tra dữ liệu
        if (validate_form() == -1) {
            return;
        } else {
            data = {
                'add': 1,
                'ten_lop': $('input[name="ten_lop"]').val(),
                'id_nien_khoa': $('select[name="select_nien_khoa"]').val(),
                'id_lop': $('select[name="select_lop_hoc"]').val(),
                'arr_nhan_vien': $('.select-nhannien-add').val()
            }

            $.ajax({
                type: "POST",
                url: 'admin-xuly-lop.php',
                data: data,
                success: function (result) {
                    if (result == "1") {
                        alert("Thêm lớp học thành công!");
                    } else alert("Lỗi không thêm được lớp học");
                    location.reload();
                }
            });
        }
    }

    function delete_lop_hoc(id) {
        if(confirm("Bạn có chắc chắn muốn xóa lớp học vừa chọn?")) {
            data = {
                'delete': 1,
                'id_chi_tiet_lop_hoc': id
            };
            $.ajax({
                type: "POST",
                url: 'admin-xuly-lop.php',
                data: data,
                success : function (result){
                    console.log(result);
                    if (result == "1") alert("Lớp học vừa chọn đã được xóa!");
                    else if(result == "-2") alert("Lớp học này đang có bé! vui lòng xóa thông tin bé trong lớp học này!");
                    else alert("Lỗi không xóa được!");
                    location.reload();
                }
            });
        }
    }


    function get_data() {
        console.log('aaaaa');
        $('.tboy-week-1').each(function (index) {
            console.log('aaa');
            console.log(this);
        })
    }

    function validate_form() {
        ten_lop = new String($('input[name="ten_lop"]').val());
        id_nien_khoa = parseInt($('select[name="select_nien_khoa"]').val());
        id_lop = parseInt($('select[name="select_lop_hoc"]').val());

        type = $('#flag_insert_update').val();
        if(type == 1) arr_nhan_vien = $('.select-nhannien-add').val();
        else arr_nhan_vien = $('.select-nhannien-edit').val();

        if(ten_lop.length < 5 || ten_lop.length > 255) { $('.e-1').show(); return -1; }
        else $('.e-1').hide();

        if(!id_lop) { $('.e-2').show(); return -1; }
        else $('.e-2').hide();

        if(!id_nien_khoa) { $('.e-3').show(); return -1; }
        else $('.e-3').hide();

        if(arr_nhan_vien.length < 2) { $('.e-4').show(); return -1; }
        else $('.e-4').hide();

        return 1;
    }


</script>

<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer