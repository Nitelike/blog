<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Статья</title>
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/article.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
</head>
<body>
	<?php include '../includes/topnav.php' ?>
	<?php include '../includes/aside.php' ?>
	<div class="content">
		<article>
			<?php 
				$article_id = $_GET['id'];
				$result = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = $article_id");
				if (mysqli_num_rows($result) > 0) {
					$post = mysqli_fetch_assoc($result);
				

				include '../includes/post-info.php' 
			?>
			
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
	</div>
</body>
</html>
<?php mysqli_close($connection) ?>