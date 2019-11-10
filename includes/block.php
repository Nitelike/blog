<?php
	require '../includes/config.php';
	if (!empty($_POST['user_id'])) {
		if (isset($_SESSION['user'])) {
			$id = $_POST['user_id'];
			$changed_user = mysqli_query($connection, "SELECT `id`, `verified`, `status` FROM `users` WHERE `id` = $id");
			if (mysqli_num_rows($changed_user) > 0) {
				$changed_user = mysqli_fetch_assoc($changed_user);
				$ver = 0;
				if ($changed_user['verified'] == 1) {
					$ver = -1;
				}
				else if ($changed_user['verified'] == -1) {
					$ver = 1;
				}
				if ($changed_user['status'] != 'admin') {
					mysqli_query($connection, "UPDATE `users` SET `verified` = '$ver'WHERE `users`.`id` = $id");
					echo $ver;
				}
				else {
					echo $changed_user['verified'];
				}	
			}
		}
	}