<?php include "header.php" ?>
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

            <?php
                if(isset($_REQUEST['submit'])) {
                    echo "lammmmmmmmm";
                }

            ?>

            <form action="tra-cuu.php" method="GET" class="row">
                <div class="col-md-3">
                    <select name="" id="" class="form-control">
                        <option value="0">Tra cứu Bé</option>
                        <option value="0">Tra cứu lớp học</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <input name="keyword" value="<?php if(isset($_GET['keyword'])) echo $_GET['keyword'];?>" placeholder="Nhập thông tin tra cứu" type="text" maxlength="255" class="form-control">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info">Tra cứu</button>
                </div>
            </form>
            <?php
            if(true)
            {
                $keyword = $_GET['keyword'];
                if(!$keyword)
                {
                    echo "<p class=text-danger>Vui lòng nhập dữ liệu vào ô trống</p>";
                }
                else
                {
                    //Tìm kiếm bài viết tin tức
                    $query = "SELECT * FROM be 
                                              INNER JOIN lophoc_be ON be.id = lophoc_be.be_id 
                                              INNER JOIN lophoc_chitiet ON lophoc_be.lop_hoc_chi_tiet_id = lophoc_chitiet.id WHERE ten LIKE '%{$keyword}%'";
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
                                    <h4><a href=""><?php echo $item['ten']." - ".getAge($item['ngaysinh'])." tuổi"; ?></a></h4>
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
                        echo "<p class = text-danger>Không tìm thấy bài viết</p>";
                    }
                }
            }
            ?>
        </div>
    </section>
<?php include "footer.php" ?>