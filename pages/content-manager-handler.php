<?php 
include '../includes/config.php';
include '../includes/get-user.php';
if (isset($_SESSION['user']) and $user_name == 'admin') {
	if (!empty($_GET['title'])) {
		$title = $_GET['title'];
		$title = str_replace('<h1>', '<span>', $title);
		$title = str_replace('<h1>', '<span>', $title);
		$title = str_replace('style=', '', $title);
		$title = mysqli_real_escape_string($connection, $title);	
		if ($_GET['mode'] == 'create_article' or $_GET['mode'] == 'update_article') {
			if (!empty($_GET['category'])) {
				$categories = '';			
				$text = $_GET['text'];
				$text = str_replace('<h1>', '<span>', $text);
				$text = str_replace('<h1>', '<span>', $text);
				$text = str_replace('style=', '', $text);
				$text = mysqli_real_escape_string($connection, $text);	
				foreach ($_GET['category'] as $cat) {
					$categories  = $categories .' ' . $cat . ',';
				}
				if ($_GET['mode'] == 'create_article') {
					$sql = "INSERT INTO articles (title, text, category_id) VALUES ('$title', '$text', '$categories')";
				}
				else if ($_GET['mode'] == 'update_article') {
					$update_post_id = $_GET['update_id'];
					$sql = "UPDATE articles SET title = '$title', text = '$text', category_id = '$categories' WHERE `articles`.`id` = $update_post_id";
				}
			}
			else {
				echo 'Вы должны выбрать категорию для статьи';
			}	
		}
		else if ($_GET['mode'] == 'add_category') {
			$sql = "INSERT INTO categories (title) VALUES ('$title')";		
		}
		else if ($_GET['mode'] == 'update_category') {
			$update_category_id = $_GET['update_id'];
			$sql = "UPDATE categories SET title = '$title' WHERE `id` = $update_category_id";		
		}
		else if ($_GET['mode'] == 'find_for_delete') {
			//some basic html
			?>
			
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

					<form autocomplete="off" action="content-manager-handler.php">
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
			<?php
		}
		else if ($_GET['mode'] == 'update') {
			?>
			
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
			<?php	
		}
		if ($_GET['mode']  == 'add_category' or $_GET['mode'] == 'create_article' or $_GET['mode'] == 'update_article' or $_GET['mode'] == 'update_category') {
			if (mysqli_query($connection, $sql)) {
				echo 'Created';
				header('Location: home.php');
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($connection);
			}
		}	
	}	
	else  {
		if (!empty($_GET['delete_cat'])) {		
			foreach ($_GET['delete_cat'] as $option) {
				$result = mysqli_query($connection, "DELETE FROM `categories` WHERE `categories`.`id` = $option");
				if (!$result) {
					echo mysqli_error($connection);
				}
			}
		}	
		if (!empty($_GET['delete_art'])) {		
			foreach ($_GET['delete_art'] as $option) {
				$result = mysqli_query($connection, "DELETE FROM `articles` WHERE `articles`.`id` = $option");
				if (!$result) {
					echo mysqli_error($connection);
				}
			}
		}
		if (!mysqli_error($connection)) {
			echo 'Created';
			header('Location: home.php');
		}	
		else {
			echo mysqli_error($connection);
		}	
	}	
}
?>