<?php 
	$url = $_SERVER['REQUEST_URI'];
	if (strpos($url, 'create_article') === false) {
		echo '<a href="content-manager.php?mode=create_article">Добавить статью</a>';
	}
	if (strpos($url, 'add_category') === false) {
		echo '<a href="content-manager.php?mode=add_category">Добавить категорию</a>';
	}
	if (strpos($url, 'find_for_delete') === false) {
		echo '<a href="content-manager.php?mode=find_for_delete">Удалить</a>';
	}
	if (strpos($url, 'update') === false) {
		echo '<a href="content-manager.php?mode=update">Изменить</a>';
	}
