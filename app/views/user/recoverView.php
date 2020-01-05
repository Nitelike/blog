<section>
	<?php require_once '../app/views/user/titleView.php'; ?>
	<div class="msg-success"><?=$data['response']['success'][0]?></div>
	<div class="msg-alert"><?=$data['response']['errors'][0]?></div>
	<form class="user-form" method="post" action="<?=$data['path']?>/public/user/recover">
		<label for="email">Адрес электронной почты</label>
		<input type="email" name="email" required="true">
		<button class="btn" type="submit">Отправить</button>
		<br> <br>
		<span>На указанный адрес электронной почты будут отправлены данные от аккаунта, привязянного к адресу электронной почты</span>
	</form>
</section>