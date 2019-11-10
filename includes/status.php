<?php
	require '../includes/config.php';
	if (!empty($_POST['user_rating_id'])) {
		if (isset($_SESSION['user'])) {
			$id = $_POST['user_rating_id'];
			$changed_user = mysqli_query($connection, "SELECT `id`, `status` FROM `users` WHERE `id` = $id");
			if (mysqli_num_rows($changed_user) > 0) {
				$changed_user = mysqli_fetch_assoc($changed_user);
				$status = 'member';
				if ($changed_user['status'] == 'member') {
					$status = 'editor';
				}
				else if ($changed_user['status'] == 'admin') {
					$status = 'admin';
				}
				mysqli_query($connection, "UPDATE `users` SET `status` = '$status'WHERE `users`.`id` = $id");
				echo $status;
			}
		}
	}