<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
	<div class="main-navbar">
		<nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
			<a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
				<div class="d-table m-auto">
					<img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;" src="../images/shards-dashboards-logo.svg" alt="Shards Dashboard">
					<span class="d-none d-md-inline ml-1">Trang Quản Lý</span>
				</div>
			</a>
			<a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                <i class="material-icons">&#xE5C4;</i>
            </a>
		
		</nav>
	</div>
	<form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
		<div class="input-group input-group-seamless ml-3">
			<div class="input-group-prepend">
				<div class="input-group-text">
					<i class="fas fa-search"></i>
				</div>
			</div>
			<input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search"> </div>
	</form>
	<div class="nav-wrapper">
		<ul class="nav flex-column">
			<!--
            <li class="nav-item">
                <a class="nav-link active" href="index.php">
                    <i class="material-icons">view_module</i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-nhanvien.php">
                    <i class="material-icons">person</i>
                    <span>Nhân viên</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="admin-hoatdong.php">
                    <i class="material-icons">vertical_split</i>
                    <span>Hoạt động</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="admin-loaitin.php">
                    <i class="material-icons">view_module</i>
                    <span>Loại tin</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="admin-tintuc.php">
                    <i class="material-icons">view_module</i>
                    <span>Tin tức</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="admin-congviec.php">
                    <i class="material-icons">table_chart</i>
                    <span>Công việc</span>
                </a>
            </li>
            <?php
                if($_SESSION['quyen'] == 1)
                {
            ?>
                <li class="nav-item">
                    <a class="nav-link " href="admin-nguoidung.php">
                        <i class="material-icons">person</i>
                        <span>Người dùng</span>
                    </a>
                </li>
            <?php
                }
            ?>
            <li class="nav-item">
                <a class="nav-link " href="admin-bangcap.php">
                    <i class="material-icons">table_chart</i>
                    <span>Bằng Cấp</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="admin-phongban.php">
                    <i class="material-icons">table_chart</i>
                    <span>Phòng ban</span>
                </a>
            </li>
-->
			<style>
				@font-face {
					font-family: "Glyphicons Halflings";
					src: url("glyphicons-halflings-regular.eot");
					src: url("glyphicons-halflings-regular.eot?#iefix") format("embedded-opentype"), url("glyphicons-halflings-regular.woff2") format("woff2"), url("glyphicons-halflings-regular.woff") format("woff"), url("glyphicons-halflings-regular.ttf") format("truetype"), url("glyphicons-halflings-regular.svg#glyphicons_halflingsregular") format("svg");
				}
				
				.panel-heading {
					cursor: pointer;
					user-select: none;
					text-indent: 3px;
					transition: 0.3s ease;
				}
				
				.panel-heading:hover {
					background: darkgrey;
					color: white;
					box-shadow: 0 0 30px 0 rgba(158, 163, 167, 0.5);
				}
				
				.panel-heading[aria-expanded=true] {
					background: -webkit-linear-gradient(left, #66a7cf 5%, #66bcca);
					color: white;
					border-left: 6px solid skyblue;
					border-bottom-left-radius: initial;
					border-top-left-radius: initial;
					text-indent: 6px;
				}
				
				.panel-heading[aria-expanded=false] {
					color: black;
				}
				
				.cus-collapse-item {
					display: block;
					text-indent: 6px;
					color: black;
					text-decoration: none !important;
					position: relative;
					transition: 0.2s ease;
				}
				
				.cus-collapse-item:hover {
					color: white;
					background-color: skyblue;
				}
				
				.cus-collapse-item.cus-active:hover {
					color: white;
				}
				
				.cus-collapse-item.cus-active:hover:after {
					color: skyblue;
				}
				
				.cus-collapse-item.cus-active {
					text-indent: 12px;
					font-weight: 500;
					color: skyblue;
					z-index: 10;
					border-bottom: 1px solid skyblue !important;
					border-top: 1px solid skyblue;
					border-left: 1px solid skyblue;
					border-right: 1px solid skyblue;
				}
				.cus-collapse-item.cus-active:after {
					content: '\e092';
					position: absolute;
					top: 2px;
					right: 13%;
					font-family: "Glyphicons Halflings";
					line-height: 2;
					font-size: 15pt;
					-webkit-font-smoothing: antialiased;
					-webkit-text-stroke: 3px white;	
				}
				.parent-active{
					position: relative;
				}
				.parent-active.parent-selected:after {
					content: '\e092';
					position: absolute;
					top: 6px;
					right: 15%;
					font-family: "Glyphicons Halflings";
					line-height: 2;
					font-size: 15pt;
					color: white;
					-webkit-font-smoothing: antialiased;
					-webkit-text-stroke: 3px #66baca;
				}
			</style>
<!--
				//$( document ).ready( function () {
					
					$('.parent-active').on('click',function(){
						$(this).toggleClass('parent-selected');
					})
					$('#heading2 .parent-active').addClass('parent-selected');
					$('#heading2 .parent-active .panel-heading').attr('aria-expanded','true');
					
					
					$('#heading6 .panel-heading').attr('aria-expanded','true');
					$('#collapse6').addClass('show');
					$('#collapse6 .list-group a:nth-child(3)').addClass('cus-active');
				} );
-->
			<div class="panel-group" id="accordion">
				<div class="panel panel-default" id="heading0">
					<a href="#" class="parent-active" style="text-decoration: none; display: block;line-height: 2;color:black;background:#f5f5f5">
						<div class="panel-heading" data-toggle="collapse" data-target="#collapse0" aria-controls="collapse0">
							<div class="panel-title"><span class="glyphicon glyphicon-check" style="margin-right: 6px; top: 2px"></span> Quản trị hệ thống
							</div>
						</div>
					</a>
					<div id="collapse0" class="panel-collapse collapse" aria-labelledby="heading0" data-parent="#accordion">
					</div>
				</div>
				<div class="panel panel-default" id="heading1">
					<div class="panel-heading" data-toggle="collapse" data-target="#collapse1" aria-controls="collapse1">
						<h4 class="panel-title"><span class="glyphicon glyphicon-file" style="margin-right: 6px; top: 2px"></span> 
          Quản lý tin tức
        </h4>
					
					</div>
					<div id="collapse1" class="panel-collapse collapse" aria-labelledby="heading1" data-parent="#accordion">
						<ul class="list-group">
							<a class="list-group-item cus-collapse-item" href="admin-loaitin.php"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Loại tin</a>
							<a class="list-group-item cus-collapse-item" href="admin-hoatdong.php"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Hoạt động </a>
							<a class="list-group-item cus-collapse-item" href="admin-tintuc.php"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Tin tức </a>
						</ul>
					</div>
				</div>
				<div class="panel panel-default" id="heading2">
					<a href="#" class="parent-active" style="text-decoration: none; display: block;line-height: 2;color:black;background:#f5f5f5">
						<div class="panel-heading" data-toggle="collapse" data-target="#collapse2" aria-controls="collapse2">
							<div class="panel-title"><span class="glyphicon glyphicon-print" style="margin-right: 6px; top: 2px"></span> Quản lý thiết bị
							</div>
						</div>
					</a>
					<div id="collapse2" class="panel-collapse collapse" aria-labelledby="heading2" data-parent="#accordion">
					</div>
				</div>
				<div class="panel panel-default" id="heading3">
					<a href="admin-quanlyluong.php" class="parent-active" style="text-decoration: none; display: block;line-height: 2;color:black;background:#f5f5f5">
						<div class="panel-heading" data-toggle="collapse" data-target="#collapse3" aria-controls="collapse3">
							<div class="panel-title"><span class="glyphicon glyphicon-list-alt" style="margin-right: 6px; top: 2px"></span> Quản lý lương
							</div>
						</div>
					</a>
					<div id="collapse3" class="panel-collapse collapse" aria-labelledby="heading3" data-parent="#accordion">
					</div>
				</div>
				<div class="panel panel-default" id="heading4">
					<div class="panel-heading" data-toggle="collapse" data-target="#collapse4" aria-controls="collapse4">
						<h4 class="panel-title"><span class="glyphicon glyphicon-briefcase" style="margin-right: 6px; top: 2px"></span>
          Quản lý cấp dưỡng
        </h4>
					
					</div>
					<div id="collapse4" class="panel-collapse collapse" aria-labelledby="heading4" data-parent="#accordion">
						<ul class="list-group">
							<a class="list-group-item cus-collapse-item" href="#"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Lên menu</a>
							<a class="list-group-item cus-collapse-item" href="#"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Nhập nguyên liệu</a>
						</ul>
					</div>
				</div>
				<div class="panel panel-default" id="heading5">
					<div class="panel-heading" data-toggle="collapse" data-target="#collapse5" aria-controls="collapse5">
						<h4 class="panel-title"><span class="glyphicon glyphicon-education" style="margin-right: 6px; top: 2px"></span>
          Quản lý đào tạo 
        </h4>
					
					</div>
					<div id="collapse5" class="panel-collapse collapse" aria-labelledby="heading5" data-parent="#accordion">
						<ul class="list-group">
							<a class="list-group-item cus-collapse-item" href="#"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Quản lý bé</a>
							<a class="list-group-item cus-collapse-item" href="#"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Quản lý lớp</a>
							<a class="list-group-item cus-collapse-item" href="#"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Quản lý năm học</a>
							<a class="list-group-item cus-collapse-item" href="#"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Quản lý học phí</a>
						</ul>
					</div>
				</div>

				<div class="panel panel-default" id="heading6">
					<div class="panel-heading" data-toggle="collapse" data-target="#collapse6" aria-controls="collapse6">
						<h4 class="panel-title"><span class="glyphicon glyphicon-user" style="margin-right: 6px; top: 2px"></span>
          Quản lý hành chính
        </h4>
					
					</div>
					<div id="collapse6" class="panel-collapse collapse" aria-labelledby="heading6" data-parent="#accordion">
						<ul class="list-group">
							<a class="list-group-item cus-collapse-item" href="admin-nhanvien.php"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Quản lý nhân viên</a>
							<a class="list-group-item cus-collapse-item" href="admin-bangcap.php"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Bằng cấp</a>
							<a class="list-group-item cus-collapse-item" href="admin-congviec.php"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Chức vụ</a>
							<a class="list-group-item cus-collapse-item" href="admin-phongban.php"><span class="glyphicon glyphicon-menu-right" style="top: 0.5px;margin-right: 5px;font-size: 12px"></span>Phòng ban</a>
						</ul>
					</div>
				</div>
			</div>
		</ul>
	</div>
</aside>