<?php
	require '../includes/config.php';
	if (isset($_GET['vkey'])) {
		$vkey = $_GET['vkey'];
		$query = mysqli_query($connection, "SELECT * FROM `users` WHERE `vkey` = '$vkey' LIMIT 1");
		if (mysqli_num_rows($query) !== false) {
			$user = mysqli_fetch_assoc($query);
			$id = $user['id'];
			if ($user['vkey'] == $vkey and $user['verified'] == 0) {
				mysqli_query($connection, "UPDATE users SET verified = 1 WHERE `users`.`id` = $id");
				echo 'Адрес электронной почты успешно подтвержден. Теперь нужно войти в ваш аккаунт';
				header('Location: login.php');
			}
			else {
				echo 'Неправильный ключ подтверждения';
			}
		}
	}
	else {
		echo 'Что-то пошло не так';
	}