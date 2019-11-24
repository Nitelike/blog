<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Избранные - <?php echo $params['title'] ?></title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/category.css">
</head>
<body>
	<?php include '../includes/header.php' ?>

		<aside><?php 
				function currentUrl($url)
				{
					if (strpos($_SERVER['REQUEST_URI'], $url) !== false) {
						echo 'current-page';
					}
				}
			include '../includes/user-page-aside.php';
				
		?></aside>

		<div class="additional"><?php include '../includes/user-page-aside.php'; ?></div>

		<section class="side-section">
			<div class="page_subtitle">
				<span>Избраные статьи</span>
			</div>
			<hr>
			<br>
			<div class="category-container">
			

			<?php 			
				$counter = 0;
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate`");
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos($user['tracked_articles'], ' ' . $post['id'] . ',') !== false) {
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
									if ($src != -1) { $counter++; ?>
										<a href="article.php?id=<?php echo $post['id'] ?>">
											<div class="image-handler" style="background-image: url(<?php echo $src ?>);">												
											</div>
										</a>
										<span class="blog-title">
										<a href="article.php?id=<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></span>
									<?php } ?>

							</div>
							<?php
						}								
					}
				}
				if ($counter < 1) {
					?>
							<span>
								Вы не выбрали статей
							</span>
					<?php
				}	
		?>
	</div>
	</section>
	<?php include '../includes/footer.php' ?>
</body>
</html>
<?php mysqli_close($connection) ?>