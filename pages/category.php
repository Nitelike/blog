<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Home</title>	
	<link rel="stylesheet" type="text/css" href="../css/main.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/home.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/topnav.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/aside.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<?php include '../includes/topnav.php' ?>
	<?php include '../includes/aside.php' ?>
	<div class="content">
		<div class="page_subtitle">
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
							include '../includes/post.php';	
							$counter++;	
						}								
					}
				}
				if ($counter < 1) {
					echo 'There is no articles in this category';
				}
			}	
		?>
	</div>	
</body>
</html>
<?php mysqli_close($connection) ?>