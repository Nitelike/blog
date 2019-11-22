<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Результаты поиска - <?php echo $params['title'] ?></title>	
	<?php include '../includes/common-header.php' ?>
	
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/category.css?version=1.0">
</head>
<body>
	<?php include '../includes/header.php' ?>
	<?php 
		$key = $_GET['search_key'];
		$key = mysqli_real_escape_string($connection, trim($key));
	?>

	<section>
		<div class="page_subtitle">
			<span>
				<?php echo "Результаты по запросу \"" . htmlentities($key, ENT_QUOTES) . "\"" ?>
			</span>
		</div>

		<div class="category-container">

		<?php 
			
			if(strlen($key) > 0) {
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate`");
				$counter = 0;
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos(mb_strtolower($post['title']), mb_strtolower($key)) !== false or strpos(mb_strtolower($post['text']), mb_strtolower($key)) !== false) {
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
								
								<?php 
									$counter++;	
								?>
							</div>	<?php
						}								
					}
				}
				if ($counter < 1) {
					echo '<span>По вашему запросу ничего не найдено</span>';
				}	
			}
			else {
				echo '<span>Ваш поисковый запрос пустой</span>';
			}		
		?>	
		</div>
	</section>
</body>
</html>
<?php mysqli_close($connection) ?>