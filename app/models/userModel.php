<?php

class User extends Model
{
	public function send_mail($subject, $message, $author, $email, $login)
	{
		date_default_timezone_set('Etc/UTC');
		require '../app/libs/PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->Encoding = 'base64';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = '###';
		$mail->Password = "###";
		$mail->setFrom('###', $author);
		$mail->addAddress($email, $login);
		$mail->Subject = $subject;
		$mail->Body = $message;
		//$mail->SMTPDebug = 2;
		//$mail->Debugoutput = 'logHandler';


		if ($mail->send())
		{
			return 1;
		}
		else
		{
			//print_r($mail->ErrorInfo);
			return 0;
		}
	}

	public function find_user($field, $value)
	{
		$sql = "SELECT * FROM `users` WHERE `$field` = '$value'";
		$user = mysqli_query($this->connection, $sql);
		return $user;
	}

	public function login($login, $password)
	{
		$user = $this->find_user('name', $login);

		if($user)
		{
			$user = mysqli_fetch_assoc($user);

			if(password_verify($password, $user['password']))
			{
				if($user['verified'] == 1)
				{
					if(session_status() == PHP_SESSION_NONE)
					{
						session_start();
					}

					$_SESSION['user'] = $user;
				}
				else
				{
					return 'У этого акаунта не подтвержден адрес электронной почты';
				}
			}
			else
			{
				return 'Нет такого пользователя';
			}

			return 0;
		}
		else
		{
			return 'Нет такого пользователя';
		}
	}

	public function change($login, $password, $new_password, $confirm_new_password)
	{
		$errors = array();
		$success = array();

		if(isset($_SESSION['user']))
		{
			$id = $_SESSION['user']['id'];

			$login = mysqli_real_escape_string($this->connection, trim($login));
			$password = mysqli_real_escape_string($this->connection, trim($password));
			$new_password = mysqli_real_escape_string($this->connection, trim($new_password));
			$confirm_new_password = mysqli_real_escape_string($this->connection, trim($confirm_new_password));

			if($login !== '')
			{
				$names = $this->find_user('name', $login);

				if(mysqli_num_rows($names) == '')
				{
					$sql = "UPDATE `users` SET `name` = '$login' WHERE `users`.`id` = $id";
					$query = mysqli_query($this->connection, $sql);
					if(!$query)
					{
						array_push($errors, 'Невозможно изменить имя (ошибка запроса)');
					}
					else
					{
						array_push($success, 'Логин от аккаунта изменен');
					}
				}
				else
				{
					array_push($errors, 'Пользователь с таким именем уже существует');
				}
			}

			if($new_password === $confirm_new_password)
			{
				if($new_password !== '')
				{
					if(password_verify($password, $_SESSION['user']['password']))
					{
						$password = password_hash($new_password, PASSWORD_DEFAULT);
						$sql = "UPDATE `users` SET `password` = '$password' WHERE `users`.`id` = $id";
						$query = mysqli_query($this->connection, $sql);
						if(!$query)
						{
							array_push($errors, 'Невозможно изменить пароль (ошибка запроса)');
						}
						else
						{
							array_push($success, 'Пароль от аккаунта изменен');
						}
					}
					else
					{
						array_push($errors, 'Не введен правильный пароль от аккаунта');
					}
				}
			}
			else
			{
				array_push($errors, 'Новый пароль не совпадает с подтверждением нового пароля');
			}

			$user = $this->find_user('id', $id);
			$user = mysqli_fetch_assoc($user);
			$_SESSION['user'] = $user;
		}
		else
		{
			array_push($errors, 'Не выполнен вход в аккаунт');
		}

		array_push($success, '');
		array_push($errors, '');

		return array('errors' => $errors, 'success' => $success);
	}

	public function create($login, $password, $confirm_password, $email)
	{
		$errors = array();
		$success = array();

		$login = mysqli_real_escape_string($this->connection, trim($login));
		$password = mysqli_real_escape_string($this->connection, trim($password));
		$confirm_password = mysqli_real_escape_string($this->connection, trim($confirm_password));
		$email = mysqli_real_escape_string($this->connection, trim($email));

		if($login !== '')
		{
			$logins = $this->find_user('name', $login);

			if(mysqli_num_rows($logins) == '')
			{
				if($password === $confirm_password)
				{
					$emails = $this->find_user('email', $email);

					if(mysqli_num_rows($emails) == '')
					{
						$password = password_hash($password, PASSWORD_DEFAULT);
						$vkey = password_hash($login, PASSWORD_DEFAULT);
						$sql = "INSERT INTO `users` (`name`, `password`, `email`, `vkey`) VALUES ('$login', '$password', '$email', '$vkey')";
						$query = mysqli_query($this->connection, $sql);

						if($query)
						{
							$title = $this->config->title;

							$subject = 'Подтверждение адреса электронной почты';
							$message = "Вы получили это сообщение потому что адрес электронной почты $email был указан при создании нового аккаунта на сайте \"$title\". Если вы регистрируете аккаунт на этом сайте, то для подтверждения адреса электронной почты перейдите по ссылке \n\t <a href='http://localhost/blog/public/user/verify?vkey=$vkey'>http://localhost/blog/public/user/verify?vkey=$vkey</a> \n Если вы не регистрируете аккаунта на сайте \"$title\" и получили это письмо случайно, то просто проигнорируйте его.";
							$author = "$title";

							if ($this->send_mail($subject, $message, $author, $email, $login))
							{
								array_push($success, "Аккаунт создан! На адрес электронной почты $email было отправлено письмо. Перейдите по ссылке в нем для завершения регистрации.");
							}
							else
							{
								array_push($errors, "Невозможно отправить письмо (ошибка запроса)");
							}	
						}
						else
						{
							array_push($errors, 'Невозможно создать аккаунт (ошибка запроса)');
						}
					}
					else
					{
						array_push($errors, 'Пользователь с таким адресом электронной почты уже существует');
					}
				}
				else
				{
					array_push($errors, 'Введенные пароли не совпадают');
				}
			}
			else
			{
				array_push($errors, 'Пользователь с таким именем уже существует');
			}
		}
		else
		{
			array_push($errors, 'Не введено имя пользователя');
		}

		array_push($success, '');
		array_push($errors, '');

		return array('errors' => $errors, 'success' => $success);
	}

	public function verify($vkey)
	{
		$errors = array();
		$success = array();

		$user = $this->find_user('vkey', $vkey);

		if(mysqli_num_rows($user) !== false)
		{
			
			$user = mysqli_fetch_assoc($user);

			$id = $user['id'];

			$sql = "UPDATE `users` SET `verified` = 1 WHERE `users`.`id` = $id AND `verified` = 0";
			$query = mysqli_query($this->connection, $sql);

			if($query)
			{
				array_push($success, "Адрес электронной почты подтвержден! Теперь вы можете войти в аккаунт");
			}
			else
			{
				array_push($errors, "Невозможно подтвердить адрес электронной почты (ошибка запроса)");
			}
		}
		else
		{
			array_push($errors, "Неправильный ключ подтверждения");
		}

		array_push($success, '');
		array_push($errors, '');

		return array('errors' => $errors, 'success' => $success);
	}

	public function recover($email)
	{
		$errors = array();
		$success = array();

		$user = $this->find_user('email', $email);
		$user = mysqli_fetch_assoc($user);

		if($user)
		{	
			$id = $user['id'];
			$login = $user['name'];

			$password = str_shuffle($user['name']);
			$password_hash = password_hash($password, PASSWORD_DEFAULT);


			$sql = "UPDATE `users` SET `password` = '$password_hash' WHERE `users`.`id` = $id";
			$query = mysqli_query($this->connection, $sql);

			if($query)
			{
				$title = $this->config->title;

				$subject = 'Восстановление данных от аккаунта';
				$message = "Вы получили это сообщение потому что адрес электронной почты $email был указан при восстанолении данных от аккаунта на сайте \"$title\". \n\t Логин: $login \n\t Пароль: $password";
				$author = "$title";

				if ($this->send_mail($subject, $message, $author, $email, $login))
				{
					array_push($success, "На адрес электронной почты $email было отправлено письмо с данными от аккаунта");
				}
				else
				{
					array_push($errors, "Невозможно отправить письмо (ошибка запроса)");
				}	
			}
			else
			{
				array_push($errors, "Невозможно изменить пароль (ошибка запроса)");
			}
		}
		else
		{
			array_push($errors, "Нет пользователя с таким адресом электронной почты");
		}

		array_push($success, '');
		array_push($errors, '');

		return array('errors' => $errors, 'success' => $success);
	}

	public function selected($id)
	{
		$articles = array();
		$user = $this->find_user('id', $id);
		$user = mysqli_fetch_assoc($user);
		$selected = explode(',', $user['tracked_articles']);
		$articles_model = $this->model('Articles');

		foreach ($selected as $article_id)
		{
			$article_id = trim($article_id);
			$sql = "SELECT * FROM `articles` WHERE `id` = '$article_id'";
			$article = mysqli_query($this->connection, $sql);
			if($article)
			{
				$article = mysqli_fetch_assoc($article);
				if($article)
				{
					$article['src'] = $articles_model->get_image_url($article['text']);
					array_push($articles, $article);
				}
			}	
		}
		
		return $articles;
	}

	public function track($article_id)
	{
		$id = $_SESSION['user']['id'];
		$article_id = strval(mysqli_real_escape_string($this->connection, trim($article_id)));
		$article_id = ' ' . $article_id . ',';
		$tracked_articles = $_SESSION['user']['tracked_articles'];

		if(mb_strpos($tracked_articles, $article_id) !== false)
		{
			$tracked_articles = str_replace($article_id, '', $tracked_articles);
		}
		else
		{
			$tracked_articles .= $article_id;
		}
		$sql = "UPDATE `users` SET `tracked_articles` = '$tracked_articles' WHERE `id` = '$id'";
		$query = mysqli_query($this->connection, $sql);
		if($query)
		{
			$user = $this->find_user('id', $id);
			$user = mysqli_fetch_assoc($user);
			$_SESSION['user'] = $user;
			return 1;
		}
		else
		{
			return 0;
		}
	}
}