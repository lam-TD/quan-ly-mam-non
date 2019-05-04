<?php include "header.php" ?>
<?php
//Kiểm tra ID có phải là kiểu số không
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	$sql="SELECT id,tieu_de FROM hoatdong WHERE id={$id}";
	$query_a=mysqli_query($dbc,$sql);
	// Hiện thị một dòng dữ liệu
	$dm_info=mysqli_fetch_assoc($query_a);

	//đặt số bản ghi cần hiện thị
	$limit=6;
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
	    $query_pg="SELECT COUNT(id) FROM hinhhoatdong WHERE hoat_dong_id = {$id}";
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
?>
<section class="junior__classes__area section-lg-padding--top section-padding--md--bottom bg--white">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="section__title text-center">
					<h2 class="title__line"><?php echo $dm_info['tieu_de']; ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- Danh mục -->
			<div  style="padding-right:100px" class="col-3">
				<div style="margin-bottom:20px">
					<h2 style="color:#D90418">Danh Mục</h2>
				</div>
				<?php
				$query_dm = "SELECT * FROM hoatdong";
				$results_dm = mysqli_query($dbc, $query_dm);
				foreach ($results_dm as $item_dm) {
				?>
				<ul  class="border border-top-0 border-right-0 border-left-0 " style="margin-bottom:10px">
					<li><a href="hinh-anh-hoat-dong.php?id=<?php echo $item_dm['id'] ?>"><?php echo $item_dm['tieu_de']; ?></a></li>
				</ul>
				<?php
				}
				?>
			</div>
			<!-- End danh muc -->


			<!-- Hình ảnh -->
			<div class="col-9">
				<div class="row galler__wrap">
					<?php
					//Truy van bang hinh hoat dong
					$query_hhd = "SELECT * FROM hinhhoatdong WHERE hoat_dong_id = {$id} ORDER BY id DESC LIMIT {$start},{$limit}";
					$results_hhd = mysqli_query($dbc, $query_hhd);
					foreach($results_hhd as $item_hhd)
					{
						//Truy van bang hoat dong
						$query_hd = "SELECT * FROM hoatdong WHERE id = {$item_hhd['hoat_dong_id']}";
						$results_hd = mysqli_query($dbc, $query_hd);
						foreach($results_hd as $item_hd)
						{
					?>
						<div class="col-lg-4 col-md-6 col-sm-6 col-12">
							<div class="gallery wow fadeInUp">
							<!-- Start Single Gallery -->
								<div class="gallery__thumb">
									<a href="#">
										<img src="admin/images/hinhhd/<?php echo $item_hhd['hinh']; ?>" alt="gallery images">
									</a>
								</div>
								<div class="gallery__hover__inner">
									<div class="gallery__hover__action">
										<ul class="gallery__zoom">
											<li><a href="admin/images/hinhhd/<?php echo $item_hhd['hinh']; ?>" data-lightbox="grportimg" data-title="<?php echo $item_hd['tieu_de'] ?>"><i class="fa fa-search"></i></a></li>
										</ul>
										<h4 class="gallery__title"><a href="#"><?php echo $item_hd['tieu_de'] ?></a></h4>
										<p><?php echo $item_hd['mo_ta']; ?></p>
									</div>
								</div>
							</div>	
						</div>
					<?php
						}
					}
					?>
					<!-- End Single Gallery -->
				</div>
				<br />
				<?php
				echo "<nav aria-label='Page navigation example'>";
			        echo "<ul class='pagination justify-content-center'>";
			        if($per_page > 1)
			        {
			            $current_page=($start/$limit) + 1;
			            //Nếu không phải là trang đầu thì hiện thị trang trước
			            if($current_page !=1)
			            {
			                echo "<li class='page-item' class='float-left'><a class='page-link' href='hinh-anh-hoat-dong.php?id=".$id."&s=".($start - $limit)."&p={$per_page}'>Trở về</a></li>";
			            }
			            //hiện thị những phần còn lại của trang
			            for ($i=1; $i <= $per_page ; $i++) 
			            { 
			                if($i != $current_page)
			                {
			                    echo "<li class='page-item'><a class='page-link' href='hinh-anh-hoat-dong.php?id=".$id."&s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
			                }
			                else
			                {
			                    echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
			                }
			            }
			            //Nếu không phải trang cuối thì hiện thị nút next
			            if($current_page != $per_page)
			            {
			                echo "<li class='page-item' ><a class='page-link' href='hinh-anh-hoat-dong.php?id=".$id."&s=".($start + $limit)."&p={$per_page}'>Tiếp</a></li>";  
			            }
			        }
			        echo "</ul>";
			    echo "</nav>"          
				?>
			</div>
			<!-- End hình ảnh -->
		</div>
	</div>
</section>
<?php
}
else
{
	header('Location: index.php');
}
?>
<?php include "footer.php" ?>