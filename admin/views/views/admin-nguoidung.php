<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<!-- End header-->


<!-- Page content-->
<div class="main-content-container container-flu px-4">
	<!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Người Dùng</h3>
        </div>
    </div>
    <!-- End Page Header -->

	<!-- Default Light Table -->
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
			<!-- Danh sach loại tin -->
				<div class="card-header border-bottom">
					<h5 class="text-info">Danh sách người dùng</h5>
					<!-- <a class="btn btn-light" data-toggle="tooltip" title="Thêm Nhân viên" href="admin-nguoidung-them.php"><i class="material-icons action-icon">add</i></a> -->
					<a class="btn btn-light" data-toggle="tooltip" title="Thêm người dùng" href="admin-nguoidung-them.php"><i class="material-icons action-icon">add</i></a>
				</div>
				<div class="card-body p-0 pb-3 text-center">
					<table class="table mb-0">

						<thead class="bg-light">
							<tr>
								<th scope="col" class="border-0" >STT</th>
								<th scope="col" class="border-0" >Tên người dùng</th>
								<th scope="col" class="border-0" >Nhân viên</th>
								<th scope="col" class="border-0">Quyền</th>
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
	                            $query_pg="SELECT COUNT(id) FROM nguoidung";
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
							$query = "SELECT * FROM nguoidung ORDER BY id DESC LIMIT {$start},{$limit}";
							$results = mysqli_query($dbc, $query);
							foreach ($results as $key => $item)
							{ 
						?>
						<tbody>
							<tr>
								<td><?php echo ($key + 1) ?></td>
								<td><?php echo $item['ten_nguoi_dung'] ?></td>
								<td>
									<?php
                                        $query_id="SELECT ho_ten FROM nhanvien WHERE id={$item['nhan_vien_id']}";
                                        $result_id=mysqli_query($dbc,$query_id);
                                        if(mysqli_num_rows($result_id)==1)
                                        {
                                            list($name)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                                            echo $name;
                                        }                                       
                                    ?>
								</td>
								<td>
									<?php
									if($item['quyen'] == 1)
									{
										echo 'Admin';
									}
									else
									{
										echo 'Nhân viên';
									}
									?>	
								</td>
								<td>
									<a href="admin-nguoidung-sua.php?id=<?php echo $item['id']; ?>"><i class="material-icons action-icon">edit</i></a>
								</td>
								<td>
									<a href="admin-nguoidung-xoa.php?id=<?php echo $item['id']; ?>" onclick = "return confirm('Bạn có muốn xoá <?php echo $item['id'] ?>')" ><i class="material-icons action-icon">delete_outline</i></a>
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
		                        echo "<li class='page-item' class='float-left'><a class='page-link' href='admin-nguoidung.php?s=".($start - $limit)."&p={$per_page}'>Trở về</a></li>";
		                    }
		                    //hiện thị những phần còn lại của trang
		                    for ($i=1; $i <= $per_page ; $i++) 
		                    { 
		                        if($i != $current_page)
		                        {
		                            echo "<li class='page-item'><a class='page-link' href='admin-nguoidung.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
		                        }
		                        else
		                        {
		                            echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
		                        }
		                    }
		                    //Nếu không phải trang cuối thì hiện thị nút next
		                    if($current_page != $per_page)
		                    {
		                        echo "<li class='page-item' ><a class='page-link' href='admin-nguoidung.php?s=".($start + $limit)."&p={$per_page}'>Tiếp</a></li>";  
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