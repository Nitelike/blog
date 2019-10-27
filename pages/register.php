<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Регистрация</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/login.css?version=1.0">
</head>
<body>
	<?php include '../includes/topnav.php' ?>

	<div class="wrapper">
		<?php 
			if (isset($_POST['to_register'])) {
				$errors = array();
				$data = $_POST;
				if (trim($data['login']) == '') {
					$errors[] = 'Введите логин';
				}
				if (trim($data['password']) == '') {
					$errors[] = 'Введите пароль';
				}
				if ($data['password-2'] != $data['password']) {
					$errors[] = 'Пароли не совпадают';
				}
				if (count($errors) > 0) {
					echo '<div class="error-block">' . $errors[0] . '</div>';
				}
				else {
					$name = mysqli_real_escape_string($connection, trim($data['login']));
					$password = password_hash(trim($data['password']), PASSWORD_DEFAULT);
					if (mysqli_num_rows(mysqli_query($connection, "SELECT `name` FROM `users` WHERE `name` = '$name'")) > 0) {
						$errors[] = 'Пользователь с логином "' . $name . '" уже существует';
						echo '<div class="error-block">' . $errors[0] . '</div>';
					}
					else {
						$sql = "INSERT INTO users (name, password) VALUES ('$name', '$password')";
						if (mysqli_query($connection, $sql)) {
							$query = mysqli_query($connection, "SELECT `id`, `name`, `password` FROM `users` WHERE `name` = '$name'");
							if (mysqli_num_rows($query) !== false) {
								$user = mysqli_fetch_assoc($query);
								if ($user['name'] == $name and password_verify(trim($data['password']), $user['password'])) {
									$_SESSION['user'] = $user['id'];
									header('Location: home.php');
								}
							}
						}
					}	
				}
			}
		?>

		<form action="register.php" method="post">
			<div class="input-holder">
				<input name="login" type="text" placeholder="Логин" value="<?php echo @$data['login'] ?>" maxlength="30">
			</div>

			<div class="input-holder">
				<input name="password" type="password" placeholder="Пароль" value="<?php echo @$data['password'] ?>" maxlength="30">
			</div>

			<div class="input-holder">
				<input name="password-2" type="password" placeholder="Подтвердите пароль" value="<?php echo @$data['password-2'] ?>" maxlength="30">
			</div>

			<div class="input-holder">
				<button class="send-button" name="to_register" type="submit">Зарегистрировать</button>
			</div>	
		</form>
		
		<span>Если у вас уже есть аккаунт, Вы можете просто <a class="inform-link" href="login.php">войти</a> в него</span>		
	</div>	
</body>
</html>
<?php mysqli_close($connection) ?>