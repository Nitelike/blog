<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Область - <?php echo $params['title'] ?></title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/article.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/category.css">
</head>
<body>
	<?php include '../includes/header.php' ?>
	<section>
		<article>
			<?php 		
				$id = $_GET['district_id'];
				$result = mysqli_query($connection, "SELECT * FROM `districts` WHERE `id` = '$id'");
				if (mysqli_num_rows($result) !== false) {
					$district = mysqli_fetch_assoc($result);
			?>

			<div class="page_subtitle"><span><?php echo $district['title'] ?> область</span></div>
			<hr>
			
						
			<div class="post-content">
				<?php echo $district['description']; }	?>
			</div>	
		</article>
	</section>
	<br>
	<section>
		<div class="page_subtitle"><span>Статьи, относящиеся к области</span></div>
		<div class="category-container">
			<?php
				$id = ' ' . $_GET['district_id'] . ',';
				if ($id != false) { 			

				$result = mysqli_query($connection, "SELECT * FROM `articles` WHERE `district_id` = '$id' ORDER BY `title` ASC");

				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						$src = -1;
						$index = strpos($post['text'], '<img src=');
						if ($index !== false) {
							$index += 10;
							$last_index = strpos(substr($post['text'], $index), '>');
							if ($last_index !== false) {
								$src = substr($post['text'], $index, $last_index - 8);
							}
						}
						?>
						<div class="block-article">
							<?php
								if ($src != -1) { ?>
									<a href="article.php?id=<?php echo $post['id'] ?>">
										<div class="image-handler" style="background-image: url(<?php echo $src ?>);">												
										</div>
									</a>
								<?php } ?>
								<span class="blog-title">
								<a href="article.php?id=<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></span>
						</div>
						<?php
														
					}
				}
				else {
					echo "Для этой области нет статей";
				}
			}	
		?>
		</div>
	</section>
</body>
</html>
<?php mysqli_close($connection) ?>