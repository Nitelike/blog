<?php
	if (isset($_SESSION['user'])) {
		$user_id = $_SESSION['user'];
		$user = mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = $user_id");
		if (mysqli_num_rows($user) !== false) {
			$user = mysqli_fetch_assoc($user);
			$user_name = $user['name'];
		}
	}
	