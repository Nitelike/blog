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
</head>
<body>
	<?php include '../includes/topnav.php' ?>
	<?php 
		$key = $_GET['search_key'];
		$key = mysqli_real_escape_string($connection, trim($key));
		include '../includes/aside.php'; 
	?>
	<div class="content">

		<div class="centered-page-subtitle">
			<span>
				<?php echo 'Результаты по запросу "' . $key . '"' ?>
			</span>
		</div>
		<?php 
			
			if(strlen($key) > 0) {
				$result = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate`");
				$counter = 0;
				if (mysqli_num_rows($result) > 0) {
					while ($post = mysqli_fetch_assoc($result)) {
						if (strpos(mb_strtolower($post['title']), mb_strtolower($key)) !== false or strpos(mb_strtolower($post['text']), mb_strtolower($key)) !== false) {
							include '../includes/post.php';	
							$counter++;
						}								
					}
				}
				if ($counter < 1) {
					echo '<div class="centered-page-subtitle"><span>По вашему запросу ничего не найдено</span></div>';
				}	
			}
			else {
				echo '<div class="centered-page-subtitle"><span>Ваш поисковый запрос пустой</span></div>';
			}		
		?>	
	</div>
</body>
</html>
<?php mysqli_close($connection) ?>