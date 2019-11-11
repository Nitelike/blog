<?php
	require_once '../includes/config.php';
	require '../includes/get-user.php';
	if (!empty($_POST['track-id'])) {
		if (isset($_SESSION['user'])) {
			$tracked = $user['tracked_articles'];
			$track_id = $_POST['track-id'];
			$is_tracked = strpos($user['tracked_articles'], ' ' . $track_id . ',');
			if ($is_tracked !== false) {
				$new_tracked = str_replace(' ' . $track_id . ',', '', $user['tracked_articles']);
				echo '&star;';
			}
			else {
				$new_tracked = $user['tracked_articles'] . ' ' . $track_id . ',';
				echo '&starf;';
			}
			mysqli_query($connection, "UPDATE `users` SET `tracked_articles` = '$new_tracked' WHERE `users`.`id` = $user_id");
		}
		else {
			echo '&star;';
		}
	}

?>