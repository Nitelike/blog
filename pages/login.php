<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Вход в аккаунт</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/login.css?version=1.0">
</head>
<body>
	<?php include '../includes/header.php' ?>

	<section>
		<?php 
			if (isset($_POST['to_login'])) {
				$errors = array();
				$data = $_POST;
				if (trim($data['login']) == '') {
					$errors[] = 'Введите логин';
				}
				if (trim($data['password']) == '') {
					$errors[] = 'Введите пароль';
				}
				if (count($errors) > 0) {
					echo '<div class="error-block">' . $errors[0] . '</div>';
				}
				else {
					$name = mysqli_real_escape_string($connection, trim($data['login']));
					$query = mysqli_query($connection, "SELECT `id`, `name`, `password`, `verified` FROM `users` WHERE `name` = '$name'");
					if (mysqli_num_rows($query) !== false) {
						$user = mysqli_fetch_assoc($query);
						if ($user['name'] == $name and password_verify(trim($data['password']), $user['password'])) {
							if ($user['verified'] == 1) {
								$_SESSION['user'] = $user['id'];
								echo "<script>window.location.href='home.php';</script>";
							}
							else {
								$errors[] = 'У этого аккаунта неподтвержденный адрес электронной почты. Подтвердите его, перейдя по ссылке в пиcьме.';
							}
							
						}
						else {
							$errors[] = 'Нет такого пользователя';
						}
					}
					else {
						$errors[] = 'Нет такого пользователя';
					}
					if (count($errors) > 0) {
						echo '<div class="error-block">' . $errors[0] . '</div>';
					}
				}
			}
		?>

		<form action="login.php" method="post">
			<table>
				<tr>
					<td><label for="login">Логин</label></td>
					<td><input name="login" type="text" value="<?php echo @$data['login'] ?>" maxlength="20"></td>
				</tr>
				<tr>
					<td><label for="password">Пароль</label></td>
					<td><input name="password" type="password" value="<?php echo @$data['password'] ?>" maxlength="30"></td>
				</tr>
				<tr>
					<td><button class="send-button" name="to_login" type="submit">Войти</button></td>
				</tr>
			</table>
		</form>

		<br>
		
		<span>Если у вас нет аккаунта, вы можете <a class="inform-link" href="register.php">cоздать аккаунт</a>	</span>
		<br>
		<br>
		<span>Если у вас нет доступа к аккаунту, вы можете <a class="inform-link" href="recover.php">восстановить</a> его, зная адрес электронной почты, которая была привязана к аккаунту.</span>	
	</section>	
</body>
</html>
<?php mysqli_close($connection) ?>