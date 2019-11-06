<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Категория</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/home.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
</head>
<body>
	<?php include '../includes/topnav.php' ?>
		<div class="wrapper centered-page-subtitle">
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
			<?php 			
				$counter = 0;
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate`");
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos($post['category_id'], $dog) !== false) {
							?>
							<div class="content-90">
							<?php 
							include '../includes/post.php';	
							$counter++;	
							?>
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
</body>
</html>
<?php mysqli_close($connection) ?>