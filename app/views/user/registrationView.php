<section>
	<?php require_once '../app/views/user/titleView.php'; ?>
	<div class="msg-success"><?=$data['response']['success'][0]?></div>
	<div class="msg-alert"><?=$data['response']['errors'][0]?></div>
	<form class="user-form" method="post" action="<?=$data['path']?>/public/user/create">
		<label for="login">Логин</label>
		<input type="text" name="login" value="<?=$data['login']?>" maxlength="25" required="true" minlength="5">
		<label for="password">Пароль</label>
		<input type="password" name="password" required="true" minlength="5">
		<label for="confirm_password">Подтвердите пароль</label>
		<input type="password" name="confirm_password" required="true" minlength="5">
		<label for="email">Адрес электронной почты</label>
		<input type="email" name="email" required="true">
		<button class="btn" type="submit">Зарегистрировать</button>
		<br> <br>
		<span>Если у вас есть аккаунт, вы можете <a class="common-link" href="<?=$data['path']?>/public/user/login">войти</a> в него</span>
	</form>
</section>