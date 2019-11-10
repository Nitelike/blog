<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Вход в аккаунт</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/login.css?version=1.0">
</head>
<body>
	<?php include '../includes/topnav.php' ?>

	<div class="container wrapper">
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
								header('Location: home.php');
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
			<div class="input-holder">
				<input name="login" type="text" placeholder="Логин" value="<?php echo @$data['login'] ?>" maxlength="20">
			</div>

			<div class="input-holder">
				<input name="password" type="password" placeholder="Пароль" value="<?php echo @$data['password'] ?>" maxlength="30">
			</div>

			<div class="input-holder">
				<button class="send-button" name="to_login" type="submit">Войти</button>
			</div>	
		</form>
		
		<span>Если у вас нет аккаунта, вы можете <a class="inform-link" href="register.php">cоздать аккаунт</a>	</span>
		<br>
		<span>Если у вас нет доступа к аккаунту, вы можете <a class="inform-link" href="recover.php">восстановить</a> его, зная адрес электронной почты, которая была привязана к аккаунту.</span>	
	</div>	
</body>
</html>
<?php mysqli_close($connection) ?>