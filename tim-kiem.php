<?php include "header.php" ?>
<section class="junior__classes__area section-lg-padding--top section-padding--md--bottom bg--white">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="section__title text-center">
					<h2 class="title__line">Tìm Kiếm</h2>
				</div>
			</div>
		</div>
		<?php
			if(isset($_REQUEST['submit']))
			{
				$search = $_GET['ten'];
				if(empty($search))
				{
					echo "<p class=text-danger>Vui lòng nhập dữ liệu vào ô trống</p>";
				}
				else
				{
					//Tìm kiếm bài viết tin tức
					$query = "SELECT * FROM tintuc WHERE tieude like '%$search%'";
					$results = mysqli_query($dbc,$query);
					$num = mysqli_num_rows($results);
					if($num > 0 && $search != "")
					{
						echo "<p class=text-info>$num bài viết được tìm thấy với $search</p>";
						foreach ($results as $item)
						{
						?>
							<br />
							<div class="row">
								<div class = col-3>
									<a href="bai-viet-chi-tiet.php?id=<?php echo $item['id'] ?>">
										<img style ="width : 100%>" src="admin/images/tintuc/<?php echo $item['hinh'] ?>" alt="class images">
									</a>
								</div>
								<div class=" col-8">
									<h4><a href="bai-viet-chi-tiet.php?id=<?php echo $item['id'] ?>"><?php echo $item['tieude'] ?></a></h4>
									<p><?php echo $item['tomtat']; ?></p>
								</div>
							</div>
						<?php
						}
					}
					else
					{
						echo "<p class = text-danger>Không tìm thấy bài viết</p>";
					}
				}
			}
		?>
	</div>
</section>
<?php include "footer.php" ?>