<!DOCTYPE html>
	<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>Изменить - <?php echo $params['title'] ?></title>	
		<?php include '../includes/common-header.php' ?>
		<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
		<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
		<link rel="stylesheet" type="text/css" href="../css/content-manager-handler.css?version=1.0">
	</head>
	<body>
		<?php
		
		 include '../includes/header.php'; include '../includes/manager-functions.php'; ?>

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
					<?php echo 'Результаты по запросу "' . htmlentities($title, ENT_QUOTES) . '"' ?>
				</span>
			</div>

			<form autocomplete="off" action="content-manager.php">
				<?php
				$counter = 0;
				
				$counter += selectFromTable('districts', $title, 'update');
				if ($user['status'] == 'admin') {
				$counter += selectFromTable('categories', $title, 'update');
				}
				$counter += selectFromTable('articles', $title, 'update');

				if ($counter < 1) {
					echo 'По вашему запросу ничего не найдено';
				}
				?>
			</form>
		</section>
	</body>
</html>			