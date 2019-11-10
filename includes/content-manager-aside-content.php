<?php 
	include '../includes/get-user.php';
	$url = $_SERVER['REQUEST_URI'];
	if (strpos($url, 'create_article') === false) {
		echo '<a href="content-manager.php?mode=create_article">Добавить статью</a>';
	}
	if (strpos($url, 'add_category') === false) {
		echo '<a href="content-manager.php?mode=add_category">Добавить категорию</a>';
	}
	if (strpos($url, 'find_for_delete') === false and $user['status'] == 'admin') {
		echo '<a href="content-manager.php?mode=find_for_delete">Удалить</a>';
	}
	if (strpos($url, 'update') === false) {
		echo '<a href="content-manager.php?mode=update">Изменить</a>';
	}
	if (strpos($url, 'users') === false and $user['status'] == 'admin') {
		echo '<a href="users.php">Пользователи</a>';
	}
	if (strpos($url, 'complains') === false) {
		echo '<a href="complains.php">Сообщения</a>';
	}
