<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<!-- End header-->

<script>
	$( document ).ready( function () {
		$( '#heading6 .panel-heading' ).attr( 'aria-expanded', 'true' );
		$( '#collapse6' ).addClass( 'show' );
		$( '#collapse6 .list-group a:nth-child(1)' ).addClass( 'cus-active' );
	} );
</script>
<?php 
//Kiểm tra ID có phải là kiểu số không, filter_var kiem tra có thuộc tính trim sẽ loại bỏ khoảng trắng
if(isset($_GET['changeStatusId']) && filter_var($_GET['changeStatusId'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$query_nd = "UPDATE nhanvien SET trangthai = !trangthai WHERE id = {$_GET['changeStatusId']}";
    $results_nd= mysqli_query($dbc, $query_nd);
}
?>
<!-- Page content-->
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Dashboard</span>
			<h3 class="page-title">Nhân viên</h3>
		</div>
	</div>
	<!-- End Page Header -->

	<!-- Default Light Table -->
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
				<!-- Danh sach loại tin -->
				<div class="card-header border-bottom">
					<h5 class="text-info">Danh sách Nhân viên</h5>
					<!-- <a class="btn btn-light" data-toggle="tooltip" title="Thêm Nhân viên" href="admin-nhanvien-them.php"><i class="material-icons action-icon">add</i></a> -->
					<a class="btn btn-light" data-toggle="tooltip" title="Thêm Nhân viên" href="admin-nhanvien-them.php"><i class="material-icons action-icon">add</i></a>
				</div>
				<div class="card-body p-0 pb-3 text-center table-data">
					<table class="table mb-0">

						<thead class="bg-light">
							<tr>
								<th scope="col" class="border-0">STT</th>
								<th scope="col" class="border-0">Họ tên</th>
								<th scope="col" class="border-0">Giới tính</th>
								<th scope="col" class="border-0">Chức vụ</th>
								<th scope="col" class="border-0">Phòng ban</th>
								<th scope="col" class="border-0" style="width:10%">Chỉnh sửa</th>
								<th scope="col" class="border-0" style="width:10%">Trạng thái</th>
							</tr>
						</thead>
						<?php
						//đặt số bản ghi cần hiện thị
						$limit = 10;
						//Xác định vị trí bắt đầu
						if ( isset( $_GET[ 's' ] ) && filter_var( $_GET[ 's' ], FILTER_VALIDATE_INT, array( 'min_range' => 1 ) ) ) {
							$start = $_GET[ 's' ];
						} else {
							$start = 0;
						}
						if ( isset( $_GET[ 'p' ] ) && filter_var( $_GET[ 'p' ], FILTER_VALIDATE_INT, array( 'min_range' => 1 ) ) ) {
							$per_page = $_GET[ 'p' ];
						} else {
							//Nếu p không có, thì sẽ truy vấn CSDL để tìm xem có bao nhiêu page
							$query_pg = "SELECT COUNT(id) FROM nhanvien";
							$results_pg = mysqli_query( $dbc, $query_pg );
							list( $record ) = mysqli_fetch_array( $results_pg, MYSQLI_NUM );
							//Tìm số trang bằng cách chia số dữ liệu cho số limit   
							if ( $record > $limit ) {
								$per_page = ceil( $record / $limit );
							} else {
								$per_page = 1;
							}
						}
						$query = "SELECT * FROM nhanvien ORDER BY REVERSE(SPLIT_STRING(REVERSE(TRIM(ho_ten)),' ', 1)) LIMIT {$start},{$limit}";
						$results = mysqli_query( $dbc, $query );
						foreach ( $results as $key => $item ) {
							?>
						<tbody>
							<tr>
								<td>
									<?php echo ($key+$start + 1) ?>
								</td>
								<td>
									<?php echo $item['ho_ten'] ?>
								</td>
								<td>
									<?php
									if ( $item[ 'gioi_tinh' ] == 1 ) {
										echo 'Nam';
									} else {
										echo 'Nữ';
									}
									?>
								</td>
								<td>
									<?php
									$q = "SELECT ten_cong_viec FROM congviec WHERE congviec_id={$item['cong_viec_id']}";
									$rs = mysqli_fetch_assoc( mysqli_query( $dbc, $q ) );
									echo $rs[ 'ten_cong_viec' ];
									?>
									<td>
										<?php
										$query_id = "SELECT phong_ban_id, ten_phong_ban FROM phongban WHERE phong_ban_id={$item['phong_ban_id']}";
										$result_id = mysqli_query( $dbc, $query_id );
										if ( mysqli_num_rows( $result_id ) == 1 ) {
											list( $id, $name ) = mysqli_fetch_array( $result_id, MYSQLI_NUM );
											echo $name;
										}
										?>
									</td>
									<td>
										<a href="admin-nhanvien-xem.php?id=<?php echo $item['id']; ?>"><i class="material-icons action-icon">edit</i></a>
									</td>
									<td>
										<a href="javascript:changeStatusEmp(<?php echo $item['id']; ?>);" onclick="return confirm('Bạn có muốn <?php if($item['trangthai']) echo 'vô hiệu hoá'; else echo 'kích hoạt' ?> <?php echo '&quot;'.$item['ho_ten'].'&quot;'; ?>')" class="change-status-btn"><i class="material-icons action-icon"><?php if($item['trangthai']) echo 'check_box'; else echo 'check_box_outline_blank' ?></i></a>
									</td>
							</tr>
						</tbody>
						<?php } ?>
					</table>
					<script>
						function changeStatusEmp( id ) {							
							$.ajax( {
								type: "GET",
								url: "admin-nhanvien.php?s="+<?php echo $start?>+"&p="+<?php echo $per_page?>+"&changeStatusId=" + id,
								success: function ( result ) {
									$('.table-data').html($(result).find('.table-data').html());
								}
							} );
						}
						//						$('.change-status-btn').on('click',function(){
						//							var content = $(this).find('i').text();
						//							if(content == 'check_box')
						//								$(this).find('i').text('check_box_outline_blank');
						//							else
						//								$(this).find('i').text('check_box');
						//						});
					</script>
					<?php
					echo "<nav aria-label='Page navigation example'>";
					echo "<ul class='pagination justify-content-center'>";
					if ( $per_page > 1 ) {
						$current_page = ( $start / $limit ) + 1;
						//Nếu không phải là trang đầu thì hiện thị trang trước
						if ( $current_page != 1 ) {
							echo "<li class='page-item' class='float-left'><a class='page-link' href='admin-nhanvien.php?s=" . ( $start - $limit ) . "&p={$per_page}'>Trở về</a></li>";
						}
						//hiện thị những phần còn lại của trang
						for ( $i = 1; $i <= $per_page; $i++ ) {
							if ( $i != $current_page ) {
								echo "<li class='page-item'><a class='page-link' href='admin-nhanvien.php?s=" . ( $limit * ( $i - 1 ) ) . "&p={$per_page}'>{$i}</a></li>";
							} else {
								echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
							}
						}
						//Nếu không phải trang cuối thì hiện thị nút next
						if ( $current_page != $per_page ) {
							echo "<li class='page-item' ><a class='page-link' href='admin-nhanvien.php?s=" . ( $start + $limit ) . "&p={$per_page}'>Tiếp</a></li>";
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
</div>
<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer