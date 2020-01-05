<section>
	<?php require_once '../app/views/user/titleView.php'; ?>
	<div class="msg-alert"><?=$data['error']?></div>
	<form class="user-form" method="post" action="<?=$data['path']?>/public/user/login">
		<label for="login">Логин</label>
		<input type="text" name="login" value="<?=$data['login']?>" maxlength="25" required="true">
		<label for="password">Пароль</label>
		<input type="password" name="password" required="true">
		<button class="btn" type="submit">Войти</button>
		<br> <br>
		<span>Если у вас нет аккаунта, вы можете <a class="common-link" href="<?=$data['path']?>/public/user/create">создать</a> его</span>
		<br> <br>
		<span>Если вы потеряли доступ к аккаунту, вы можете <a class="common-link" href="<?=$data['path']?>/public/user/recover">восстановить</a> его, зная адрес электронной почты, к которой привязан аккаунт</span>
	</form>
</section>