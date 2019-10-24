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
		if ($_GET['mode'] == 'create_article') {
			if (!empty($_GET['category'])) {
				$categories = '';			
				$text = $_GET['text'];
				$text = str_replace('<h1>', '<span>', $text);
				$text = str_replace('<h1>', '<span>', $text);
				$text = str_replace('style=', '', $text);
				$text = mysqli_real_escape_string($connection, $text);	
				foreach ($_GET['category'] as $cat) {
					$categories  = $categories .' ' . $cat;
				}
				$sql = "INSERT INTO articles (title, text, category_id) VALUES ('$title', '$text', '$categories')";
			}
			else {
				echo 'You should choose categories for this article';
			}	
		}
		else if ($_GET['mode'] == 'add_category') {
			$sql = "INSERT INTO categories (title) VALUES ('$title')";		
		}
		else if ($_GET['mode'] == 'find_for_delete') {
			//some basic html
			?>
			
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<title><?php echo $params['title'] ?> - Home</title>	
				<link rel="stylesheet" type="text/css" href="../css/main.css?version=1.0">
				<link rel="stylesheet" type="text/css" href="../css/topnav.css?version=1.0">
				<link rel="stylesheet" type="text/css" href="../css/aside.css?version=1.0">
				<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
				<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
				<link rel="stylesheet" type="text/css" href="../css/content-manager-handler.css?version=1.0">
				<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
			</head>
			<body>
				<?php include '../includes/topnav.php' ?>
				<?php include '../includes/aside.php' ?>
				<div class="content">
					<div class="page_subtitle">
						<span>
							<?php echo 'Results for "' . $title . '":' ?>
						</span>
					</div>
					<form autocomplete="off" action="content-manager-handler.php">
						<?php
						$counter = 0;
						$sql = "SELECT * FROM `categories`";	
						$result = mysqli_query($connection, $sql);	
						if (mysqli_num_rows($result) > 0) {
							while ($cat = mysqli_fetch_assoc($result)) {
								if (strpos(strtolower($cat['title']), strtolower($title)) !== false) {
									?>
										<div class="delete-item">
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
								if (strpos(strtolower($post['title']), strtolower($title)) !== false or strpos(strtolower($post['text']), strtolower($title)) !== false) {
									?>
										<div class="delete-item">
											<input class="delete-option" name="delete_art[]" type="checkbox" value="<?php echo $post['id'] ?>">
											<?php include '../includes/post.php' ?>
										</div>
									<?php
									$counter++;
								}			
							}
						}
						if ($counter < 1) {
							echo 'Your search returned 0 results';
						}
						else {
							?>
							<input type="submit" value="Delete selected">
							<?php
						}
						?>
					</form>
				</div>
			</body>
			</html>			
			<?php
		}
		if ($_GET['mode']  == 'add_category' or $_GET['mode'] == 'create_article') {
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