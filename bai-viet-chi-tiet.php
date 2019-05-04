<?php include "header.php" ?>
<!-- Shop Single -->
<?php
//Kiểm tra ID có phải là kiểu số không
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
    $id=$_GET['id'];
}
else
{
    header('Location: index.php');
    exit();
}
//Truy van bang loai tin co id duoc truyen qua
$query = "SELECT * FROM tintuc WHERE id = {$id}";
$results = mysqli_query($dbc,$query);
foreach($results as $item)
{
?>
<section class="junior__classes__area section-lg-padding--top section-padding--md--bottom bg--white">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="section__title text-center">
					<h2 class="title__line"><?php echo $item['tieude']; ?></h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class = col-12>
				<p><?php echo $item['noidung']; ?></p>
			</div>
		</div>
	</div>
</section>
<?php
}
?>
<!-- End Single -->
<?php include "footer.php" ?>