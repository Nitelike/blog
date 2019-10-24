<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Login</title>	
	<link rel="stylesheet" type="text/css" href="../css/main.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/login.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/topnav.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/aside.css?version=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<?php include '../includes/topnav.php' ?>
	<?php include '../includes/aside.php' ?>	

	<div class="content">
		<?php 
			if (isset($_POST['to_login'])) {
				$errors = array();
				$data = $_POST;
				if (trim($data['login']) == '') {
					$errors[] = 'Enter login';
				}
				if (trim($data['password']) == '') {
					$errors[] = 'Enter password';
				}
				if (count($errors) > 0) {
					echo '<div class="error-block">' . $errors[0] . '</div>';
				}
				else {
					$name = mysqli_real_escape_string($connection, trim($data['login']));
					$query = mysqli_query($connection, "SELECT `id`, `name`, `password` FROM `users` WHERE `name` = '$name'");
					if (mysqli_num_rows($query) !== false) {
						$user = mysqli_fetch_assoc($query);
						if ($user['name'] == $name and password_verify(trim($data['password']), $user['password'])) {
							$_SESSION['user'] = $user['id'];
							echo '<div class="success-block">Signed in succesfuly!</div>';
							header('Location: home.php');
						}
						else {
							$errors[] = 'There is no this user';
						}
					}
					else {
						$errors[] = 'There is no this user';
					}
					if (count($errors) > 0) {
						echo '<div class="error-block">' . $errors[0] . '</div>';
					}
				}
			}
		?>

		<form action="login.php" method="post">
			<div class="input-holder">
				<input name="login" type="text" placeholder="Login" value="<?php echo @$data['login'] ?>" maxlength="30">
			</div>

			<div class="input-holder">
				<input name="password" type="password" placeholder="Password" value="<?php echo @$data['password'] ?>" maxlength="30">
			</div>

			<div class="input-holder">
				<button name="to_login" type="submit">Sign in</button>
			</div>	
		</form>
		
		<span>If you don't have an account, you can create it</span>
		<a href="register.php">Create account</a>	
	</div>	
</body>
</html>
<?php mysqli_close($connection) ?>