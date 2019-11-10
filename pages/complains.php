<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../includes/config.php' ?>
	<?php require '../includes/get-user.php'; if(isset($_SESSION['user']) and @$user['status'] == 'admin' or @$user['status'] == 'editor') { ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Сообщения</title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/users.css">
</head>
<body>
	<?php include '../includes/topnav.php' ?>

	<div class="toptoolmenu container wrapper">
		<?php include '../includes/content-manager-aside-content.php' ?>
	</div>

	<div class="header-subtitle">
		<span>Сообщения</span>
	</div>
		<div class="container">

			<?php 
				if (isset($_GET['delete-complain'])) {
					$id = $_GET['id'];
					mysqli_query($connection, "DELETE FROM `complains` WHERE `complains`.`id` = $id");
				}		

				$complains = mysqli_query($connection, "SELECT * FROM `complains` ORDER BY `date`");
				if (mysqli_num_rows($complains) > 0) { ?>
					<table>
						<tr>
							<th>Автор</th>
							<th>Почта</th>
							<th>Сообщение</th>
							<th>Добавлено</th>
							<th>Удалить</th>
						</tr>
					<?php
					while ($complain = mysqli_fetch_assoc($complains)) { ?>
							<tr>
								<td><?php echo $complain['author'] ?></td>
								<td><?php echo $complain['author_email'] ?></td>
								<td><?php echo $complain['text'] ?></td>
								<td><?php echo $complain['date'] ?></td>
								<td>
									<form action="" method="get">
										<input class="disabled" name="id" value="<?php echo $complain['id'] ?>">
										<button name="delete-complain" type="submit">Удалить</button>
									</form>	
								</td>
							</tr>
						<?php }	
					echo '</table>';							
				}	
				else {
					?>
						<div class="header-subtitle">
							<span>
								Нет сообщений
							</span>
						</div>
					<?php
				}	
		?>
	</div>
</body>
</html>
<?php mysqli_close($connection) ?>
<?php } ?>
