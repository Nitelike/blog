<?php 
	include '../includes/get-user.php';
?>
<a href="content-manager.php?mode=create_article" class="<?php currentUrl('create_article') ?>">Добавить статью</a>

<?php
	if ($user['status'] == 'admin') { ?>
<a href="content-manager.php?mode=add_category" class="<?php currentUrl('add_category') ?>">Добавить категорию</a>

<?php } ?>

<a href="content-manager.php?mode=add_district" class="<?php currentUrl('add_district') ?>">Добавить область</a>

<a href="content-manager.php?mode=find_for_delete" class="<?php currentUrl('find_for_delete') ?>">Удалить</a>

<a href="content-manager.php?mode=update" class="<?php currentUrl('update') ?>">Изменить</a>

<?php
	if ($user['status'] == 'admin') { ?>	
<a href="users.php" class="<?php currentUrl('users') ?>">Пользователи</a>
<?php } ?>	

<a href="complains.php" class="<?php currentUrl('complains') ?>">Сообщения</a>
	
