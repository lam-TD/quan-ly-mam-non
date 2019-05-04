<?php include "admin-header.php";?>
<?php include "../../inc/myconnect.php";?>
<?php include "../../inc/myfunction.php";?>

<!-- End header-->
<script>
		$( document ).ready( function () {
					$('#heading6 .panel-heading').attr('aria-expanded','true');
					$('#collapse6').addClass('show');
					$('#collapse6 .list-group a:nth-child(1)').addClass('cus-active');
		});
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
				<?php
				//Kiểm tra ID có phải là kiểu số không, filter_var kiem tra có thuộc tính trim sẽ loại bỏ khoảng trắng
				if ( isset( $_GET[ 'id' ] ) && filter_var( $_GET[ 'id' ], FILTER_VALIDATE_INT, array( 'min_range' => 1 ) ) ) {
					$id = $_GET[ 'id' ];					
					$query_id = "SELECT * FROM nhanvien WHERE id={$id}";
					$result_id = mysqli_query( $dbc, $query_id );
					//Kiểm tra xem ID có tồn tại không
					if ( mysqli_num_rows( $result_id ) == 1 ) {
						list( $id, $name, $gioitinh, $dienthoai, $email, $ngaysinh, $noisinh, $cmnd, $diachi, $bangcap, $phongban, $ngayvaolam, $mucluong, $heso, $chucvu ) = mysqli_fetch_array( $result_id, MYSQLI_NUM );
						if(strlen($mucluong)>3){
							for($i = strlen($mucluong)-3; $i>0 ;$i-=3){
								$mucluong = substr($mucluong,0,$i).".".substr($mucluong,$i);
							}
						}						
					} else {
						$message = "<p class='required'>ID không tồn tại</p>";
					}
					if ( isset( $message ) ) {
						echo $message;
					}
				} else {
					header( 'Location: admin-nhanvien.php' );
					exit();
				}
				?>
				<nav class="navbar navbar-expand-lg navbar-light bg-light ">
					<!-- Links -->
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="admin-hopdong.php?id=<?php echo $id ?>">Hợp Đồng</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="admin-congtac.php?id=<?php echo $id ?>">Công Tác</a>
						</li>
					</ul>
				</nav>
				<div class="card-header border-bottom">
					<h5 class="text-info">Xem thông tin nhân viên</h5>
				
					<?php
					if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
						$errors = array();
						$errors = array();
						if ( empty( $_POST[ 'txtTenNhanVien' ] ) ) {
							$errors[] = 'txtTenNhanVien';
						} else {
							$name = $_POST[ 'txtTenNhanVien' ];
						}
						if ( empty( $_POST[ 'bangcap' ] ) ) {
							$errors[] = 'bangcap';
							$bangcap = '';
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
							$chucvu = '';
						} else {
							$chucvu = $_POST[ 'chucvu' ];
						}
						if ( empty( $_POST[ 'phongban' ] ) ) {
							$errors[] = 'phongban';
							$phongban = '';
						} else {
							$phongban = $_POST[ 'phongban' ];
						}
						if ( is_numeric( $_POST[ 'txtSoDienThoai' ] ) ) {
							if(strlen($_POST[ 'txtSoDienThoai' ]) != 10)
								$errors[] = 'txtSoDienThoai2';
							$dienthoai = $_POST[ 'txtSoDienThoai' ];
						} else {
							$errors[] = 'txtSoDienThoai';
						}
						if ( is_numeric( $_POST[ 'txtCMND' ] ) ) {
							if(strlen($_POST[ 'txtCMND' ]) != 9)
								$errors[] = 'txtCMND2';
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
						if ( empty( $errors ) ) {
							//INSERT VÀO DATABASE
							$query_tt = "UPDATE nhanvien 
                                			  SET ho_ten = '{$name}',
                                			  	  gioi_tinh = $gioitinh,
                                			  	  dien_thoai = $dienthoai,
                                			  	  email  = '{$email}',
                                			  	  ngay_sinh = '{$ngaysinh}',
                                			  	  noi_sinh = '{$noisinh}',
                                			  	  cmnd = $cmnd,
                                			  	  dia_chi = '{$diachi}',
                                			  	  bang_cap_id = '$bangcap',
                                			  	  phong_ban_id = $phongban,
                                			  	  ngay_vao_lam	= '{$ngayvaolam}',
                                			  	  muc_luong_cb = $mucluong,
                                			  	  he_so		= $heso,
                                                  cong_viec_id = $chucvu
                                			  WHERE id = $id";
							$results_tt = mysqli_query( $dbc, $query_tt );
							if ( mysqli_affected_rows( $dbc ) == 1 ) {
								?>
					<script>
						alert( "Lưu thành công" );
						window.location = "admin-nhanvien.php";
					</script>
					<?php
					} else {
						echo "<script>";
						echo 'alert("Sửa không thành công")';
						echo "</script>";
					}
					} else {
						$message = "<p class='text-danger'>Bạn hãy nhập đầy đủ thông tin</p>";
					}
					}
					?>
					<form action="" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<label>Tên nhân viên <span class="dot-required">*</span></label>
							<input class="form-control" name="txtTenNhanVien" placeholder="Vui lòng nhập tên nhân viên" value="<?php if(isset($name)) {echo $name;} ?>">
							<?php 
                                if(isset($errors) && in_array('txtTenNhanVien',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên nhân viên</p>";
                                }
                            ?>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="txtEmail" placeholder="Vui lòng nhập Email" value="<?php if(isset($email)) {echo $email;} ?>">
						</div>
						<div class="form-group">
							<label>Địa chỉ</label>
							<input class="form-control" name="txtDiaChi" placeholder="Vui lòng nhập địa chỉ" value="<?php if(isset($diachi)) {echo $diachi;} ?>">
						</div>
						<div class="form-group">
							<label>Nơi Sinh</label>
							<input class="form-control" name="txtNoiSinh" placeholder="Vui lòng nhập nơi sinh" value="<?php if(isset($noisinh)) {echo $noisinh;} ?>">
						</div>
						<div class="form-group">
							<label style="display:block">Chức vụ <span class="dot-required">*</span></label>
							<select class="form-control" name="chucvu">
								<option value="">Vui lòng chọn chức vụ</option>
								<?php 
                                    $query_cv="SELECT * FROM congviec";
                                    $cvs=mysqli_query($dbc,$query_cv);
                                    foreach ($cvs as $item) 
                                    {
                                        if($chucvu == $item['congviec_id'])
                                        {
                                    ?>
								<option <?php echo 'selected = "selected"'; ?> value="
									<?php echo $item['congviec_id']?>">
									<?php echo $item['ten_cong_viec'] ?>
								</option>
								<?php
								} else {
									?>
								<option value="<?php echo $item['congviec_id']?>">
									<?php echo $item['ten_cong_viec'] ?>
								</option>
								<?php
								}
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
								<input class="form-control" name="txtCMND" placeholder="Vui lòng nhập số chứng minh nhân dân" value="<?php if(isset($cmnd)) {echo $cmnd;} ?>">
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
								<input type="date" class="form-control" name="txtNgaySinh" placeholder="Vui lòng nhập ngày sinh" value="<?php if(isset($ngaysinh)) {echo $ngaysinh;} ?>">
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="col">
								<label>Số điện thoại <span class="dot-required">*</span></label>
								<input class="form-control" name="txtSoDienThoai" placeholder="Vui lòng nhập số điện thoại" value="<?php if(isset($dienthoai)) {echo $dienthoai;} ?>">
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
									<option <?php if(isset($gioitinh) && $gioitinh==1 ) {echo 'selected = "selected"';} ?> value="1">Nam</option>
									<option <?php if(isset($gioitinh) && $gioitinh==2 ) {echo "selected = 'selected'";} ?> value="2">Nữ</option>
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
								<input type="date" class="form-control" name="txtNgayVaoLam" placeholder="Vui lòng nhập ngày vào làm" value="<?php if(isset($ngayvaolam)) {echo $ngayvaolam;} ?>">
							</div>
							<div class="col">
								<label style="display:block">Phòng ban <span class="dot-required">*</span></label>
								<select class="form-control" name="phongban">
									<option value="">Vui lòng chọn phòng ban</option>
									<?php 
                                    $query_pb="SELECT * FROM phongban";
                                    $pbs=mysqli_query($dbc,$query_pb);
                                    foreach ($pbs as $item) 
                                    {
                                    	if($phongban == $item['phong_ban_id'])
                               			{
                               		?>
									<option <?php echo 'selected = "selected"'; ?> value="
										<?php echo $item['phong_ban_id']?>">
										<?php echo $item['ten_phong_ban'] ?>
									</option>
									<?php
									} else {
										?>
									<option value="<?php echo $item['phong_ban_id']?>">
										<?php echo $item['ten_phong_ban'] ?>
									</option>
									<?php
									}
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
										console.log("getMucLuong.php?bangcapid=" + id);
										console.log('hihi'+id);
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
								<select multiple="multiple" class="form-control cus-selected" name="bangcap[]"
										onChange="changeBangCap();">
									<?php 
                                    $query_bc="SELECT * FROM bangcap";
                                    $bcs=mysqli_query($dbc,$query_bc);
									//$query_bc_selected="SELECT bang_cap_id FROM nhanvien where id = ";
                                    //$bc_selected= mysqli_query($dbc,$query_bc_selected);
									$listbangcap = explode(",",$bangcap);
									//echo ('<script>alert("aaaa'.$listbangcap(1).'");</script>');
									
										foreach ($bcs as $item) 
                                    {
                               			if(in_array($item['bang_cap_id'],$listbangcap))
                               			{
                               		?>
									<option <?php echo 'selected = "selected"'; ?> value="
										<?php echo $item['bang_cap_id']?>">
										<?php echo $item['ten_bang_cap'] ?>
									</option>
									<?php
									} else {
										?>
									<option value="<?php echo $item['bang_cap_id']?>">
										<?php echo $item['ten_bang_cap'] ?>
									</option>
									<?php
									}
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
								<input readonly  class="form-control" name="txtMucLuong" placeholder="Vui lòng nhập mức lương cơ bản" value="<?php if(isset($mucluong)) {echo $mucluong;}?>">
							</div>
							<div class="col">
								<label>Hệ số </label>
								<input readonly class="form-control" name="txtHeSo" placeholder="Vui lòng nhập hệ số lương" value="<?php if(isset($heso)) {echo $heso;} ?>">
							</div>
						</div>
						<br/>
						<br/>
						<button type="submit" class="btn btn-info">Lưu</button>
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