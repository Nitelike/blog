<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Сообщение администратору</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>

	<div class="container wrapper">
		<?php 
			if (isset($_SESSION['user'])) {
				include '../includes/get-user.php';
			}
			if (isset($_POST['send'])) {
				$errors = array();
				$data = $_POST;
				if (trim($data['login']) == '') {
					$errors[] = 'Введите имя';
				}
				if (trim($data['text']) == '') {
					$errors[] = 'Введите текст';
				}
				if (count($errors) > 0) {
					echo '<div class="error-block">' . $errors[0] . '</div>';
				}
				else {
					$name = mysqli_real_escape_string($connection, trim($data['login']));
					$text = mysqli_real_escape_string($connection, trim($data['text']));
					$email = mysqli_real_escape_string($connection, trim($data['email']));
					$query = mysqli_query($connection, "INSERT INTO `complains` (author, text, author_email) VALUES ('$name', '$text', '$email')");
					echo '<script>window.close();</script>';

				}
			}
		?>

		<form action="" method="post">
			<div class="input-holder">
				<input required="true" name="login" type="text" placeholder="Имя" <?php if (isset($user['name'])) {
					echo 'readonly';}?> value="<?php echo @$user['name'] ?>" maxlength="20" value="<?php echo @$_POST['name'] ?>">
			</div>

			<div class="input-holder">
				<input name="email" type="email" placeholder="Адрес электронной почты" value="<?php echo @$user['email'] ?>" maxlength="30">
			</div>

			<div class="input-holder">
				<textarea required="true" name="text" maxlength="300" placeholder="Текст (300 символов)"><?php echo @$_POST['text'] ?></textarea>
			</div>

			<div class="input-holder">
				<button class="send-button" name="send" type="submit">Отправить</button>
			</div>	
		</form>
		
		<span>Это сообщение будет отправлено редакторам и администраторам сайта</span>
		<br>
		<span>Адрес электронной почты нужен только для обратной связи. Но его можно не указывать</span>
	</div>	
</body>
</html>
<?php mysqli_close($connection) ?>