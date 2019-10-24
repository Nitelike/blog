<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Search results</title>	
	<link rel="stylesheet" type="text/css" href="../css/main.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/home.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/topnav.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/aside.css">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<?php include '../includes/topnav.php' ?>
	<?php 
		$key = $_GET['search_key'];
		include '../includes/aside.php'; 
	?>
	<div class="content">
		<?php 
			
			if(strlen($key) > 0) {
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate`");
				$counter = 0;
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos(strtolower($post['title']), strtolower($key)) !== false or strpos(strtolower($post['text']), strtolower($key)) !== false) {
							include '../includes/post.php';	
							$counter++;
						}								
					}
				}
				if ($counter < 1) {
					echo 'Your search returned 0 results';
				}	
			}
			else {
				echo 'Your search query was empty';
			}		
		?>	
	</div>
</body>
</html>
<?php mysqli_close($connection) ?>