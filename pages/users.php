<?php 
	require '../includes/config.php';
	require '../includes/get-user.php';
	if (isset($_SESSION['user']) and $user['status'] == 'admin') {
		
		?>
		<!DOCTYPE html>
		<html lang="ru">
		<head>
			<meta charset="UTF-8">
			<title>Пользователи - <?php echo $params['title'] ?></title>	
			<?php include '../includes/common-header.php' ?>
			<link rel="stylesheet" type="text/css" href="../css/users.css">
			<script src="../js/jquery-3.4.1.min.js"></script>
			<script src="../js/status.js"></script>
			<script src="../js/block.js"></script>
		</head>
		<body>
			<?php include '../includes/header.php' ?>

			<aside><?php 
				function currentUrl($url)
				{
					if (strpos($_SERVER['REQUEST_URI'], $url) !== false) {
						echo 'current-page';
					}
				}
			include '../includes/user-page-aside.php';
				
			?></aside>

			<div class="additional"><?php include '../includes/user-page-aside.php'; ?></div>
			
			<section class="side-section">
				<form action="users.php" method="get">
					<input  name="search-user" type="text" placeholder="Поиск по пользователям" value="<?php echo @$_GET['search-user'] ?>">
					<button class="send-button">Поиск</button>
				</form>

				<br>

				<div class="page_subtitle">
					<span>Пользователи</span>
				</div>

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
						if (!isset($_GET['search-user'])) {
							$users = mysqli_query($connection, "SELECT * FROM `users` ORDER BY `name`");
						}
						else {
							$search_user = mysqli_real_escape_string($connection, trim($_GET['search-user']));
							if ($search_user) {
								$users = mysqli_query($connection, "SELECT * FROM `users` WHERE `name` = '$search_user'");
							}
							else {
								$users = mysqli_query($connection, "SELECT * FROM `users` ORDER BY `name`");
							}
						} 

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
						else { ?>
							<div class="page_subtitle">
								<span>
									Нет пользователей
								</span>
							</div>
						<?php }
						
					?>
				</table>
			</section>	
		</body>
		</html>
<?php } ?>