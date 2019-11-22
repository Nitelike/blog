<?php 
	require '../includes/config.php';
	if (isset($_SESSION['user'])) {
		?>
		<!DOCTYPE html>
		<html lang="ru">
		<head>
			<meta charset="UTF-8">
			<title>Смена данных - <?php echo $params['title'] ?></title>	
			<?php include '../includes/common-header.php' ?>
			<link rel="stylesheet" type="text/css" href="../css/login.css?version=1.0">
		</head>
		<body>
			<?php include '../includes/header.php' ?>

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
				<?php 
					if (isset($_POST['to_change'])) {
						$errors = array();
						$data = $_POST;
						require '../includes/get-user.php';
						if (trim($data['name']) != '') {
							$name = mysqli_real_escape_string($connection, trim($data['name']));
							$query = mysqli_query($connection, "SELECT `name` FROM `users` WHERE `name` = '$name'");
							if (mysqli_num_rows($query) == '') {
								$query = mysqli_query($connection, "UPDATE `users` SET `name` = '$name' WHERE `users`.`id` = $user_id;");
								echo "<script>window.location.href='user.php';</script>";
								
							}
							else {
								$errors[] = 'Пользователь с логином "'. $name . '" уже существует';
							}
						}
						if (trim($data['password']) != '' or trim($data['new_password']) != '' or trim($data['confirm_new_password']) != '') {
							$password = trim($data['password']);
							$new_password = trim($data['new_password']);
							if (password_verify($password, $user['password']) and $new_password == trim($data['confirm_new_password'])) {
								$password = password_hash($new_password, PASSWORD_DEFAULT);
								$query = mysqli_query($connection, "UPDATE `users` SET `password` = '$password' WHERE `users`.`id` = $user_id;");
								echo '<div class="success-block">Password was changed!</div>';
							}
							else if (!password_verify($password, $user['password'])) {
								$errors[] = 'Неправильный пароль от аккаунта';
							}
							else if ($new_password != trim($data['confirm_new_password'])) {
								$errors[] = 'Новые пароли не совпадают';
							}
						}
						if (count($errors) > 0) {
							echo '<div class="error-block">' . $errors[0] . '</div>';
						}
					}
				?>

				<form action="user.php" method="post">
					<table>
						<tr>
							<td><label for="name">Новый логин</label></td>
							<td><input name="name" type="text" value="<?php echo @$data['name'] ?>" maxlength="30"></td>
						</tr>

						<tr>
							<td><label for="password">Пароль</label></td>
							<td><input name="password" type="password" value="<?php echo @$data['password'] ?>" maxlength="30"></td>
						</tr>

						<tr>
							<td><label for="new_password">Новый пароль</label></td>
							<td><input name="new_password" type="password" value="<?php echo @$data['new_password'] ?>" maxlength="30"></td>
						</tr>

						<tr>
							<td><label for="confirm_new_password">Повторить новый пароль</label></td>
							<td><input name="confirm_new_password" type="password" value="<?php echo @$data['confirm_new_password'] ?>" maxlength="30"></td>
						</tr>

						<tr>
							<td><button class="send-button" name="to_change" type="submit">Изменить</button></td>
						</tr>	
					</table>
				</form>

				<form action="../includes/logout.php" method="post">
					<table>
						<tr>
							<td><button class="send-button" type="submit">Выйти</button></td>
						</tr>
					</table>	
				</form>
			</section>	
		</body>
		</html>
	<?php
	}
	else {
		echo 'Чего?';
	}
?>