<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Регистрация - <?php echo $params['title'] ?></title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/login.css?version=1.0">
</head>
<body>
	<?php include '../includes/header.php' ?>

	<section>
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
					$email = $data['email'];
					$password = password_hash(trim($data['password']), PASSWORD_DEFAULT);
					if (mysqli_num_rows(mysqli_query($connection, "SELECT `name` FROM `users` WHERE `name` = '$name'")) > 0) {
						$errors[] = 'Пользователь с логином "' . $name . '" уже существует';
						echo '<div class="error-block">' . $errors[0] . '</div>';
					}
					else if (mysqli_num_rows(mysqli_query($connection, "SELECT `email` FROM `users` WHERE `email` = '$email'")) > 0) {
						$errors[] = 'Пользователь с таким адресом электронной почты уже существует. Если это ваш аккаунт, вы можете просто <a class="inform-link" href="login.php">войти</a> в него.';
						echo '<div class="error-block">' . $errors[0] . '</div>';
					}
					else {
						$vkey = password_hash($name, PASSWORD_DEFAULT);
						$sql = "INSERT INTO users (name, password, email, vkey) VALUES ('$name', '$password', '$email', '$vkey')";
						if (mysqli_query($connection, $sql)) {
							$subject = 'Подтверждение адреса электронной почты';
							$message = "Вы получили это сообщение потому что адрес электронной почты $email был указан при создании нового аккаунта на сайте \"$params[title]\". Если вы регистрируете аккаунт на этом сайте, то для подтверждения адреса электронной почты перейдите по ссылке \n\t http://glorious-belarus.epizy.com/pages/verify.php?vkey=$vkey \n Если вы не регистрируете аккаунта на сайте \"$params[title]\" и получили это письмо случайно, то просто проигнорируйте его.";
							$author = 'Культурное наследие Беларуси';

                                date_default_timezone_set('Etc/UTC');

                                require '../PHPMailer/PHPMailerAutoload.php';

                                $mail = new PHPMailer;
                                $mail->isSMTP();
                                $mail->CharSet = 'UTF-8';
                                $mail->Encoding = 'base64';

                                $mail->Host = 'smtp.gmail.com';
                                $mail->Port = 587;
                                $mail->SMTPSecure = 'tls';
                                $mail->SMTPAuth = true;
                                $mail->Username = 'belarushistoryexam@gmail.com';
                                $mail->Password = "AMgbED28";

                                $mail->setFrom('belarushistoryexam@gmail.com', $author);
                                $mail->addAddress($email, $name);
                                $mail->Subject = $subject;
                                $mail->Body = $message;

                                if ($mail->send()) {
                                    echo "На адрес электронной почты $email было отправлено письмо. Перейдите по ссылке в нем для завершения регистрации.";
                                } else {
                                    echo "Mailer Error: " . $mail->ErrorInfo;
                                }
						}
					}	
				}
			}
		?>

		<form action="register.php" method="post">
			<table>
				<tr>
					<td><label for="login"></label>Логин</td>
					<td><input name="login" type="text" value="<?php echo @$data['login'] ?>" maxlength="20" required="true"></td>
				</tr>

				<tr>
					<td><label for="password">Пароль</label></td>
					<td><input name="password" type="password" value="<?php echo @$data['password'] ?>" maxlength="30" required="true"></td>
				</tr>

				<tr>
					<td><label for="password-2">Повторите пароль</label></td>
					<td><input name="password-2" type="password" value="<?php echo @$data['password-2'] ?>" maxlength="30" required="true"></td>
				</tr>

				<tr>
					<td><label for="email">Адрес электронной почты</label></td>
					<td><input name="email" type="email" value="<?php echo @$data['email'] ?>" required="true"></td>
				</tr>

				<tr>
					<td><button class="send-button" name="to_register" type="submit">Зарегистрировать</button></td>
				</tr>
			</table>
		</form>

		<br>
		
		<span>Если у вас уже есть аккаунт, Вы можете просто <a class="inform-link" href="login.php">войти</a> в него</span>		
	</section>	
</body>
</html>
<?php mysqli_close($connection) ?>