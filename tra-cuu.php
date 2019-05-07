<?php include "header.php" ?>

<!-- LOAD DỮ LIỆU -->
<?php
$data_lop_hoc = mysqli_query($dbc,"SELECT * FROM lophoc_chitiet");

// lấy danh sách niên khóa
$data_nien_khoa = mysqli_query($dbc,"SELECT * FROM nienkhoa ORDER BY id DESC");
?>

    <style>
        .ket-qua {
            height: 150px;
            overflow: hidden;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            padding: 5px;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .a-chua-img {
            height: 135px;
            display: inline-block;
            width: 100%;
        }

        .a-chua-img img { width: 100%; height: 100%; }
    </style>
    <section class="junior__classes__area section-lg-padding--top section-padding--md--bottom bg--white" style="padding-top: 40px">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="section__title text-center">
                        <h2 class="title__line">Tra Cứu</h2>
                    </div>
                </div>
            </div>

            <form action="tra-cuu.php" method="GET" class="row">
                <div class="col-md-2">
                    <select name="nien_khoa" id="" class="form-control">
                        <?php foreach ($data_nien_khoa as $item):?>
                            <option <?php if(isset($_GET['nien_khoa']) && (int)$_GET['nien_khoa'] > 0 && $_GET['nien_khoa'] == $item['id']) echo "selected"; ?>
                                    value="<?php echo $item['id']?>"><?php echo $item['ten_nien_khoa']?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="lop_hoc" id="" class="form-control">
                        <option value="all">Tất cả lớp</option>
                        <?php foreach ($data_lop_hoc as $item):?>
                            <option <?php if(isset($_GET['lop_hoc']) && (int)$_GET['lop_hoc'] > 0 && $_GET['lop_hoc'] == $item['id']) echo "selected"; ?>
                                    value="<?php echo $item['id']?>"><?php echo $item['mo_ta']?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-md-6">
                    <input name="keyword" value="<?php if(isset($_GET['keyword'])) echo $_GET['keyword'];?>" placeholder="Nhập thông tin bé để tra cứu" type="text" maxlength="255" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info w-100">Tra cứu</button>
                </div>
            </form>
            <?php
            if(true)
            {
                $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : "";
                if(!$keyword)
                {
                    echo "<p class=text-danger>Vui lòng nhập thông tin để tra cứu</p>";
                }
                else
                {
                    //Tìm kiếm bé
                    $query = "SELECT * FROM be 
                              INNER JOIN lophoc_be ON be.id = lophoc_be.be_id 
                              INNER JOIN lophoc_chitiet ON lophoc_be.lop_hoc_chi_tiet_id = lophoc_chitiet.id 
                              WHERE ten LIKE '%{$keyword}%' ";

                    // kiểm tra có tra cứu theo niên khóa - nối chuỗi truy vẫn
                    if(isset($_GET['nien_khoa']) && (int)$_GET['nien_khoa'] > 0) {
                        $query .= " AND lophoc_chitiet.nien_khoa_id = {$_GET['nien_khoa']} ";
                    }

                    // kiểm tra có tra cứu theo lớp học - nối chuỗi truy vẫn
                    if(isset($_GET['lop_hoc']) && (int)$_GET['lop_hoc'] > 0) {
                        $query .= " AND lophoc_chitiet.id = {$_GET['lop_hoc']} ";
                    }

                    $query .= " LIMIT 20"; // giới hạn kết quả trả về

                    $results = mysqli_query($dbc, $query);
                    $num = mysqli_num_rows($results);
                    if($num > 0)
                    {
                        echo "<p class=text-info>Có $num bé được tìm thấy với từ khóa: <i style='color: red !important;'>{$keyword}</i></p>";
                        foreach ($results as $item)
                        {
                            ?>
                            <div class="row ket-qua">
                                <div class = col-3>
                                    <a href="" class="a-chua-img">
                                        <img src="../admin/images/hinhbe/<?php echo $item['hinhbe'] ?>" alt="class images">
                                    </a>
                                </div>
                                <div class=" col-8">
                                    <h4><a href=""><?php echo $item['ten'] . " - " . getAge($item['ngaysinh']) . " tuổi" . " - " . $item['mo_ta']?></a></h4>
                                    <p>Ngày sinh: <?php echo date_format(date_create($item['ngaysinh']), "d/m/Y"); ?> - Giới tính: <?php if($item['gioitinh'] == 1) { echo "Nam"; } else echo "Nữ"; ?></p>
                                    <p>Địa chỉ: <?php echo $item['diachi']; ?></p>
                                    <p>SĐT cha: <?php echo $item['sdtcha']; ?> - SĐT mẹ: <?php echo $item['sdtme']; ?></p>
                                    <p>Tình trạng sức khỏe: <?php echo $item['tinhtrangsuckhoe']; ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        echo "<p class = text-danger>Không tìm thấy thông tin của bé</p>";
                    }
                }
            }
            ?>
        </div>
    </section>


<?php include "footer.php" ?>

<script>

    $(document).ready(function () {
        $('select[name="nien_khoa"]').change(function () {
            get_data_lop_hoc_theo_nien_khoa($(this).val());
        });

        function get_data_lop_hoc_theo_nien_khoa(id_nien_khoa) {
            $.ajax({
                type: "POST",
                url: 'admin/views/admin-be-xuly.php',
                data: { 'get_data_lop_hoc' : 1, 'id_nien_khoa': id_nien_khoa },
                success : function (result){
                    var data = JSON.parse(result);
                    console.log(data)
                    var str = '<option value="all">Tất cả lớp học</option>';
                    if(data.length > 0) {
                        data.forEach(function (item) {
                            str += '<option value="'+ item.id +'">'+ item.mo_ta +'</option>'
                        });
                        $('select[name="lop_hoc"]').html(str);
                    }

                }
            });
            $('select[name="lop_hoc"]').removeAttr('disabled');
        }
        // setTimeout(function () {
        //     get_data_lop_hoc_theo_nien_khoa($('select[name="nien_khoa"]'));
        // },1000);
    })
</script>
