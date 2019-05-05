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
</style>

<?php
    // lấy danh sách lớp học
    $results_lop_hoc = mysqli_query($dbc,"SELECT * FROM lophoc");

    // lấy danh sách niên khóa
    $results_nien_khoa = mysqli_query($dbc,"SELECT * FROM nienkhoa");

    // Lấy danh sách nhân viên
    $results_nhan_vien = mysqli_query($dbc,"SELECT id, ho_ten FROM nhanvien");
?>

<!-- Page content-->
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Lớp học</h3>
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
                <!-- Danh sach loại tin -->
                <div class="card-header border-bottom">
                    <form action="admin-loaitin.php" method="get">
                        <h5 class="text-info">Danh sách lớp học</h5>
                        <button id="btn-show-add" type="button" name="them" data-toggle="modal" data-target="#myModal" class="btn btn-info">Thêm mới lớp học</button>
                    </form>

                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Thông tin lớp học</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input id="id_chi_tiet_lop_hoc" type="hidden" value="">
                                    <div class="form-group">
                                        <label style="display:block">Tên lớp</label>
                                        <input name="ten_lop" onkeyup="check_ten_lop(this)" type="text" class="form-control">
                                        <small style="display: none" class="erro-ten-lop">Tên lớp này đã tồn tại</small>
                                    </div>
                                    <div class="form-group">
                                        <label style="display:block">Loại lớp</label>
                                        <select name="select_lop_hoc" id="" class="form-control">
                                            <option value="">Chọn lớp học</option>
                                            <?php foreach ($results_lop_hoc as $item):?>
                                                <option value="<?php echo $item['id']?>"><?php echo $item['ten_lop']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="display:block">Niên khóa</label>
                                        <select name="select_nien_khoa" id="" class="form-control">
                                            <option value="">Chọn Niên khóa</option>
                                            <?php foreach ($results_nien_khoa as $item):?>
                                                <option value="<?php echo $item['id']?>"><?php echo $item['ten_nien_khoa']?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="display:block">Nhân viên</label>
                                        <select multiple class="form-control select-nhannien w-100" name="nhanvien[]" onChange="">
                                            <?php foreach ($results_nhan_vien as $item): ?>
                                                <option value="<?php echo $item['id'] ?>">
                                                    <?php echo $item['ho_ten'] ?>
                                                </option>
                                            <?php endforeach;?>
                                        </select>
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
                            <th scope="col" class="border-0 text-left">Tên lớp</th>
                            <th scope="col" class="border-0" style="width: 120px">Niên khóa</th>
                            <th scope="col" class="border-0" style="width: 120px">SL NV</th>
                            <th scope="col" class="border-0" style="width: 120px">SL bé</th>
                            <th scope="col" class="border-0" style="width: 120px">Thao tác</th>
                        </tr>
                        </thead>
                        <?php
                        //đặt số bản ghi cần hiện thị
                        $limit=10;
                        //Xác định vị trí bắt đầu
                        if(isset($_GET['s']) && filter_var($_GET['s'],FILTER_VALIDATE_INT,array('min_range'=>1)))
                        {
                            $start=$_GET['s'];
                        }
                        else
                        {
                            $start=0;
                        }
                        if(isset($_GET['p']) && filter_var($_GET['p'],FILTER_VALIDATE_INT,array('min_range'=>1)))
                        {
                            $per_page=$_GET['p'];
                        }
                        else
                        {
                            //Nếu p không có, thì sẽ truy vấn CSDL để tìm xem có bao nhiêu page
                            $query_pg="SELECT COUNT(id) FROM lophoc_chitiet";
                            $results_pg=mysqli_query($dbc,$query_pg);
                            list($record)=mysqli_fetch_array($results_pg,MYSQLI_NUM);
                            //Tìm số trang bằng cách chia số dữ liệu cho số limit
                            if($record > $limit)
                            {
                                $per_page=ceil($record/$limit);
                            }
                            else
                            {
                                $per_page=1;
                            }
                        }
                        $query = "SELECT l.id,l.mo_ta, n.ten_nien_khoa, 
                                    (SELECT COUNT(id) FROM lophoc_be WHERE l.id = lophoc_be.lop_hoc_chi_tiet_id)	AS sl_be,
                                    (SELECT COUNT(id) FROM lophoc_nhanvien WHERE l.id = lophoc_nhanvien.lop_hoc_chi_tiet_id) AS sl_nhan_vien
                                FROM
                                    lophoc_chitiet AS l INNER JOIN nienkhoa AS n ON l.nien_khoa_id = n.id ORDER BY id ASC 
                                    LIMIT {$start},{$limit}";

                        $results = mysqli_query($dbc, $query);
                        foreach ($results as $key => $item)
                        {
                            ?>
                            <tbody>
                            <tr>
                                <td><?php echo ($key + 1) ?></td>
                                <td class="text-left"><?php echo $item['mo_ta'] ?></td>
                                <td><?php echo $item['ten_nien_khoa']?></td>
                                <td><?php echo $item['sl_nhan_vien']?></td>
                                <td><?php echo $item['sl_be']?></td>
                                <td>
                                    <a onclick="show_form_edit(<?php echo $item['id']?>)" style="cursor: pointer" title="Cập nhật lớp học">
                                        <i class="material-icons action-icon">edit</i>
                                    </a>
                                    <a onclick="delete_lop_hoc(<?php echo $item['id']?>)" style="cursor: pointer" title="Xóa lớp học"><i class="material-icons action-icon">delete_outline</i></a>
                                </td>
                            </tr>
                            </tbody>
                        <?php } ?>
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
    $( '.select-nhannien' ).select2( {
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
           $('.select-nhannien').val("").trigger('change');
       })
    });

    function check_nhan_vien_da_lam_o_lop_khac() {
        $.get( "admin-xuly-lop.php?ten_lop=" + "aaa" + "&check_lop=1", function( data ) {
        });
    }
    
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
        data = {
            'add': 1,
            'ten_lop': $('input[name="ten_lop"]').val(),
            'id_nien_khoa': $('select[name="select_nien_khoa"]').val(),
            'id_lop': $('select[name="select_lop_hoc"]').val(),
            'arr_nhan_vien': $('.select-nhannien').val()
        }

        $.ajax({
            type: "POST",
            url: 'admin-xuly-lop.php',
            data: data,
            success : function (result){
                if (result == "1") {
                    alert("Thêm lớp học thành công!");
                }
                else alert("Lỗi không thêm được lớp học");
                location.reload();
            }
        });
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
                    if (result == "1") alert("Lớp học vừa chọn đã được xóa!");
                    else alert("Lỗi không xóa được!");
                    location.reload();
                }
            });
        }
    }

    function show_form_edit(id) {
        $('#flag_insert_update').val(2); //bật cờ báo là đang ở form cập nhật lớp học
        // load thông tin của một lớp học
        data = {
            'load_info_item': 1,
            'id_chi_tiet_lop_hoc': id
        }
        $.ajax({
            type: "POST",
            url: 'admin-xuly-lop.php',
            data: data,
            success : function (result){
                item = JSON.parse(result);
                $('#id_chi_tiet_lop_hoc').val(item.id);
                $('input[name="ten_lop"]').val(item.mo_ta);
                $('select[name="select_nien_khoa"]').val(item.nien_khoa_id);
                $('select[name="select_lop_hoc"]').val(item.lop_hoc_id);
                $('.select-nhannien').val(item.nv).trigger('change');
            }
        });
        $('#myModal').modal().show();
    }

    function edit_lop_hoc(id) {
        data = {
            edit: 1,
            ten_lop: $('input[name="ten_lop"]').val(),
            id_nien_khoa: $('select[name="select_nien_khoa"]').val(),
            id_lop: $('select[name="select_lop_hoc"]').val(),
            id_chi_tiet_lop: $('#id_chi_tiet_lop_hoc').val(),
            arr_nhan_vien: $('.select-nhannien').val()
        };

        $.ajax({
            type: "POST",
            url: 'admin-xuly-lop.php',
            data: data,
            success : function (result){
                if (result == "1") {
                    alert("Cập nhật thông tin lớp học thành công!");
                }
                else alert("Lỗi không cập nhật được lớp học");
                location.reload();
            }
        });
    }

    function submit_lop_hoc() {
        type = $('#flag_insert_update').val();
        if(type == 1) {
            insert_lop_hoc();
        }
        else{
            id_chi_tiet_lop_hoc = $('#id_chi_tiet_lop').val();
            edit_lop_hoc(id_chi_tiet_lop_hoc);
        }
    }
</script>

<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer