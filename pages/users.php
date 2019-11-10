<?php 
	require '../includes/config.php';
	require '../includes/get-user.php';
	if (isset($_SESSION['user']) and $user['status'] == 'admin') {
		
		?>
		<!DOCTYPE html>
		<html lang="ru">
		<head>
			<meta charset="UTF-8">
			<title><?php echo $params['title'] ?> - Пользователи</title>	
			<?php include '../includes/common-header.php' ?>
			<link rel="stylesheet" type="text/css" href="../css/users.css">
			<script src="../js/jquery-3.4.1.min.js"></script>
			<script src="../js/status.js"></script>
			<script src="../js/block.js"></script>
		</head>
		<body>
			<?php include '../includes/topnav.php' ?>

			<div class="toptoolmenu container wrapper">
				<?php include '../includes/content-manager-aside-content.php' ?>
			</div>
			
			<div class="container">
				<table>
					<tr>
						<th>Логин</th>
						<th>Почта</th>
						<th>Подтвержден</th>
						<th>Создан</th>
						<th>Статус</th>
						<th>Изменить статус</th>
						<th>Блокировка</th>
					</tr>
					<?php 
						$users = mysqli_query($connection, "SELECT * FROM `users` ORDER BY `name`");
						if (mysqli_num_rows($users) > 0) {
							while ($other_user = mysqli_fetch_assoc($users)) { ?>
								<tr>
									<td><?php echo $other_user['name'] ?></td>
									<td><?php echo $other_user['email'] ?></td>
									<td id="ver-<?php echo $other_user['id'] ?>"><?php echo $other_user['verified'] ?></td>
									<td><?php echo $other_user['created'] ?></td>
									<td id="<?php echo $other_user['id'] ?>"><?php echo $other_user['status'] ?></td>
									<td><button type="button" onclick="Status(<?php echo $other_user['id'] ?>)">Изменить</button></td>
									<td><button id="but-ver-<?php echo $other_user['id'] ?>" type="button" onclick="Block(<?php echo $other_user['id'] ?>)">
										<?php
											if ($other_user['verified'] == -1) {
												echo 'Разблокировать';
											}
											else {
												echo 'Блокировать';
											}
										?>
									</button></td>
								</tr>
								<?php
							}
						}
						
					?>
				</table>
			</div>	
		</body>
		</html>
<?php }?>