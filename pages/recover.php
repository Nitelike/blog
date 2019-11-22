<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Восстановление</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/login.css?version=1.0">
</head>
<body>
	<?php include '../includes/header.php' ?>

	<section>
		<?php 
			$errors = array();
			if (isset($_POST['recover'])) {	
				$data = $_POST;
				
				$email = $data['email'];
				$user = mysqli_query($connection, "SELECT `name`, `password`, `email`, `verified` FROM `users` WHERE `email` = '$email' LIMIT 1");
				if (mysqli_num_rows($user) == 1) {
					$user = mysqli_fetch_assoc($user);
					if ($user['verified'] == 1) {
						$mode = $_POST['mode'];
						if ($mode = 'login') {
							$send = 'Логин: ' . $user['name'];
						}
						if ($mode = 'password') {
							$password = str_shuffle($user['name']);
							$hashed_password = password_hash($password, PASSWORD_DEFAULT);
							$change_password = mysqli_query($connection, "UPDATE `users` SET `password` = '$hashed_password' WHERE `email` = '$email'");
							$send = 'Пароль: ' . $password;
						}
						else {
							$send = 'Вы ничего не выбрали для восстановления доступа к аккаунту';
						}
						$name = $user['name'];
						$subject = 'Восстановление аккаунта';
						$message = "Вы получили это сообщение потому что адрес электронной почты $email был указан при восстановлении доступа к аккаунту на сайте '$params[title]'. Если вы регистрировали аккаунт на этом сайте, то вот данные \n\t $send \n Если вы не регистрировали аккаунта на сайте '$params[title]' и получили это письмо случайно, то просто проигнорируйте его.";
							$author = 'Подготовка к экзамену по истории Беларуси';

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
                            echo "На адрес электронной почты $email было отправлено письмо. В нем содержатся данные для восстановления доступа к аккаунту. <br> <br>";
                        } else {
                            echo "Mailer Error: " . $mail->ErrorInfo;
                        }
					}
					else {
						$errors[] = 'У аккаунта не подтвержден адрес электронной почты';
					}
				}
				else {
					$errors[] = 'Пользователь с адресом электронный почты "' . $email . '" не зарегистрирован на сайте';
				}
			}
			if (count($errors) > 0) {
				echo '<div class="error-block">' . $errors[0] . '</div>';
			}
		?>

		<form action="recover.php" method="post">
			<div class="input-holder">
				<span>Выберите, что будет отправлено по указанному адресу</span>
			</div>

			<div class="input-holder">
				<label for="mode">Логин</label>
				<input checked="true" name="mode" type="radio" value="login">
			</div>

			<div class="input-holder">
				<label for="mode">Пароль</label>
				<input type="radio" name="mode" value="password">
			</div>
			
			<div class="input-holder">
				<label for="email">Введите адрес электронной почты, который вы указывали при регистрации на сайте</label>
			</div>
			
			<table>
				<tr>
					<td><label for="email">Адрес электронной почты</label></td>
					<td><input name="email" type="email" value="<?php echo @$data['email'] ?>" required="true"></td>
				</tr>
				<tr>
					<td><button class="send-button" name="recover" type="submit">Отправить письмо</button></td>
				</tr>
			</table>
		</form>	
	</section>	
</body>
</html>
<?php mysqli_close($connection) ?>