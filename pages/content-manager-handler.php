<?php 
include '../includes/config.php';
include '../includes/get-user.php';
require '../includes/vcs.php';
if (isset($_SESSION['user']) and $user['status'] == 'editor' or $user['status'] == 'admin') {
	$time = date('Y-m-d H:i:s', time());;
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
				if (!empty($_POST['district'])) {
					$district = ' ' . $_POST['district'] . ',';
				}
				else {
					$district = 0;
				}
				
				if (isset($_POST['lat']) and isset($_POST['lng'])) {
					$lat = floatval(mysqli_real_escape_string($connection, trim($_POST['lat'])));
					$lng = floatval(mysqli_real_escape_string($connection, trim($_POST['lng'])));
				}

				if ($_POST['mode'] == 'create_article') {
					$sql = "INSERT INTO articles (title, text, category_id, last_author, `district_id`, `lat`, `lng`) VALUES ('$title', '$text', '$categories', '$user_name', '$district', '$lat', '$lng')";
				}
				else if ($_POST['mode'] == 'update_article') {
					$update_post_id = $_POST['update_id'];
					$sql = "UPDATE articles SET title = '$title', text = '$text', category_id = '$categories', last_author = '$user_name', pubdate = '$time', `district_id` = '$district', `lat` = '$lat', `lng` = '$lng' WHERE `articles`.`id` = $update_post_id";
					try {
						commit($update_post_id, $title, $user_name, $text, 'article');
					}
					finally {
						echo 'У этой статьи нет репозитория';
						create($update_post_id, $title, $user_name, $text, 'article');
						echo 'А теперь есть';
					}
				}
			}
			else {
				echo 'Вы должны выбрать категорию для статьи';
			}	
		}
		else if ($_POST['mode'] == 'add_category' and $user['status'] == 'admin') {
			$sql = "INSERT INTO categories (title, description, last_author) VALUES ('$title', '$text', '$user_name')";		
		}
		else if ($_POST['mode'] == 'update_category' and $user['status'] == 'admin') {
			$update_category_id = $_POST['update_id'];
			$sql = "UPDATE categories SET title = '$title', description = '$text', last_author = '$user_name', pubdate = '$date' WHERE `id` = $update_category_id";
			commit($update_category_id, $title, $text, 'category');			
		}
		else if ($_POST['mode'] == 'update_district') {
			$update_district_id = $_POST['update_id'];
			$sql = "UPDATE districts SET title = '$title', description = '$text', last_author = '$user_name' WHERE `id` = $update_district_id";
			commit($update_district_id, $title, $text, 'district');	
		}
		else if ($_POST['mode'] == 'add_district') {
			$sql = "INSERT INTO districts (title, description, last_author) VALUES ('$title', '$text', '$user_name')";		
		}
		else if ($_POST['mode'] == 'find_for_delete') {
			require '../includes/delete.php';
		}
		else if ($_POST['mode'] == 'update') {
			require '../includes/update.php';
		}
		if ($_POST['mode']  == 'add_category' or $_POST['mode'] == 'create_article' or $_POST['mode'] == 'update_article' or $_POST['mode'] == 'update_category' or $_POST['mode'] == 'add_district' or $_POST['mode'] == 'update_district') {
			if (mysqli_query($connection, $sql)) {
				echo 'Created';
				echo "<script>window.location.href='home.php';</script>";
				if ($_POST['mode'] == 'create_article') {
					$mode = 'article';
					$id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `articles` ORDER BY `id` DESC LIMIT 1"))['id'];
					create($id, $title, $user_name, $text, $mode);
				}
				else if ($_POST['mode'] == 'add_category') {
					$mode = 'category';
					$id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `categories` ORDER BY `id` DESC LIMIT 1"))['id'];
					create($id, $title, $user_name, $text, $mode);
				}
				else if ($_POST['mode'] == 'add_district') {
					$mode = 'district';
					$id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id` FROM `districts` ORDER BY `id` DESC LIMIT 1"))['id'];
					create($id, $title, $user_name, $text, $mode);
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
		if (!empty($_POST['delete_dis']) and $user['status'] == 'admin') {		
			foreach ($_POST['delete_dis'] as $option) {
				$result = mysqli_query($connection, "DELETE FROM `districts` WHERE `districts`.`id` = $option");
				if (!$result) {
					echo mysqli_error($connection);
				}
			}
		}
		if (!mysqli_error($connection)) {
			echo 'Created';
			echo "<script>window.location.href='content-manager.php?mode=find_for_delete';</script>";
		}	
		else {
			echo mysqli_error($connection);
		}	
	}	
}
?>