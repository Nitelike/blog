<a class="<?php currentUrl('user') ?>" href="user.php">Смена данных</a>

<a class="<?php currentUrl('tracked') ?>" href="tracked.php">Избранные</a>

<?php
	if (isset($_SESSION['user']) and ($user['status'] == 'editor' or $user['status'] == 'admin')) { ?>
	<span>Управление контентом</span>

	<div class="manage-options">
		<small><?php include '../includes/content-manager-aside-content.php' ?></small>
	</div>
<?php } ?>