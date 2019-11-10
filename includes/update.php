<!DOCTYPE html>
			<html lang="ru">
			<head>
				<meta charset="UTF-8">
				<title><?php echo $params['title'] ?> - Изменить</title>	
				<?php include '../includes/common-header.php' ?>
				<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
				<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
				<link rel="stylesheet" type="text/css" href="../css/content-manager-handler.css?version=1.0">
			</head>
			<body>
				<?php include '../includes/topnav.php' ?>
					<div class="wrapper centered-page-subtitle">
						<span>
							<?php echo 'Результаты по запросу "' . $title . '"' ?>
						</span>
					</div>
					<form autocomplete="off" action="content-manager.php">
						<?php
						$counter = 0;
						$sql = "SELECT * FROM `categories`";	
						$result = mysqli_query($connection, $sql);	
						if (mysqli_num_rows($result) > 0) {
							while ($cat = mysqli_fetch_assoc($result)) {
								if (strpos(mb_strtolower($cat['title']), mb_strtolower($title)) !== false) {
									?>
										<div class="wrapper">
											<a href="content-manager.php?mode=update_category&id=<?php echo $cat['id'] ?>"><?php echo $cat['title'] ?></a>
										</div>
									<?php
									$counter++;
								}			
							}
						}
						$sql = "SELECT * FROM `articles` ORDER BY `pubdate` DESC";	
						$result = mysqli_query($connection, $sql);	
						if (mysqli_num_rows($result) > 0) {
							while ($post = mysqli_fetch_assoc($result)) {
								if (strpos(mb_strtolower($post['title']), mb_strtolower($title)) !== false or strpos(mb_strtolower($post['text']), mb_strtolower($title)) !== false) {
									?>
										<div class="wrapper">
											<a href="content-manager.php?mode=update_article&id=<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a>
										</div>
									<?php
									$counter++;
								}			
							}
						}
						if ($counter < 1) {
							echo '<div class="centered-page-subtitle wrapper"><span>По вашему запросу ничего не найдено</span></div>';
						}
						?>
					</form>
			</body>
			</html>			