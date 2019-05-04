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
<!-- Page content-->
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Dashboard</span>
			<h3 class="page-title">Nhân Viên</h3>
		</div>
	</div>
	<!-- End Page Header -->

	<!-- Default Light Table -->
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4">
				<div class="card-header border-bottom">
					<h5 class="text-info">Thêm nhân viên</h5>
					<?php
					if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
						$errors = array();
						if ( empty( $_POST[ 'txtTenNhanVien' ] ) ) {
							$errors[] = 'txtTenNhanVien';
						} else {
							$name = $_POST[ 'txtTenNhanVien' ];
						}
						if ( empty( $_POST[ 'bangcap' ] ) ) {
							$errors[] = 'bangcap';
						} else {
							$bangcap = '';
							$count = count( $_POST[ 'bangcap' ] );
							$i = 1;
							foreach ( $_POST[ 'bangcap' ] as $names ) {
								if ( $count > $i )
									$bangcap = $bangcap . $names . ",";
								else
									$bangcap = $bangcap . $names;
								$i++;
							}
						}
						if ( empty( $_POST[ 'chucvu' ] ) ) {
							$errors[] = 'chucvu';
						} else {
							$chucvu = $_POST[ 'chucvu' ];
						}
						if ( empty( $_POST[ 'phongban' ] ) ) {
							$errors[] = 'phongban';
						} else {
							$phongban = $_POST[ 'phongban' ];
						}
						if ( is_numeric( $_POST[ 'txtSoDienThoai' ] ) ) {
							if(strlen($_POST[ 'txtSoDienThoai' ]) != 10)
								$errors[] = 'txtSoDienThoai2';
							else
								$dienthoai = $_POST[ 'txtSoDienThoai' ];
						} else {
							$errors[] = 'txtSoDienThoai';
						}
						if ( is_numeric( $_POST[ 'txtCMND' ] ) ) {
							if(strlen($_POST[ 'txtCMND' ]) != 9)
								$errors[] = 'txtCMND2';
							else
								$cmnd = $_POST[ 'txtCMND' ];
						} else {
							$errors[] = 'txtCMND';
						}
						$mucluong = str_replace('.', '', $_POST[ 'txtMucLuong' ]);
						$heso = $_POST[ 'txtHeSo' ];
						$email = $_POST[ 'txtEmail' ];
						$diachi = $_POST[ 'txtDiaChi' ];
						$gioitinh = $_POST[ 'slGioiTinh' ];
						$ngayvaolam = $_POST[ 'txtNgayVaoLam' ];
						$ngaysinh = $_POST[ 'txtNgaySinh' ];
						$noisinh = $_POST[ 'txtNoiSinh' ];
						$trangthai = 1;
						if ( empty( $errors ) ) {
							//INSERT VÀO DATABASE
							$query_tt = "INSERT INTO nhanvien(ho_ten, gioi_tinh, dien_thoai, email, ngay_sinh, noi_sinh, cmnd, dia_chi, bang_cap_id, phong_ban_id, ngay_vao_lam, muc_luong_cb, he_so, cong_viec_id, trangthai) VALUES('{$name}',{$gioitinh}, '{$dienthoai}','{$email}','{$ngaysinh}', '{$noisinh}', '{$cmnd}', '{$diachi}', '$bangcap', $phongban,  '{$ngayvaolam}', $mucluong, $heso, $chucvu, $trangthai) ";
							$results_tt = mysqli_query( $dbc, $query_tt );
							if ( mysqli_affected_rows( $dbc ) == 1 ) {
								?>
					<script>
						alert( "thêm thành công" );
						window.location = "admin-nhanvien.php";
					</script>
					<?php
					} else {
						echo "<script>";
						echo 'alert("Thêm không thành công")';
						echo "</script>";
					}
					} else {
						$message = "<p class='text-danger'>Bạn hãy nhập đầy đủ thông tin</p>";
					}
					}
					if ( isset( $message ) ) {
						echo $message;
					}
					?>
					<form action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>Tên nhân viên <span class="dot-required">*</span></label>
							<input class="form-control" name="txtTenNhanVien" placeholder="Vui lòng nhập tên nhân viên" value="<?php if(isset($_POST['txtTenNhanVien'])) {echo $_POST['txtTenNhanVien'];} ?>">
							<?php 
                                if(isset($errors) && in_array('txtTenNhanVien',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên nhân viên</p>";
                                }
                            ?>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="txtEmail" placeholder="Vui lòng nhập Email" value="<?php if(isset($_POST['txtEmail'])) {echo $_POST['txtEmail'];} ?>">
						</div>
						<div class="form-group">
							<label>Địa chỉ</label>
							<input class="form-control" name="txtDiaChi" placeholder="Vui lòng nhập địa chỉ" value="<?php if(isset($_POST['txtDiaChi'])) {echo $_POST['txtDiaChi'];} ?>">
						</div>
						<div class="form-group">
							<label>Nơi Sinh</label>
							<input class="form-control" name="txtNoiSinh" placeholder="Vui lòng nhập nơi sinh" value="<?php if(isset($_POST['txtNoiSinh'])) {echo $_POST['txtNoiSinh'];} ?>">
						</div>
						<div class="form-group">
							<label style="display:block">Chức vụ <span class="dot-required">*</span></label>
							<select class="form-control" name="chucvu">
								<option value="">Vui lòng chọn chức vụ</option>
								<?php 
                                    $query_cv="SELECT * FROM congviec";
                                    $cvs=mysqli_query($dbc,$query_cv);
                                    foreach ($cvs as $item) {
                                ?>
								<option <?php if(isset($_POST['chucvu']) && $_POST['chucvu'] == $item['congviec_id']) {echo 'selected="selected"';}?> value="<?php echo $item['congviec_id']?>">
									<?php echo $item['ten_cong_viec'] ?>
								</option>
								<?php
								}
								?>
							</select>
							<?php
							if ( isset( $errors ) && in_array( 'chucvu', $errors ) ) {
								echo "<p class='text-danger'>Bạn chưa chọn chức vụ</p>";
							}
							?>
						</div>
						<div class="row">
							<div class="col">
								<label>CMND <span class="dot-required">*</span></label>
								<input class="form-control" name="txtCMND" placeholder="Vui lòng nhập số chứng minh nhân dân" value="<?php if(isset($_POST['txtCMND'])) {echo $_POST['txtCMND'];} ?>">
								<?php 
                                if(isset($errors) && in_array('txtCMND',$errors))
                                {
                                    echo "<p class='text-danger'>Vui lòng nhập số CMND</p>";
                                }
								if(isset($errors) && in_array('txtCMND2',$errors))
                                {
                                    echo "<p class='text-danger'>Số CMND hợp lệ có 9 số</p>";
                                }
                                ?>
							</div>
							<div class="col">
								<label>Ngày Sinh</label>
								<input type="date" class="form-control" name="txtNgaySinh" placeholder="Vui lòng nhập ngày sinh" value="<?php if(isset($_POST['txtNgaySinh'])) {echo $_POST['txtNgaySinh'];} ?>">
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col">
								<label>Số điện thoại <span class="dot-required">*</span></label>
								<input class="form-control" name="txtSoDienThoai" placeholder="Vui lòng nhập số điện thoại" value="<?php if(isset($_POST['txtSoDienThoai'])) {echo $_POST['txtSoDienThoai'];} ?>">
								<?php 
                                if(isset($errors) && in_array('txtSoDienThoai',$errors))
                                {
                                    echo "<p class='text-danger'>Vui lòng nhập số điện thoại</p>";
                                }
								if(isset($errors) && in_array('txtSoDienThoai2',$errors))
                                {
                                    echo "<p class='text-danger'>Số điện thoại hợp lệ có 10 số</p>";
                                }
                                ?>
							</div>
							<div class="col">
								<label>Giới tính</label>
								<select class="form-control" name="slGioiTinh">
									<option value="1">Nam</option>
									<option value="2">Nữ</option>
								</select>
							</div>
						</div>
						<br/>
						<div class="row">
							<style>
								.dot-required {
									color: red;
								}
								
								.select2-selection--multiple {
									border: 1px solid #e1e5eb !important;
								}
								
								.select2-results__option[aria-selected=true] {
									position: relative;
								}
								
								.select2-results__option[aria-selected=true]::after {
									content: '\e013';
									position: absolute;
									top: 9px;
									right: 5%;
									font-family: "Glyphicons Halflings";
									line-height: 1;
									font-size: 13px;
									-webkit-font-smoothing: antialiased;
									color: #09ab09
								}
								
								.select2-selection__choice {
									background-color: #66b2cc !important;
									border: 1px solid #66b2cc !important;
									color: white
								}
								
								.select2-selection__choice__remove:hover {
									color: #ddd !important;
								}
								
								.select2-selection__choice__remove {
									color: white !important;
									padding-right: 1px;
								}
							</style>

							<div class="col">
								<label>Ngày vào làm</label>
								<input type="date" class="form-control" name="txtNgayVaoLam" placeholder="Vui lòng nhập ngày vào làm" value="<?php if(isset($_POST['txtNgayVaoLam'])) {echo $_POST['txtNgayVaoLam'];} ?>">
							</div>
							<!--
                            <div class="col">
                                <label style="display:block">Bằng cấp <span class="dot-required">*</span></label>
                                <select class="form-control" name="bangcap">
                                <option value="">Vui Lòng Chọn Bằng Cấp</option>
                                <?php 
                                    //$query_bc="SELECT * FROM bangcap";
                                    //$bcs=mysqli_query($dbc,$query_bc);
                                    //foreach ($bcs as $item) {
                                ?> 
                                    <option value="<?php //echo $item['bang_cap_id']?>"><?php //echo $item['ten_bang_cap'] ?></option>
                                <?php
                                    //} 
                                ?>
                                </select>
                                <?php
                                    //if(isset($errors) && in_array('bangcap',$errors))
                                    //{
                                        //echo "<p class='text-danger'>Bạn chưa chọn bằng cấp</p>";
                                    //}
                                ?>
                            </div>
-->
							<div class="col">
								<label style="display:block">Phòng ban <span class="dot-required">*</span></label>
								<select class="form-control" name="phongban">
									<option value="">Vui lòng chọn phòng ban</option>
									<?php 
                                    $query_pb="SELECT * FROM phongban";
                                    $pbs=mysqli_query($dbc,$query_pb);
                                    foreach ($pbs as $item) {
                                ?>
									<option <?php if(isset($_POST['phongban']) && $_POST['phongban'] == $item['phong_ban_id']) {echo 'selected="selected"';}?> value="<?php echo $item['phong_ban_id']?>">
										<?php echo $item['ten_phong_ban'] ?>
									</option>
									<?php 
                                    }
                                ?>
								</select>
								<?php
								if ( isset( $errors ) && in_array( 'phongban', $errors ) ) {
									echo "<p class='text-danger'>Bạn chưa chọn phòng ban</p>";
								}
								?>
							</div>
						</div>
						<br/>
						<div class="row">
							<script>
								function changeBangCap() {
									var id = $( '.cus-selected' ).val();
									if ( id != "" ) {
										$.ajax( {
											type: "GET",
											url: "getMucLuong.php?bangcapid=" + id,
											success: function ( result ) {
												$( "input[name='txtMucLuong']" ).val( result * Number($('.salary-hidden').val()) );
												$( "input[name='txtHeSo']" ).val( result );
												if ( $( "input[name='txtMucLuong']" ).val().length > 3 ) {
													$( "input[name='txtMucLuong']" ).val( parseInt( $( "input[name='txtMucLuong']" ).val() ).toLocaleString( 'vi-VN' ) );
												}
											}
										} );
									} else {
										$( "input[name='txtMucLuong']" ).val( '0' );
										$( "input[name='txtHeSo']" ).val( '0' );
									}
								};
							</script>
							<div class="col">
								<label style="display:block">Bằng cấp <span class="dot-required">*</span></label>
								<select multiple="multiple" class="form-control cus-selected" name="bangcap[]" onChange="changeBangCap();">
									<?php 
                                    $query_bc="SELECT * FROM bangcap";
                                    $bcs=mysqli_query($dbc,$query_bc);
                                    foreach ($bcs as $item) {
                                ?>
									<option <?php if(isset($_POST['bangcap']) && in_array($item['bang_cap_id'],$_POST['bangcap'])) {echo 'selected="selected"';}?> value="<?php echo $item['bang_cap_id']?>">
										<?php echo $item['ten_bang_cap'] ?>
									</option>
									<?php
									}
									?>
								</select>
								<?php
								if ( isset( $errors ) && in_array( 'bangcap', $errors ) ) {
									echo "<p class='text-danger'>Bạn chưa chọn bằng cấp</p>";
								}
								?>
								<input type="hidden" class="salary-hidden" value="<?php
							$slr = mysqli_fetch_assoc( mysqli_query( $dbc, 
		"select mucluong from luongcoso" ));
									echo $slr['mucluong']?>"/>
							</div>
							<div class="col">
								<label>Mức lương cơ bản <span class="dot-required" style="font-size: 10px">(vnd)</span></label>
								<input readonly class="form-control" name="txtMucLuong" placeholder="0" value="<?php if(isset($_POST['txtMucLuong'])) {echo $_POST['txtMucLuong'];} ?>">
							</div>
							<div class="col">
								<label>Hệ số </label>
								<input readonly class="form-control" name="txtHeSo" placeholder="0" value="<?php if(isset($_POST['txtHeSo'])) {echo $_POST['txtHeSo'];} ?>">
							</div>
						</div>
						<br/>
						<br/>
						<button type="submit" class="btn btn-info">Thêm Thông Tin</button>
					</form>
				</div>
				<!-- End thêm loại tin -->
			</div>
		</div>
	</div>
	<!-- End Default Light Table -->
</div>
<!-- End page content-->
<!-- Footer-->
<?php include "admin-footer.php";?>
<!-- End footer