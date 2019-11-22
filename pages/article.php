<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Статья</title>
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/article.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
</head>
<body>
	<?php include '../includes/header.php'; $article_id = $_GET['id']; ?>

	<aside>
		<?php include '../includes/read-more.php' ?>
	</aside>

	<section class="side-section">
		<article>
			<?php 		
				$result = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = $article_id");
				if (mysqli_num_rows($result) !== false) {
					$post = mysqli_fetch_assoc($result);
				

				include '../includes/post-info.php';
			?>

			<div class="path">
				<span><a href="home.php">Главная > </a> <a href="category.php?cat=<?php echo $cat['id'] ?>#track-<?php echo $post['id'] ?>"><?php echo $cat['title'] ?> > </a> <a><?php echo $post['title'] ?></a></span>
			</div> <br>

			<hr>
						
			<div class="post-content">
				<?php 
					echo $post['text'];
					$id = $post['id'];
					$views = $post['views'] + 1;
					mysqli_query($connection, "UPDATE `articles` SET `views` = $views WHERE `articles`.`id` = $id;");
				}
				?>
			</div>	
		</article>
	</section>

	<div class="additional">
		<?php include '../includes/read-more.php' ?>
	</div>
</body>
</html>
<?php mysqli_close($connection) ?>