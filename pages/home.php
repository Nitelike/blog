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
		<?php
			if (empty($_GET['sort_by']) or empty($_GET['order']) or empty($_GET['max-count'])) {		
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate` DESC LIMIT 10");
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						include '../includes/post.php';				
					}
				}
			}
			else {
				$sort_by = $_GET['sort_by'];
				$order = $_GET['order'];
				if ($_GET['max-count'] != 'all') {
					$limit = intval($_GET['max-count']);
					$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY $sort_by $order LIMIT $limit");
				}
				else if ($_GET['max-count'] == 'all') {
					$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY $sort_by $order");
				}
				
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						include '../includes/post.php';				
					}
				}
			}
		?>
	</div>	
</body>
</html>
<?php mysqli_close($connection) ?>