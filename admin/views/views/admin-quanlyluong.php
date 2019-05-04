<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>
<script>
	$( '#heading3 .parent-active' ).addClass( 'parent-selected' );
	$( '#heading3 .parent-active .panel-heading' ).attr( 'aria-expanded', 'true' );
</script>
<?php
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
	if ( isset( $_POST[ 'typeForm' ] ) && $_POST[ 'typeForm' ] == 'insert-salary' ) {
		$query = "SELECT id FROM nhanvien where trangthai = 1";
		$list = array();
		$results = mysqli_query( $dbc, $query );
		foreach ( $results as $key => $item ) {
			$list[] = $item[ 'id' ];
		}
		$stringjson = json_encode( $list );
		$query_check = "SELECT * FROM quanlyluong WHERE thang = " . date( 'm' ) . " and nam = " . date( 'Y' );
		$rs_check = mysqli_query( $dbc, $query_check );
		if ( mysqli_num_rows( $rs_check ) == 0 ) {
			$mlinsert = mysqli_fetch_assoc( mysqli_query( $dbc,"select mucluong from luongcoso" ) );
			$mlinsert = $mlinsert[ 'mucluong' ];
			$query_tt = "INSERT INTO quanlyluong(danhsach,mucluong, thang, nam) VALUES('$stringjson','$mlinsert', " . date( 'm' ) . ", " . date( 'Y' ) . ") ";
			if ( mysqli_query( $dbc, $query_tt ) ) {
				$idNew = mysqli_insert_id( $dbc );
				echo '<script>changeSalaryData(' . $idNew . ');</script>';
			}
		}
	} else if ( isset( $_POST[ 'typeForm' ] ) && $_POST[ 'typeForm' ] == 'edit-salary-basic' ) {

		$_POST[ 'new-salary-basic' ] = str_replace( '.', '', $_POST[ 'new-salary-basic' ] );
		$query_edit = "UPDATE luongcoso SET mucluong = '{$_POST[ 'new-salary-basic' ]}'";
		mysqli_query( $dbc, $query_edit );
		if ( mysqli_affected_rows( $dbc ) == 1 ) {
			$query_edit_salary_nv = "UPDATE nhanvien SET muc_luong_cb = he_so * {$_POST[ 'new-salary-basic' ]}";
			mysqli_query( $dbc, $query_edit_salary_nv );
			$query_edit_salary_ds = "UPDATE quanlyluong SET mucluong = {$_POST[ 'new-salary-basic' ]} WHERE thang = " . date( 'm' ) . " and nam = " . date( 'Y' );
			mysqli_query( $dbc, $query_edit_salary_ds );
			echo '<script>$("#editSalaryModal").hide();changeSalaryData("reload");</script>';
		}
	}

}
?>
<div class="main-content-container container-fluid px-4" style="margin-top:10px">
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
				<div class="card-header border-bottom">
					<h5 class="text-info salary-h5" style="margin: 7px 0 0 0;">Quản lý lương</h5>
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
						font-size: 14px;
						padding: 8px 35px;
						display: inline-block;
						cursor: pointer;
					}
					
					.btn-custom2:hover {
						color: skyblue !important;
						background: white;
						border: 2px solid skyblue;
						padding: 6px 33px;
					}
					#editSalaryModal table tr td{
						vertical-align: middle;
						font-size: 11pt;
					}
					#editSalaryModal table tr td:first-child{
						padding: 5px 20px 5px 5px;
					}
					#editSalaryModal table tr td label{
						color: black;
						margin-bottom: 0;
					}
				</style>
				<div class="card-body p-0 text-center">
					<div>
						<div class="filter-month-year" style="margin: 10px 0">
							<div class="left-filter" style="display: flex; float: left;margin-bottom: 10px">
								<label>Năm</label>
								<?php 
							 $query_cv="SELECT nam FROM quanlyluong group by nam";
                              $cvs=mysqli_query($dbc,$query_cv);
							if(mysqli_num_rows($cvs)>0){
							?>
								<select class="form-control" onChange="getMonth(this.value);">
									<option value="0">Năm</option>
									<?php                                    
                                    foreach ($cvs as $item) {
                                ?>
									<option value="<?php echo $item['nam']?>">
										<?php echo $item['nam'] ?>
									</option>
									<?php
									}
									?>
								</select>
								<?php }else{
								echo '<select class="form-control" disabled></select>';
							}
							?>
								<label>Tháng</label>
								<select class="form-control get-month" disabled onChange="changeSalaryData(this.value);">
									<option value="0">Tháng</option>
								</select>
							</div>
							<a class="btn-custom2" style="float:right;margin: auto 25px 0px 0;display:none" data-toggle="modal" data-target="#editSalaryModal">Cập nhật mức lương cơ sở</a>
							<div class="modal fade" id="editSalaryModal">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Cập nhật mức lương cơ sở</h4>
											<!--											<button type="button" style="outline: none;" class="close" data-dismiss="modal">&times;</button>-->
										</div>
										<form action="" method="post" onSubmit="return validateSalary();">
											<div class="modal-body">
												<table style="width: 100%">
													<tr>
														<td style="width: 47%; text-align: right"><label>Mức lương hiện tại</label></td>
														<td><label style="text-align: left;display: block; text-indent: 13px; color: #7b7b7be6"><?php $slrOld = mysqli_fetch_assoc( mysqli_query( $dbc,
										"select mucluong from quanlyluong WHERE thang = " . date( 'm' ) . " and nam = " . date( 'Y' ) ) );
									echo formatCurrencyCustom( $slrOld[ 'mucluong' ] )?></label></td>
													</tr>
													<tr>
														<td style="text-align: right"><label>Mức lương cập nhật</label></td>
														<td><input onFocus="$('#editSalaryModal').find('.text-danger').css('display','none');" style="color: #03923c !important; font-size: 0.95rem; width: 80%" class="form-control formatCurrency" name="new-salary-basic"/>
												</td>
													</tr>	
													<tr>
														<td></td>
														<td><p class='text-danger' style="display:none; transition: 200ms; font-size: 10pt; margin: 0; text-align: left;">Mức lương cơ sở không hợp lệ</p></td>
													</tr>
													</table>
												<input type="hidden" name="typeForm" value="edit-salary-basic"/>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-success" style="border-color: #0d864b;background-color: #14a25d;">Cập nhật</button>
												<button type="button" class="btn btn-danger" style="background-color:#e02e2e" data-dismiss="modal">Đóng</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<script>
							function validateSalary() {
								if ( $( "input[name='new-salary-basic']" ).val() == "" ) {
									$( "#editSalaryModal" ).find( '.text-danger' ).css( "display", "block" );
									return false;
								}
							}

							function getMonth( id ) {
								$.ajax( {
									type: "GET",
									url: "getMucLuong.php?yearid=" + id,
									success: function ( result ) {
										if ( id == 0 )
											$( '.get-month' ).prop( 'disabled', 'true' );
										else
											$( '.get-month' ).removeAttr( 'disabled' );
										$( '.get-month' ).html( result );
									}
								} );
							}

							function changeSalaryData( id ) {
								if ( id != 0 ) {
									var ajaxUrl = "admin-quanlyluong.php?salaryDataId=" + id;
									if ( id == 'reload' )
										ajaxUrl = "admin-quanlyluong.php";
									$.ajax( {
										type: "GET",
										url: ajaxUrl,
										success: function ( result ) {
											$( '.container-salary' ).html( $( result ).find( '.container-salary' ).html() );
										}
									} );
								}
							}
						</script>
					</div>
					<div class="container-salary">
						<?php 
						if( isset( $_GET[ 'salaryDataId' ] ) )
							$query = "SELECT danhsach,thang,nam FROM quanlyluong where id = {$_GET[ 'salaryDataId' ]} ";
						else{							
							$query = "SELECT danhsach FROM quanlyluong where thang = ".date('m')." and nam = ".date('Y');
						}
						//(date('m')+1)
						$results = mysqli_fetch_assoc(mysqli_query( $dbc, $query ));
						$thang = date('m');
						$nam = date('Y');
						if( isset( $_GET[ 'salaryDataId' ] ) ){
							$thang = $results['thang'];
							$nam = $results['nam'];
						}
						if(intval($thang) == intval(date('m')) && intval($nam) == intval(date('Y'))){
							echo "<script>$('.btn-custom2').css('display','block');</script>";
						}else{
							echo "<script>$('.btn-custom2').css('display','none');</script>";
						}
						$list = json_decode( $results['danhsach'], true );
						if(!is_null($list)){
							echo "<script>$('.text-info.salary-h5').text('Lương tháng {$thang} năm {$nam}');</script>";
							?>
						<table class="table salary-table">
							<tr class="salary-title">
								<th scope="col" rowspan="2" style="width: 5%;" class="border-0">STT</th>
								<th scope="col" rowspan="2" class="border-0">Họ và tên</th>
								<th scope="col" rowspan="2" class="border-0">Chức vụ</th>
								<th scope="col" rowspan="2" style="width: 8%;" class="border-0">Hệ số lương</th>
								<th scope="col" rowspan="2" class="border-0">Lương tháng</th>
								<th scope="col" rowspan="2" style="width: 8%;" class="border-0">Hệ số phụ cấp chức vụ</th>
								<th scope="col" rowspan="2" style="width: 10%;" class="border-0">Tiền phụ cấp chức vụ</th>
								<th scope="col" colspan="3" class="border-0">Bảo hiểm</th>
								<th scope="col" class="border-0">Lương cơ sở:
									<?php
									$slr = mysqli_fetch_assoc( mysqli_query( $dbc,
										"select mucluong from quanlyluong WHERE thang = $thang and nam = $nam"));
									$luongcoso = $slr[ 'mucluong' ];
									echo formatCurrencyCustom( $slr[ 'mucluong' ] )
									?>
								</th>
							</tr>
							<tr class="salary-title">
								<th scope="col" class="border-0" style="width: 10%;">BH Y Tế (10.5%)</th>
								<th scope="col" class="border-0" style="width: 10%;">BH Xã Hội (8%)</th>
								<th scope="col" class="border-0" style="width: 10%;">BH Tai Nạn (1%)</th>
								<th scope="col" class="border-0" style="width: 11%;">Tiền thực lãnh (VNĐ)</th>
							</tr>
							<?php 						
						$count = count( $list );
						$i = 1;
						$text = '';
						foreach ( $list as $id ) {
							if ( $count > $i )
								$text = $text . $id . ",";
							else
								$text = $text . $id;
							$i++;
						}
						$query = "SELECT * FROM nhanvien WHERE id IN ({$text}) ORDER BY REVERSE(SPLIT_STRING(REVERSE(TRIM(ho_ten)),' ', 1))";
						$results = mysqli_query( $dbc, $query );
						foreach ( $results as $key => $item ) {
							?>
							<tr>
								<td>
									<?php echo ($key + 1) ?>
								</td>
								<td class="textStr">
									<?php echo $item['ho_ten'] ?>
								</td>
								<td class="textStr">
									<?php $cv = mysqli_fetch_assoc( mysqli_query( $dbc, 
		"select ten_cong_viec from congviec where congviec_id = {$item['cong_viec_id']}" ));
									echo $cv['ten_cong_viec']?>
								</td>
								<td>
									<?php echo $item['he_so'] ?>
								</td>
								<?php 
									$tong = round(($luongcoso * $item['he_so']),-2);
									$yte = round(($tong/100*10.5),-2);
							$xahoi = round(($tong/100*8),-2);
							$tainan = round(($tong/100*1),-2);							
								?>
								<td class="numberStr">
									<?php $temp =  $tong;
							if(strlen($temp)>3){
							for($i = strlen($temp)-3; $i>0 ;$i-=3){
								$temp = substr($temp,0,$i).".".substr($temp,$i);
							}} echo $temp; ?>
								</td>
								<td>
									<?php $cv2 = mysqli_fetch_assoc( mysqli_query( $dbc, 
		"select phucap from congviec where congviec_id = {$item['cong_viec_id']}" ));
									echo $cv2['phucap']?>
								</td>
								<td class="numberStr">
									<?php echo ($cv2['phucap'] * $luongcoso) ?>
								</td>								
								<td class="numberStr">
									<?php 
							$temp =  $yte;
							if(strlen($temp)>3){
							for($i = strlen($temp)-3; $i>0 ;$i-=3){
								$temp = substr($temp,0,$i).".".substr($temp,$i);
							}} echo $temp;?>
								</td>
								<td class="numberStr">
									<?php 
							$temp =  $xahoi;
							if(strlen($temp)>3){
							for($i = strlen($temp)-3; $i>0 ;$i-=3){
								$temp = substr($temp,0,$i).".".substr($temp,$i);
							}} echo $temp ?>
								</td>
								<td class="numberStr">
									<?php $temp =  $tainan;
							if(strlen($temp)>3){
							for($i = strlen($temp)-3; $i>0 ;$i-=3){
								$temp = substr($temp,0,$i).".".substr($temp,$i);
							}} echo $temp; ?>
								</td>
								<?php $thuclanh = round(($tong -$yte -$xahoi -$tainan + ($cv2['phucap'] * $luongcoso)),-2); ?>
								<td class="numberStr">
									<?php $temp =  $thuclanh;
							if(strlen($temp)>3){
							for($i = strlen($temp)-3; $i>0 ;$i-=3){
								$temp = substr($temp,0,$i).".".substr($temp,$i);
							}} echo $temp; ?>
								</td>
							</tr>
							<?php
							}
							?>
						</table>
						<?php
						} else {
							?>
						<form action="" method="post">
							<a onClick="$('.btn-insert-salary').click();" class="btn-custom" style="margin-top: 50px;margin-bottom: 40px">Tạo lương tháng <?php echo $thang?> năm <?php echo $nam?></a>
							<input type="hidden" name="typeForm" value="insert-salary"/>
							<button type="submit" class="btn-insert-salary"/>
						</form>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
?>

<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer