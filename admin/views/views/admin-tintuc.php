<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<!-- End header-->
<script>
		$( document ).ready( function () {
					$('#heading1 .panel-heading').attr('aria-expanded','true');
					$('#collapse1').addClass('show');
					$('#collapse1 .list-group a:nth-child(3)').addClass('cus-active');
		});
	</script>

<!-- Page content-->
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Tin tức</h3>
        </div>
    </div>
    <!-- End Page Header -->

	<!-- Default Light Table -->
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
			<!-- Danh sach loại tin -->
				<div class="card-header border-bottom">
					<h5 class="text-info">Danh sách tin tức</h5>
					<!-- <a class="btn btn-light" data-toggle="tooltip" title="Thêm tin tức" href="admin-tintuc-them.php"><i class="material-icons action-icon">add</i></a> -->
					<a class="btn btn-light" data-toggle="tooltip" title="Thêm tin tức" href="admin-tintuc-them.php"><i class="material-icons action-icon">add</i></a>
				</div>
				<div class="card-body p-0 pb-3 text-center">
					<table class="table mb-0">

						<thead class="bg-light">
							<tr>
								<th scope="col" class="border-0" >STT</th>
								<th scope="col" class="border-0" >Hình</th>
								<th scope="col" class="border-0" >Tên tin tức</th>
								<th scope="col" class="border-0">Loại tin id</th>
								<th scope="col" class="border-0">Người đăng</th>
								<th colspan="2" scope="col" class="border-0">Thao tác</th>
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
	                            $query_pg="SELECT COUNT(id) FROM tintuc";
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
							$query = "SELECT * FROM tintuc ORDER BY id DESC LIMIT {$start},{$limit}";
							$results = mysqli_query($dbc, $query);
							foreach ($results as $key => $item)
							{ 
						?>
						<tbody>
							<tr>
								<td><?php echo ($key + 1) ?></td>
								<td>
									<img width="100px" src="../images/tintuc/<?php echo $item['hinh']; ?>" alt="Hình Ảnh">
								</td>
								<td><?php echo $item['tieude'] ?></td>
								<td>
									<?php
                                        $query_id="SELECT id,ten FROM loaitin WHERE id={$item['loai_tin_id']}";
                                        $result_id=mysqli_query($dbc,$query_id);
                                        if(mysqli_num_rows($result_id)==1)
                                        {
                                            list($id,$name)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                                            echo $name;
                                        }                                       
                                    ?>
								</td>
								<td>
									<?php
                                        $query_id="SELECT id,ten_nguoi_dung FROM nguoidung WHERE id={$item['nguoi_dang']}";
                                        $result_id=mysqli_query($dbc,$query_id);
                                        if(mysqli_num_rows($result_id)==1)
                                        {
                                            list($id,$name)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                                            echo $name;
                                        }                                       
                                    ?>
								</td>
								<td>
									<a href="admin-tintuc-sua.php?id=<?php echo $item['id']; ?>"><i class="material-icons action-icon">edit</i></a>
								</td>
								<td>
									<a href="admin-tintuc-xoa.php?id=<?php echo $item['id']; ?>" onclick = "return confirm('Bạn có muốn xoá <?php echo $item['tieude'] ?>')" ><i class="material-icons action-icon">delete_outline</i></a>
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
		                        echo "<li class='page-item' class='float-left'><a class='page-link' href='admin-tintuc.php?s=".($start - $limit)."&p={$per_page}'>Trở về</a></li>";
		                    }
		                    //hiện thị những phần còn lại của trang
		                    for ($i=1; $i <= $per_page ; $i++) 
		                    { 
		                        if($i != $current_page)
		                        {
		                            echo "<li class='page-item'><a class='page-link' href='admin-tintuc.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
		                        }
		                        else
		                        {
		                            echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
		                        }
		                    }
		                    //Nếu không phải trang cuối thì hiện thị nút next
		                    if($current_page != $per_page)
		                    {
		                        echo "<li class='page-item' ><a class='page-link' href='admin-tintuc.php?s=".($start + $limit)."&p={$per_page}'>Tiếp</a></li>";  
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



</div>
<!-- End page content-->


<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer