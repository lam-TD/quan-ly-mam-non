<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<!-- End header-->
<script>
    $(document).ready(function () {
        $('#heading6 .panel-heading').attr('aria-expanded', 'true');
        $('#collapse6').addClass('show');
        $('#collapse6 .list-group a:nth-child(2)').addClass('cus-active');
    });
</script>

<!-- Page content-->
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Bằng cấp</h3>
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
					if(empty($_POST['txtTenbangcap']))
					{
						$errors[] = 'txtTenbangcap';
					}
					else
					{
						$name = $_POST['txtTenbangcap']; 
					}
					if(!is_numeric($_POST['txtHeSo']))
					{
						$errors[] = 'txtHeSo';
					}
					else
					{
						$heso = $_POST['txtHeSo']; 
						if($heso <= 0)
							$errors[] = 'txtHeSo2';
					}
					if(empty($errors))
					{
						$query = "INSERT INTO bangcap(ten_bang_cap, heso) VALUES('{$name}','$heso')";
						$results = mysqli_query($dbc, $query);
						//Kiem tra them moi thanh cong hay chua
						if(mysqli_affected_rows($dbc)==1)
                        {
                    ?>
                        	<script>
                        		alert("thêm thành công");
								window.location="admin-bangcap.php";
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
                    if (isset($message)) echo $message;
				?>
				<div class="card-header border-bottom">
					<h5 class="text-info">Thêm bằng cấp</h5>
					<form action="" method="post">
						<div class="form-group">
							<label>Tên Bằng Cấp</label>
							<input class="form-control" name="txtTenbangcap" placeholder="Vui lòng nhập tên bằng cấp" value = "<?php if(isset($_POST['txtTenbangcap'])) {echo $_POST['txtTenbangcap'];} ?>">
							<?php 
                                if(isset($errors) && in_array('txtTenbangcap',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên bằng cấp</p>";
                                }
                            ?>
                        </div>
						<div class="form-group">
							<label>Hệ Số</label>
							<input class="form-control" name="txtHeSo" placeholder="Vui lòng nhập hệ số" value = "<?php if(isset($_POST['txtHeSo'])) {echo $_POST['txtHeSo'];} ?>">
							<?php 
                                if(isset($errors) && in_array('txtHeSo',$errors))
                                {
                                    echo "<p class='text-danger'>Hệ số không hợp lệ</p>";
                                }
				 				if(isset($errors) && in_array('txtHeSo2',$errors))
                                {
                                    echo "<p class='text-danger'>Hệ số phải lớn hơn 0</p>";
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
					<form action="admin-bangcap.php" method="get">
						<h5 class="text-info">Danh sách bằng cấp</h5>
						<button type="submit" name="them" class="btn btn-light"><i class="material-icons action-icon">add</i></button>
					</form>
				</div>
				<div class="card-body p-0 pb-3 text-center">
					<table class="table mb-0">

						<thead class="bg-light">
							<tr>
								<th scope="col" class="border-0">STT</th>
								<th scope="col" class="border-0">Tên bằng cấp</th>
								<th scope="col" class="border-0">Hệ số</th>
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
	                            $query_pg="SELECT COUNT(bang_cap_id) FROM bangcap";
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
							$query = "SELECT * FROM bangcap ORDER BY bang_cap_id ASC LIMIT {$start},{$limit}";
							$results = mysqli_query($dbc, $query);
							foreach ($results as $key => $item)
							{ 
						?>
						<tbody>
							<tr>
								<td><?php echo ($key +$start+ 1) ?></td>
								<td><?php echo $item['ten_bang_cap'] ?></td>
								<td><?php echo $item['heso'] ?></td>
								</td>
								<td>
									<a href="admin-bangcap-sua.php?id=<?php echo $item['bang_cap_id']; ?>"><i class="material-icons action-icon">edit</i></a>
								</td>
								<td>
									<a href="admin-bangcap-xoa.php?id=<?php echo $item['bang_cap_id']; ?>" onclick="return confirm('Bạn có thực sự muốn xóa <?php echo $item['ten_bang_cap']; ?>');"><i class="material-icons action-icon">delete_outline</i></a>
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
		                        echo "<li class='page-item' class='float-left'><a class='page-link' href='admin-bangcap.php?s=".($start - $limit)."&p={$per_page}'>Trở về</a></li>";
		                    }
		                    //hiện thị những phần còn lại của trang
		                    for ($i=1; $i <= $per_page ; $i++) 
		                    { 
		                        if($i != $current_page)
		                        {
		                            echo "<li class='page-item'><a class='page-link' href='admin-bangcap.php?s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
		                        }
		                        else
		                        {
		                            echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
		                        }
		                    }
		                    //Nếu không phải trang cuối thì hiện thị nút next
		                    if($current_page != $per_page)
		                    {
		                        echo "<li class='page-item' ><a class='page-link' href='admin-bangcap.php?s=".($start + $limit)."&p={$per_page}'>Tiếp</a></li>";  
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