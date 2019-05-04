<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<!-- End header-->


<!-- Page content-->
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Hợp đồng</h3>
        </div>
    </div>
    <!-- End Page Header -->

	<!-- Default Light Table -->
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
			<?php
			//Kiểm tra ID có phải là kiểu số không, filter_var kiem tra có thuộc tính trim sẽ loại bỏ khoảng trắng
            if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
            {
                $id=$_GET['id'];
            }
            else
            {
                header('Location: admin-hopdong.php');
                exit();
            }
			?>
			<nav class="navbar navbar-expand-lg navbar-light bg-light ">
                 <!-- Links -->
                 <ul class="navbar-nav">
                    <li class="nav-item">
                       <a class="nav-link" href="admin-nhanvien-xem.php?id=<?php echo $id ?>">Nhân Viên</a>
                    </li>
                    <li class="nav-item">
                       <a class="nav-link" href="admin-congtac.php?id=<?php echo $id ?>">Công Tác</a>
                    </li>
                </ul>
            </nav>
			<!-- Danh sách hợp đồng -->
				<div class="card-header border-bottom">
					<h5 class="text-info">Danh sách hợp đồng</h5>
					<!-- <a class="btn btn-light" data-toggle="tooltip" title="Thêm tin tức" href="admin-tintuc-them.php"><i class="material-icons action-icon">add</i></a> -->
					<a class="btn btn-light" data-toggle="tooltip" title="Thêm hợp đồng" href="admin-hopdong-them.php?id=<?php echo $id; ?>"><i class="material-icons action-icon">add</i></a>
				</div>
				<div class="card-body p-0 pb-3 text-center">
					<table class="table mb-0">

						<thead class="bg-light">
							<tr>
								<th scope="col" class="border-0">STT</th>
								<th scope="col" class="border-0">Tên nhân viên</th>
								<th scope="col" class="border-0">Ngày ký</th>
								<th scope="col" class="border-0">Ngày bắt đầu</th>
								<th scope="col" class="border-0">Ngày kết thúc</th>
								<th scope="col" class="border-0">Loại hợp đồng</th>
								<th scope="col" class="border-0">Ghi chú</th>
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
	                            $query_pg="SELECT COUNT(hop_dong_id) FROM hopdong WHERE nhan_vien_id = $id";
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
							$query = "SELECT * FROM hopdong WHERE nhan_vien_id = $id ORDER BY hop_dong_id DESC, den_ngay DESC LIMIT {$start},{$limit}";
							$results = mysqli_query($dbc, $query);
							foreach ($results as $key => $item)
							{ 
						?>
						<tbody>
							<tr>
								<td><?php echo ($key + 1) ?></td>
								<td>
									<?php
                                    
                                        $query_id="SELECT id, ho_ten FROM nhanvien WHERE id = $id";
                                        $result_id=mysqli_query($dbc,$query_id);
                                        if(mysqli_num_rows($result_id)==1)
                                        {
                                            list($id,$name)=mysqli_fetch_array($result_id,MYSQLI_NUM);
                                            echo $name;
                                        }                                       
                                    ?>
								</td>
								<td><?php echo date( "d/m/Y", strtotime($item['ngay_ky'])) ?></td>
								<td><?php echo date( "d/m/Y", strtotime($item['tu_ngay'])) ?></td>
								<td><?php echo date( "d/m/Y", strtotime($item['den_ngay'])) ?></td>
								<td><?php echo $item['loai_hop_dong'] ?></td>
								<td><?php echo $item['ghi_chu'] ?></td>
								<?php
								//Lay ngay ket thuc co trong bang hop dong de so sanh
			                        $query_id="SELECT den_ngay FROM hopdong WHERE nhan_vien_id = $id ORDER BY den_ngay DESC LIMIT 0,1";
			                        $result_id=mysqli_query($dbc,$query_id);
			                        if(mysqli_num_rows($result_id)==1)
			                        {
			                            list($ngayktln)=mysqli_fetch_array($result_id,MYSQLI_NUM);
			                        }
			                        else
			                        {
			                            list($ngayktln) = "";
			                        }
			                        if($item['den_ngay'] < $ngayktln)
			                        {
			                        ?>
			                        	<td style="color : blue">Hết Hạn</td>
			                    	<?php
			                        }
			                        else
			                        {  
									?>
									<td>
										<a href="admin-hopdong-sua.php?id=<?php echo $item['hop_dong_id']; ?>"><i class="material-icons action-icon">edit</i></a>
									</td>
									<?php
									}
								?>
								<td>
									<a href="admin-hopdong-xoa.php?idnv=<?php echo $id ?>&id=<?php echo $item['hop_dong_id']; ?>" onclick="return confirm('Bạn có thực sự muốn xóa <?php echo $item['ten']; ?>');"><i class="material-icons action-icon">delete_outline</i></a>
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
		                        echo "<li class='page-item' class='float-left'><a class='page-link' href='admin-hopdong.php?id=".$id."&s=".($start - $limit)."&p={$per_page}'>Trở về</a></li>";
		                    }
		                    //hiện thị những phần còn lại của trang
		                    for ($i=1; $i <= $per_page ; $i++) 
		                    { 
		                        if($i != $current_page)
		                        {
		                            echo "<li class='page-item'><a class='page-link' href='admin-hopdong.php?id=".$id."&s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
		                        }
		                        else
		                        {
		                            echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
		                        }
		                    }
		                    //Nếu không phải trang cuối thì hiện thị nút next
		                    if($current_page != $per_page)
		                    {
		                        echo "<li class='page-item' ><a class='page-link' href='admin-hopdong.php?id=".$id."&s=".($start + $limit)."&p={$per_page}'>Tiếp</a></li>";  
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