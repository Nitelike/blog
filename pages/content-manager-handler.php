<?php 
include '../includes/config.php';
include '../includes/get-user.php';
require '../includes/vcs.php';
if (isset($_SESSION['user']) and $user['status'] == 'editor' or $user['status'] == 'admin') {
	if (!empty($_POST['title'])) {
		$title = $_POST['title'];
		$title = str_replace('<h1>', '<span>', $title);
		$title = str_replace('<h1>', '<span>', $title);
		$title = str_replace('style=', '', $title);
		$title = mysqli_real_escape_string($connection, $title);
		if (isset($_POST['text'])) {
			$text = $_POST['text'];
			$text = str_replace('<h1>', '<span>', $text);
			$text = str_replace('<h1>', '<span>', $text);
			$text = str_replace('style=', '', $text);
			$text = mysqli_real_escape_string($connection, $text);
		}	
		if ($_POST['mode'] == 'create_article' or $_POST['mode'] == 'update_article') {
			if (!empty($_POST['category'])) {
				$categories = ' ' . $_POST['category'] . ',';				
				if ($_POST['mode'] == 'create_article') {
					$sql = "INSERT INTO articles (title, text, category_id) VALUES ('$title', '$text', '$categories')";
				}
				else if ($_POST['mode'] == 'update_article') {
					$update_post_id = $_POST['update_id'];
					$sql = "UPDATE articles SET title = '$title', text = '$text', category_id = '$categories' WHERE `articles`.`id` = $update_post_id";
					commit($update_post_id, $title, $text, 'article');
				}
			}
			else {
				echo 'Вы должны выбрать категорию для статьи';
			}	
		}
		else if ($_POST['mode'] == 'add_category') {
			$sql = "INSERT INTO categories (title, description) VALUES ('$title', '$text')";		
		}
		else if ($_POST['mode'] == 'update_category') {
			$update_category_id = $_POST['update_id'];
			$sql = "UPDATE categories SET title = '$title', description = '$text' WHERE `id` = $update_category_id";
			commit($update_category_id, $title, $text, 'category');			
		}
		else if ($_POST['mode'] == 'find_for_delete') {
			require '../includes/delete.php';
		}
		else if ($_POST['mode'] == 'update') {
			require '../includes/update.php';
		}
		if ($_POST['mode']  == 'add_category' or $_POST['mode'] == 'create_article' or $_POST['mode'] == 'update_article' or $_POST['mode'] == 'update_category') {
			if (mysqli_query($connection, $sql)) {
				echo 'Created';
				header('Location: home.php');
				if ($_POST['mode'] == 'create_article') {
					$mode = 'article';
					$id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `articles` ORDER BY `id` DESC LIMIT 1"))['id'];
					create($id, $title, $text, $mode);
				}
				else if ($_POST['mode'] == 'add_category') {
					$mode = 'category';
					$id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `categories` ORDER BY `id` DESC LIMIT 1"))['id'];
					create($id, $title, $text, $mode);
				}
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($connection);
			}
		}	
	}	
	else  {
		if (!empty($_POST['delete_cat']) and $user['status'] == 'admin') {	
			foreach ($_POST['delete_cat'] as $option) {
				$result = mysqli_query($connection, "DELETE FROM `categories` WHERE `categories`.`id` = $option");
				if (!$result) {
					echo mysqli_error($connection);
				}
			}
		}	
		if (!empty($_POST['delete_art']) and $user['status'] == 'admin') {		
			foreach ($_POST['delete_art'] as $option) {
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