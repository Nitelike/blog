<?php 
	require '../includes/config.php';
	if (isset($_SESSION['user'])) {
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title><?php echo $params['title'] ?> - User</title>	
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
					if (isset($_POST['to_change'])) {
						$errors = array();
						$data = $_POST;
						require '../includes/get-user.php';
						if (trim($data['name']) != '') {
							$name = mysqli_real_escape_string($connection, trim($data['name']));
							$query = mysqli_query($connection, "SELECT `name` FROM `users` WHERE `name` = '$name'");
							if (mysqli_num_rows($query) == '') {
								$query = mysqli_query($connection, "UPDATE `users` SET `name` = '$name' WHERE `users`.`id` = $user_id;");
								header("Refresh:0");
								
							}
							else {
								$errors[] = 'User with name "'. $name . '" already exists';
							}
						}
						if (trim($data['image']) != '') {
							$image_url = trim($data['image']);
							$query = mysqli_query($connection, "UPDATE `users` SET `image_url` = '$image_url' WHERE `users`.`id` = $user_id;");
							header("Refresh:0");
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
								$errors[] = 'You entered invalid password from this account';
							}
							else if ($new_password != trim($data['confirm_new_password'])) {
								$errors[] = 'New passwords don\'t match';
							}
						}
						if (count($errors) > 0) {
							echo '<div class="error-block">' . $errors[0] . '</div>';
						}
					}
				?>

				<form action="user.php" method="post">
					<div class="input-holder">
						<input name="name" type="text" placeholder="New login" value="<?php echo @$data['name'] ?>" maxlength="30">
					</div>

					<div class="input-holder">
						<input name="password" type="password" placeholder="Password" value="<?php echo @$data['password'] ?>" maxlength="30">
					</div>

					<div class="input-holder">
						<input name="new_password" type="password" placeholder="New password" value="<?php echo @$data['new_password'] ?>" maxlength="30">
					</div>

					<div class="input-holder">
						<input name="confirm_new_password" type="password" placeholder="Confirm password" value="<?php echo @$data['confirm_new_password'] ?>" maxlength="30">
					</div>

					<div class="input-holder">
						<input name="image" type="text" placeholder="Image url" value="<?php echo @$data['image'] ?>" autocomplete="off">
					</div>

					<div class="input-holder">
						<button name="to_change" type="submit">Change</button>
					</div>	
				</form>

				<form action="../includes/logout.php" method="post">
					<div class="input-holder">
						<button type="submit">Sign out</button>
					</div>	
				</form>
			</div>	
		</body>
		</html>
	<?php
	}
	else {
		echo 'lol';
	}
?>