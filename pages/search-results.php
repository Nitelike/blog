<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Результаты поиска</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/home.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/category.css?version=1.0">
</head>
<body>
	<?php include '../includes/topnav.php' ?>
	<?php 
		$key = $_GET['search_key'];
		$key = mysqli_real_escape_string($connection, trim($key));
	?>

	<div class="header-subtitle">
		<span>
			<?php echo "Результаты по запросу " . htmlentities($key, ENT_QUOTES) ?>
		</span>
	</div>

	<div class="container">
		<?php 
			
			if(strlen($key) > 0) {
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate`");
				$counter = 0;
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos(mb_strtolower($post['title']), mb_strtolower($key)) !== false or strpos(mb_strtolower($post['text']), mb_strtolower($key)) !== false) {
							include '../includes/col-post.php';	
							$counter++;
						}								
					}
					echo '</div>';
				}
				if ($counter < 1) {
					echo '</div>';
					echo '<div class="header-subtitle"><span>По вашему запросу ничего не найдено</span></div>';
				}	
			}
			else {
				echo '</div>';
				echo '<div class="header-subtitle"><span>Ваш поисковый запрос пустой</span></div>';
			}		
		?>	
</body>
</html>
<?php mysqli_close($connection) ?>