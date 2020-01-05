<section class="left">
	<?php require_once '../app/views/user/titleView.php'; ?>
	<div class="msg-success"><?=$data['response']['success'][0]?></div>
	<div class="msg-alert"><?=$data['response']['errors'][0]?></div>
	<form class="user-form" method="post" action="<?=$data['path']?>/public/user/change">
		<label for="login">Логин</label>
		<input type="text" name="login" value="<?=$data['login']?>" maxlength="25">
		<label for="password">Пароль</label>
		<input type="password" name="password">
		<label for="password">Новый пароль</label>
		<input type="password" name="new_password">
		<label for="password">Подтвердить новый пароль</label>
		<input type="password" name="confirm_new_password">
		<button class="btn" type="submit">Изменить</button>
	</form>
</section>