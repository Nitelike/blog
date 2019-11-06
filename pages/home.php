<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Главная</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/home.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/logo.css?version=1.0">
	<script src="../js/menu-button.js"></script>
</head>
<body>
	<?php include '../includes/logo.php' ?>
	<?php include '../includes/topnav.php' ?>
	<?php include '../includes/topmenu.php' ?>
	<div class="wrapper">
		<form method="get" action="../pages/search-results.php" autocomplete="off">
			<input class="search-input" type="text" placeholder="Поиск" name="search_key" value="<?php if (isset($key)) {echo $key;} ?>" maxlength="25">
			<button class="send-button" type="submit">Искать</button>
		</form>	
		<div class="subtitle">
			<span>Категории</span>
		</div>
		<div class="category-wrapper">
			<?php 
				$categories = mysqli_query($connection, "SELECT * from `categories`");
				if (mysqli_num_rows($categories) > 0) {
					while ($category = mysqli_fetch_assoc($categories)) {
						?>
						<div class="category-item">
							
								<a href="category.php?cat=<?php echo $category['id'] ?>">
									<span class="cat-title"><?php echo $category['title'] ?></span>
									<span class="cat-description"><?php echo $category['description'] ?></span>
								</a>			
						</div>				
						<?php
					}
				}
			?>
		</div>
	</div>
</body>
</html>
<?php mysqli_close($connection) ?>