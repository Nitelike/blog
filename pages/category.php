<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Категория</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/home.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/category.css">
</head>
<body>
	<?php include '../includes/topnav.php' ?>
		<div class="header-subtitle">
			<span>
				<?php 
					$dog = $_GET['cat'];
					if ($dog != false) {
						$result = mysqli_query($connection, "SELECT * FROM `categories` WHERE `id` = $dog");
						if (mysqli_num_rows($result) > 0) {
							echo mysqli_fetch_assoc($result)['title'];
						}
				?>
			</span>
		</div>
		<div class="container">

			<?php 			
				$counter = 0;
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate`");
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos($post['category_id'], $dog) !== false) {
							$src = -1;
							$index = strpos($post['text'], '<img src="');
							if ($index !== false) {
								$index += 10;
								$last_index = strpos(substr($post['text'], $index), '"');
								if ($last_index !== false) {
									$src = substr($post['text'], $index, $last_index);
								}
							}
							?>
							<div class="content-col">
								<?php
									if ($src != -1) { ?>
										<div class="image-wrapper">
											<a href="article.php?id=<?php echo $post['id'] ?>">
												<img class="article-icon" src="<?php echo $src ?>" alt="article-icon">
											</a>	
										</div>
									<?php } ?>
								
								<?php 
									include '../includes/post.php';	
									$counter++;	
								?>

								<a class="button-link" href="article.php?id=<?php echo $post['id'] ?>">Читать дальше</a>
							</div>
							<?php
						}								
					}
				}
				if ($counter < 1) {
					?>
						<div class="wrapper centered-page-subtitle">
							<span>
								В этой категории нет статей
							</span>
						</div>
					<?php
				}
			}	
		?>
	</div>
</body>
</html>
<?php mysqli_close($connection) ?>