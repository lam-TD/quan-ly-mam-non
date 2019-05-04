<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<!-- End header-->

<script>
	$( document ).ready( function () {
		$( '#heading5 .panel-heading' ).attr( 'aria-expanded', 'true' );
		$( '#collapse5' ).addClass( 'show' );
		$( '#collapse5 .list-group a:nth-child(1)' ).addClass( 'cus-active' );
	} );
</script>

<div class="main-content-container container-fluid px-4" style="margin-top:10px">
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
				<div class="card-header border-bottom">
					<h5 class="text-info salary-h5" style="margin: 7px 0 0 0;display: inline-block">Tìm kiếm bé</h5>
					<a href="admin-be-them.php" class="btn-custom2" style="float: right; margin-right: 20px; font-size: 14px">Thêm bé</a>
				</div>
				<style>
					.salary-table {
						width: 96%;
						margin: 0 auto 1.5rem auto;
						border: 1px solid #eaeaea;
						border-radius: 8px;
						border-spacing: 0;
						border-collapse: unset;
						overflow: hidden;
					}
					
					.salary-table td.textStr {
						text-align: left;
					}
					
					.salary-table td.numberStr {
						text-align: right;
					}
					
					.salary-table tr:not(.salary-title):nth-child(even) {
						background-color: #eaeaea;
					}
					
					.salary-table tr td,
					.salary-table tr th {
						vertical-align: middle;
					}
					
					.salary-table th {
						background-color: #66b1cc;
						color: white;
					}
					
					.salary-title th:not(:last-child) {
						border-right: 1px solid #ffffff38 !important;
					}
					
					.salary-title:nth-child(2) th {
						border-top: 1px solid #ffffff38 !important;
					}
					
					.filter-month-year .left-filter .form-control {
						width: 7%;
						min-width: 70px;
					}
					
					.filter-month-year .left-filter label {
						margin: auto 8px auto 30px;
					}
					
					.btn-custom {
						background: -webkit-linear-gradient(left, #66a7cf 5%, #66bcca);
						color: white !important;
						font-size: 16px;
						padding: 9px 40px;
						display: inline-block;
						cursor: pointer;
					}
					
					.btn-custom:hover {
						color: skyblue !important;
						background: white;
						border: 2px solid skyblue;
						padding: 7px 38px;
					}
					
					.btn-custom2 {
						background: -webkit-linear-gradient(left, #66a7cf 5%, #66bcca);
						color: white !important;
						font-size: 18px;
						padding: 8px 35px;
						display: inline-block;
						cursor: pointer;
						outline: none !important;
					}
					
					.btn-custom2:hover {
						color: skyblue !important;
						background: white;
						border: 2px solid skyblue;
						padding: 6px 33px;
					}
					
					#editSalaryModal table tr td {
						vertical-align: middle;
						font-size: 11pt;
					}
					
					#editSalaryModal table tr td:first-child {
						padding: 5px 20px 5px 5px;
					}
					
					#editSalaryModal table tr td label {
						color: black;
						margin-bottom: 0;
					}
					
					.search-container {
						width: 70%;
						margin: 0 auto;
						border: 4px solid skyblue;
						border-radius: 20px;
						padding: 40px 50px;
					}
					
					.input-search input {
						outline: none;
						font-size: 15pt;
						padding: 5px 10px;
						color: darkgray;
					}
					
					.input-search input::placeholder {
						color: darkgray;
					}
					
					.input-search input:focus {
						color: black;
					}
					
					.input-search {
						border: 1px dotted skyblue;
						display: inline-block;
						padding: 3px 15px;
						margin-right: 6%;
					}
					
					.input-search:focus-within {
						border: 2px solid skyblue;
						padding: 2px 14px;
					}
					
					.input-search i {
						font-size: 13pt;
					}
				</style>
				<div class="card-body p-0 text-center" style="margin: 30px 0">
					<div class="search-container">
						<form action="" method="get">
							<div class="input-search">
								<span class="glyphicon glyphicon-search" style="font-size: 16px;"></span>
								<input name="searchKey" class="teeetet" type="text" placeholder="Nhập tên bé" <?php if(isset($_GET['searchKey'])) echo 'value="'.$_GET['searchKey'].'"'?>/>
							</div>
							<button name="btnSeach" class="btn-custom2" type="submit">Tìm kiếm</button>
						</form>
					</div>


                    <div class="container-salary" style="margin-top: 30px;">
                        <table class="table salary-table">
                            <tr class="salary-title">
                                <th scope="col" class="border-0" style="width: 40%;">Tên</th>
                                <th scope="col" class="border-0" style="width: 30%;">Hình ảnh</th>
                                <th scope="col" class="border-0" style="width: 10%;">Giới tính</th>
                                <th scope="col" class="border-0" style="width: 10%;">Lớp</th>
                                <th scope="col" class="border-0" style="width: 10%;"></th>
                            </tr>
                            <?php
                            if (!isset($_GET['searchKey']) && empty($_GET['searchKey'])) $query = "SELECT * FROM be ORDER BY id DESC";
                            else $query = "SELECT * FROM be WHERE ten LIKE '%{$_GET['searchKey']}%' ORDER BY REVERSE(SPLIT_STRING(REVERSE(TRIM(ten)),' ', 1))";
                            $results = mysqli_query( $dbc, $query );
                            if ( mysqli_num_rows($results) > 0)
                                foreach ( $results as $key => $item ) {
                                    ?>
                                <tr>
                                    <td><?php echo $item['ten']." - ".getAge($item['ngaysinh'])." tuổi";?></td>
                                    <td><img src="../images/hinhbe/<?php echo $item['hinhbe']?>" style="width: 100px; height: 120px;"></td>
                                    <td><?php if($item['gioitinh'] == 1) echo 'Nam'; else echo 'Nữ';?></td>
                                    <td><?php echo 'Lá'?></td>
                                    <td><a href="admin-be-sua.php?id=<?php echo $item['id']?>" class="btn-custom2" style="font-size: 12px;">Xem</a></td>
                                </tr>
                            <?php
                                }
                            else{
                                ?>
                                <tr><td colspan="5" align="center">Không tìm thấy</td></tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>


				</div>
			</div>
		</div>
	</div>
</div>



<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer