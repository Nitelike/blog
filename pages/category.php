<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Категория - <?php echo $params['title'] ?></title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/category.css">
</head>
<body>
	<?php include '../includes/header.php' ?>
	<section>
		<div class="category-container">
			<?php
				$dog = $_GET['cat'];
				if ($dog != false) { 			
				$counter = 0;
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `title`");
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos($post['category_id'], $dog) !== false) {
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
								<div id="track-<?php echo $post['id'] ?>"></div>
								<?php
									if ($src != -1) { ?>
										<a href="article.php?id=<?php echo $post['id'] ?>">
											<div class="image-handler" style="background-image: url(<?php echo $src ?>);">												
											</div>
										</a>
									<?php } ?>
									<span class="blog-title">
									<a href="article.php?id=<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></span>
								
								<?php 
									$counter++;	
								?>
							</div>
							<?php
						}								
					}
				}
				if ($counter < 1) {
					echo 'В этой категории нет статей';
				}
			}	
		?>
	</div>
	</section>
	<?php include '../includes/footer.php' ?>
</body>
</html>
<?php mysqli_close($connection) ?>