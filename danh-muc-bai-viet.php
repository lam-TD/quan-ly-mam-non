<?php include "header.php" ?>
<!-- Shop Single -->
<?php
//Kiểm tra ID có phải là kiểu số không
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	$sql="SELECT id,ten FROM loaitin WHERE id={$id}";
	$query_a=mysqli_query($dbc,$sql);
	// Hiện thị một dòng dữ liệu
	$dm_info=mysqli_fetch_assoc($query_a);

	//đặt số bản ghi cần hiện thị
	$limit=3;
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
	    $query_pg="SELECT COUNT(id) FROM tintuc WHERE loai_tin_id = {$id}";
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
					<h2 class="title__line"><?php echo $dm_info['ten']; ?></h2>
				</div>
			</div>
		</div>
		<?php
		//Truy van bang tin tuc co loai tin id bang id truyen vao
		$query_tt = "SELECT * FROM tintuc WHERE loai_tin_id = {$id} ORDER BY id ASC LIMIT {$start},{$limit}";
		$results_tt = mysqli_query($dbc,$query_tt);
		foreach($results_tt as $item_tt)
		{
		?>
		<div class="row">
			<div class = col-3>
				<a href="bai-viet-chi-tiet.php?id=<?php echo $item_tt['id'] ?>">
					<img style ="width : 100%>" src="admin/images/tintuc/<?php echo $item_tt['hinh'] ?>" alt="class images">
				</a>
			</div>
			<div class=" col-8">
				<h4><a href="bai-viet-chi-tiet.php?id=<?php echo $item_tt['id'] ?>"><?php echo $item_tt['tieude'] ?></a></h4>
				<p><?php echo $item_tt['tomtat']; ?></p>
			</div>
		</div>
		<br />
		<?php
		}
		?>
	</div>
	<?php
		echo "<nav aria-label='Page navigation example'>";
	        echo "<ul class='pagination justify-content-center'>";
	        if($per_page > 1)
	        {
	            $current_page=($start/$limit) + 1;
	            //Nếu không phải là trang đầu thì hiện thị trang trước
	            if($current_page !=1)
	            {
	                echo "<li class='page-item' class='float-left'><a class='page-link' href='danh-muc-bai-viet.php?id=".$id."&s=".($start - $limit)."&p={$per_page}'>Trở về</a></li>";
	            }
	            //hiện thị những phần còn lại của trang
	            for ($i=1; $i <= $per_page ; $i++) 
	            { 
	                if($i != $current_page)
	                {
	                    echo "<li class='page-item'><a class='page-link' href='danh-muc-bai-viet.php?id=".$id."&s=".($limit *($i - 1))."&p={$per_page}'>{$i}</a></li>";
	                }
	                else
	                {
	                    echo "<li class='page-item' class='active'><a class='page-link'>{$i}</a></li>";
	                }
	            }
	            //Nếu không phải trang cuối thì hiện thị nút next
	            if($current_page != $per_page)
	            {
	                echo "<li class='page-item' ><a class='page-link' href='danh-muc-bai-viet.php?id=".$id."&s=".($start + $limit)."&p={$per_page}'>Tiếp</a></li>";  
	            }
	        }
	        echo "</ul>";
	    echo "</nav>"          
	?>
</section>
<?php
}
else
{
	header('Location: index.php');
}
?>
<!-- End Single -->
<?php include "footer.php" ?>