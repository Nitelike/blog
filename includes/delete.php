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
				<?php include '../includes/header.php'; include '../includes/manager-functions.php'; ?>

				<aside><?php 
					function currentUrl($url)
					{
						if (strpos($_SERVER['REQUEST_URI'], $url) !== false) {
							echo 'current-page';
						}
					}
				include '../includes/user-page-aside.php';
					
				?></aside>

				<div class="additional"><?php include '../includes/user-page-aside.php'; ?></div>

				<section class="side-section">
					<div class="page_subtitle">
						<span>
							<?php echo 'Результаты по запросу "' . $title . '"' ?>
						</span>
					</div>

					<form autocomplete="off" action="content-manager-handler.php" method="post">
						<?php
							$counter = 0;
							$counter += selectForDelete('districts', $title);
							$counter += selectForDelete('categories', $title);
							$counter += selectForDelete('articles', $title);
							if ($counter < 1) {
								echo 'По вашему запросу ничего не найдено';
							}
							else {
								?>
								<div>
									<button class="send-button" type="submit">Удалить выбранные</button>
								</div>					
								<?php
							}
						?>
					</form>
				</section>
			</body>
			</html>	