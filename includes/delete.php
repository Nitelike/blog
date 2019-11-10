<!DOCTYPE html>
			<html lang="ru">
			<head>
				<meta charset="UTF-8">
				<title><?php echo $params['title'] ?> - Удаление</title>	
				<?php include '../includes/common-header.php' ?>
				<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
				<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
				<link rel="stylesheet" type="text/css" href="../css/content-manager-handler.css?version=1.0">
			</head>
			<body>
				<?php include '../includes/topnav.php' ?>
					<div class="centered-page-subtitle wrapper">
						<span>
							<?php echo 'Результаты по запросу "' . $title . '"' ?>
						</span>
					</div>

					<form autocomplete="off" action="content-manager-handler.php" method="post">
						<?php
						$counter = 0;
						$sql = "SELECT * FROM `categories`";	
						$result = mysqli_query($connection, $sql);	
						if (mysqli_num_rows($result) > 0) {
							while ($cat = mysqli_fetch_assoc($result)) {
								if (strpos(mb_strtolower($cat['title']), mb_strtolower($title)) !== false) {
									?>
										<div class="wrapper delete-item">
											<input class="delete-option" name="delete_cat[]" type="checkbox" value="<?php echo $cat['id'] ?>">
											<label for="<?php echo $cat['title'] ?>"><?php echo $cat['title'] ?></label>
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
										<div class="wrapper delete-item">
											<input class="delete-option" name="delete_art[]" type="checkbox" value="<?php echo $post['id'] ?>">
											<?php include '../includes/post.php' ?>
										</div>
									<?php
									$counter++;
								}			
							}
						}
						if ($counter < 1) {
							echo '<div class="centered-page-subtitle wrapper"><span>По вашему запросу ничего не найдено</span></div>';
						}
						else {
							?>
							<div class="wrapper">
								<button class="send-button" type="submit">Удалить выбранные</button>
							</div>					
							<?php
						}
						?>
					</form>
			</body>
			</html>	