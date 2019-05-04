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
<!-- Page content-->
<div class="main-content-container container-fluid px-4">
	<!-- Page Header -->
	<div class="page-header row no-gutters py-4">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">Quản lý</span>
			<h3 class="page-title">Đào tạo</h3>
		</div>
	</div>
	<!-- End Page Header -->

	<!-- Default Light Table -->
	<div class="row">
		<div class="col">
			<div class="card card-small mb-4" style="padding: 40px 60px">
				<div class="card-header">
					<h5 class="text-info">Thêm thông tin bé <i class="fas fa-child"></i></h5>
					<?php
					if (isset($_POST['btn-submit-be'])) {
						$errors = array();
						$have_dad = false;
						$have_mom = false;
						if ( empty( $_POST[ 'txtTenBe' ] ) ) {
							$errors[] = 'txtTenBe';
						} else {
							$name = $_POST[ 'txtTenBe' ];
						}
						if ( isset($_POST[ 'txtNgaySinh' ]) && empty( $_POST[ 'txtNgaySinh' ] ) ) {
							$errors[] = 'txtNgaySinh';
						} else {
							$ngaysinh = $_POST[ 'txtNgaySinh' ];
						}
						if ( empty( $_POST[ 'txtDiaChi' ] ) ) {
							$errors[] = 'txtDiaChi';
						} else {
							$diachi = $_POST[ 'txtDiaChi' ];
						}
						
						if(empty($_POST['temp-image-input'])){
							if($_FILES['hinhBe']['size'] == 0) {
								$errors[] = 'hinhBe';
								$mesErrorHinhBe = "Bạn chưa chọn ảnh bé";
							} else if ( ( $_FILES[ 'hinhBe' ][ 'type' ] != "image/gif" ) &&
										( $_FILES[ 'hinhBe' ][ 'type' ] != "image/png" ) &&
										( $_FILES[ 'hinhBe' ][ 'type' ] != "image/jpeg" ) &&
										( $_FILES[ 'hinhBe' ][ 'type' ] != "image/jpg" ) ) {
								if(!in_array('hinhBe',$errors))
									$errors[] = 'hinhBe';
								$mesErrorHinhBe = "File không đúng định dạnh";
							} else if ( $_FILES[ 'hinhBe' ][ 'size' ] > 1000000 ) {
								if(!in_array('hinhBe',$errors))
									$errors[] = 'hinhBe';
								$mesErrorHinhBe = "Kich thước phải nhỏ hơn 1MB";
							} else {	
								$temp_file = "../images/temp-image/".$_FILES[ 'hinhBe' ]['name'];
								copy($_FILES[ 'hinhBe' ]['tmp_name'],$temp_file);
							}
						}
						else{
							$temp_file = $_POST['temp-image-input'];
						}
						if(is_numeric($_POST[ 'txtChieuCao' ])){
							if($_POST[ 'txtChieuCao' ]<=0)
								$errors[] = 'txtChieuCao';
							else{
								$chieucao = $_POST[ 'txtChieuCao' ];
							}
						}
						else{
							$errors[] = 'txtChieuCao';
						}
						if(is_numeric($_POST[ 'txtCanNang' ])){
							if($_POST[ 'txtCanNang' ]<=0)
								$errors[] = 'txtCanNang';
							else{
								$cannang = $_POST[ 'txtCanNang' ];
							}
						}
						else{
							$errors[] = 'txtCanNang';
						}
						
						if ( !empty( $_POST[ 'txtTenCha' ]) || !empty( $_POST[ 'txtSDTCha' ] )){
							if ( empty( $_POST[ 'txtTenCha' ] ) ) {
								$errors[] = 'txtTenCha';
							} else {
								$tencha = $_POST[ 'txtTenCha' ];
							}	
							if ( is_numeric( $_POST[ 'txtSDTCha' ] ) ) {
								if ( strlen( $_POST[ 'txtSDTCha' ] ) != 10 )
									$errors[] = 'txtSDTCha2';
								else
									$sdtCha = $_POST[ 'txtSDTCha' ];
							} else {
								$errors[] = 'txtSDTCha';
							}
							if(isset($tencha) && isset($sdtCha)){
								$have_dad = true;
							}
						}	
						
						if ( !empty( $_POST[ 'txtTenMe' ]) || !empty( $_POST[ 'txtSDTMe' ] )){
							if ( empty( $_POST[ 'txtTenMe' ] ) ) {
								$errors[] = 'txtTenMe';
							} else {
								$tenme = $_POST[ 'txtTenMe' ];
							}
							if ( is_numeric( $_POST[ 'txtSDTMe' ] ) ) {
								if ( strlen( $_POST[ 'txtSDTMe' ] ) != 10 )
									$errors[] = 'txtSDTMe2';
								else
									$sdtMe = $_POST[ 'txtSDTMe' ];
							} else {
								$errors[] = 'txtSDTMe';
							}
							if(isset($tenme) && isset($sdtMe)){
								$have_mom = true;
							}
						}	
						if(!$have_dad && !$have_mom){
							$errors[] = 'parents';
						}
						if ( empty( $errors )) {
							if(!$have_dad){
								$tencha = '';
								$sdtCha = '';
							}
							if(!$have_mom){
								$tenme = '';
								$sdtMe = '';
							}
							$tinhtrangsuckhoe = $_POST['txtSucKhoe'];
							$benh = $_POST['txtBenhBS'];
							$gioitinh = $_POST[ 'slGioiTinh' ];
							$trangthai = 1;
							$fileName = randomDigitsLame(4).'_'.randomDigitsLame(14).substr($temp_file,strrpos($temp_file, '.', -0));
							copy($temp_file,"../images/hinhbe/".$fileName);
							$query_tt = "INSERT INTO be(ten, ngaysinh, gioitinh, chieucao, cannang, diachi, tinhtrangsuckhoe, benhbamsinh ,hinhbe , tencha, sdtcha, tenme, sdtme, trangthai) VALUES('{$name}','{$ngaysinh}',{$gioitinh},'{$chieucao}','{$cannang}','{$diachi}','{$tinhtrangsuckhoe}','{$benh}','{$fileName}','{$tencha}','{$sdtCha}','{$tenme}','{$sdtMe}',$trangthai) ";
							$results_tt = mysqli_query( $dbc, $query_tt );
							if ( mysqli_affected_rows( $dbc ) == 1 ) {
								?>
					<script>
						alert( "Thêm thành công" );
						window.location = "admin-be.php?btnSeach=&searchKey="+"<?php echo $name?>";
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
					<form action="" method="post" enctype="multipart/form-data" style="margin-top: 30px">
						<script>
							function showPreview( objFileInput ) {
								var filename = objFileInput.value.split('.').pop().toLowerCase();
								var fileTypes = ['jpg', 'jpeg', 'png', 'gif'];
								isValid = fileTypes.indexOf(filename) > -1;
								if (isValid) {
								//if ( objFileInput.files[ 0 ] ) {
									var fileReader = new FileReader();
									fileReader.onload = function ( e ) {
										$( "#targetLayer" ).addClass( 'have-photo' );
										$( "#targetLayer" ).css( 'background-image', 'url("' + e.target.result + '")' );
										sessionStorage.setItem('have-photo',e.target.result);
										$( '#targetLayer .glyphicon' ).fadeOut();
										$('input[name="temp-image-input"]').val('');
									}
									fileReader.readAsDataURL( objFileInput.files[ 0 ] );
								}
							};
							function loadPhoto(url){
								$( "#targetLayer" ).addClass( 'have-photo' );
								$( "#targetLayer" ).css( 'background-image', 'url("' + url + '")' );
								$( '#targetLayer .glyphicon' ).fadeOut();
							}
						</script>
						<style>
							#targetLayer {
								width: 250px;
								height: 320px;
								margin: 20px auto 0 auto;
								border: 5px solid skyblue;
								border-radius: 9px;
								background-repeat: no-repeat;
								background-position: center;
								background-size: cover;
								background-color: #f4f5f757;
								position: relative;
							}
							
							#targetLayer .glyphicon {
								position: absolute;
								top: 108px;
								left: 75px;
								font-size: 65pt;
								text-align: center;
								color: white;
								cursor: pointer;
								text-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
								transform-origin-x: center;
								-webkit-transform-origin-x: center;
							}
							
							#targetLayer .glyphicon:hover {
								transform: scale(1.02);
								text-shadow: 0 1px 6px rgba(0, 0, 0, 0.5);
							}
							
							#targetLayer button:active .glyphicon {
								transform: scale(.98);
							}
							
							#targetLayer .input {
								position: absolute;
								top: 100px;
								left: 66px;
								width: 60px;
								height: 60px;
								overflow: hidden;
								opacity: 0;
							}
							
							#targetLayer input {
								display: none;
							}
							
							.dot-required {
								color: red;
							}
							
							.parent-zone {
								margin: 35px -30px 15px -30px;
								padding: 30px 15px 10px 15px;
								border-radius: 5px;
								box-shadow: 0 .5px 4px rgba(0,0,0,0.2);
								position: relative;								
								background-color: #f4f5f757;
							}
							.parent-zone .title-absolute span{
								position: absolute;
								top: -16px;
								left: 15px;
								background: white;
								color: skyblue;
								text-transform: uppercase;
								padding: 4px 10px;
								font-size: 14px;
								font-weight: 500;
/*								border-radius: 3px;*/
								border: 2px solid skyblue;
/*								box-shadow: 0 .5px 2px rgba(0,0,0,.3);*/
							}
							.footer-detail{
								float: right;
								color: dimgray;
								font-size: 11px;
							}
						</style>
						<div class="row">							
							<div class="col-8">
								<div class="form-group">
									<label>Họ và tên bé <span class="dot-required">*</span></label>
									<input class="form-control" name="txtTenBe" placeholder="Vui lòng nhập tên bé" value="<?php if(isset($_POST['txtTenBe'])) {echo $_POST['txtTenBe'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtTenBe',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên bé</p>";
                                }
                            ?>
								</div>
								<div class="form-group">
									<label>Ngày sinh <span class="dot-required">*</span></label>
									<input type="date" class="form-control" name="txtNgaySinh" placeholder="Vui lòng nhập ngày sinh" value="<?php if(isset($_POST['txtNgaySinh'])) {echo $_POST['txtNgaySinh'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtNgaySinh',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập ngày sinh bé</p>";
                                }
									?>
								</div>
								<div class="form-group">
									<label>Giới tính  <span class="dot-required">*</span></label>
									<select class="form-control" name="slGioiTinh">
										<option value="1">Nam</option>
										<option value="2">Nữ</option>
									</select>
								</div>
								<div class="form-group">
									<label>Chiều cao(cm) <span class="dot-required">*</span></label>
									<input class="form-control" name="txtChieuCao" placeholder="Vui lòng nhập chiều cao của bé" value="<?php if(isset($_POST['txtChieuCao'])) {echo $_POST['txtChieuCao'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtChieuCao',$errors))
                                {
                                    echo "<p class='text-danger'>Chiều cao bé không hợp lệ</p>";
                                }
                            ?>
								</div>
								<div class="form-group">
									<label>Cân nặng(kg) <span class="dot-required">*</span></label>
									<input class="form-control" name="txtCanNang" placeholder="Vui lòng nhập cân nặng của bé" value="<?php if(isset($_POST['txtCanNang'])) {echo $_POST['txtCanNang'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtCanNang',$errors))
                                {
                                    echo "<p class='text-danger'>Cân nặng bé không hợp lệ</p>";
                                }
                            ?>
								</div>
							</div>
							<div class="col" style="margin-right: -25px">
								<div>
									<div id="targetLayer"><button type="button"><span class="glyphicon glyphicon-picture"></button>
										</span><input type="file" id="hinhBe" name="hinhBe" onChange="showPreview(this);"> </div>
<?php if(isset($temp_file) && !empty($temp_file)) echo '<script>loadPhoto(sessionStorage.getItem("have-photo"));</script>'?>
									<input type="hidden" name='temp-image-input' value="<?php if(isset($temp_file) && !empty($temp_file)) echo $temp_file; else echo '';?>"/>
									<p class='text-danger' style="margin: 5% auto 0 auto; display: <?php if(isset($errors) && in_array('hinhBe',$errors)) echo 'table'; else echo 'none';?>"><?php if(isset($errors) && in_array('hinhBe',$errors)) echo $mesErrorHinhBe; ?></p>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label>Địa chỉ <span class="dot-required">*</span></label>
							<input class="form-control" name="txtDiaChi" placeholder="Vui lòng nhập địa chỉ" value="<?php if(isset($_POST['txtDiaChi'])) {echo $_POST['txtDiaChi'];} ?>">
							<?php 
                                if(isset($errors) && in_array('txtDiaChi',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập địa chỉ</p>";
                                }
                            ?>
						</div>
						<div class="form-group">
							<label>Tình trạng sức khoẻ</label>
							<textarea rows="3" class="form-control" name="txtSucKhoe" placeholder="Vui lòng nhập tình trạng sức khoẻ"><?php if(isset($_POST['txtSucKhoe'])) {echo $_POST['txtSucKhoe'];}?></textarea>
						</div>
						<div class="form-group">
							<label>Bệnh bẩm sinh(nếu có)</label>
							<textarea rows="3" class="form-control" name="txtBenhBS" placeholder="Vui lòng nhập bệnh bẩm sinh"><?php if(isset($_POST['txtBenhBS'])) {echo $_POST['txtBenhBS'];} ?></textarea>
						</div>
						<div class="row parent-zone">
							<div class="title-absolute"><span>Thông tin phụ huynh</span></div>
							<div class="col">
								<div class="form-group">
									<label>Tên cha</label>
									<input class="form-control" name="txtTenCha" placeholder="Vui lòng nhập tên cha" value="<?php if(isset($_POST['txtTenCha'])) {echo $_POST['txtTenCha'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtTenCha',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên cha</p>";
                                }
                            ?>
								</div>
								<div class="form-group">
									<label>Số điện thoại cha</label>
									<input class="form-control" name="txtSDTCha" placeholder="Vui lòng nhập số điện thoại cha" value="<?php if(isset($_POST['txtSDTCha'])) {echo $_POST['txtSDTCha'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtSDTCha',$errors))
                                {
                                    echo "<p class='text-danger'>Vui lòng nhập số điện thoại cha</p>";
                                }
								if(isset($errors) && in_array('txtSDTCha2',$errors))
                                {
                                    echo "<p class='text-danger'>Số điện thoại hợp lệ có 10 số</p>";
                                }
                                ?>
								</div>
								<?php
								if(isset($errors) && in_array('parents',$errors))
                                {
                                    echo "<div class='footer-detail text-danger' style='float:left;font-size:13px;'><span>Bắt buộc phải nhập cha hoặc mẹ</span></div>";
                                }?>	
							</div>
							<div class="col">
								<div class="form-group">
									<label>Tên mẹ</label>
									<input class="form-control" name="txtTenMe" placeholder="Vui lòng nhập tên mẹ" value="<?php if(isset($_POST['txtTenMe'])) {echo $_POST['txtTenMe'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtTenMe',$errors))
                                {
                                    echo "<p class='text-danger'>Bạn chưa nhập tên mẹ</p>";
                                }
                            ?>
								</div>
								<div class="form-group" style="margin-bottom: 7px;">
									<label>Số điện thoại mẹ</label>
									<input class="form-control" name="txtSDTMe" placeholder="Vui lòng nhập số điện thoại mẹ" value="<?php if(isset($_POST['txtSDTMe'])) {echo $_POST['txtSDTMe'];} ?>">
									<?php 
                                if(isset($errors) && in_array('txtSDTMe',$errors))
                                {
                                    echo "<p class='text-danger'>Vui lòng nhập số điện thoại mẹ</p>";
                                }
								if(isset($errors) && in_array('txtSDTMe2',$errors))
                                {
                                    echo "<p class='text-danger'>Số điện thoại hợp lệ có 10 số</p>";
                                }
                                ?>
								</div>															
								<div class="footer-detail"><span>* Cho phép chỉ nhập cha hoặc mẹ</span></div>
							</div>
						</div>
						<br/>
						<button name="btn-submit-be" type="submit" class="btn btn-info">Thêm Thông Tin</button>
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