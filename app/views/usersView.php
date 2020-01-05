<section class="left">
	<?php include_once '../app/views/user/titleView.php' ?>

	<form method="post" action="<?=$data['path']?>/public/users/find">
		<input required="true" placeholder="Имя пользователя" type="text" name="key" value="<?php if(isset($data['key'])) {echo $data['key'];} ?>">
		<button type="submit" class="btn common-link">Найти</button>
	</form>
	<br>

	<table class="table-list">
		<tr>
			<th>Логин</th>
			<th>Почта</th>
			<th>Создан</th>
			<th>Подтвержден</th>
			<th>Статус</th>
			<th></th>
		</tr>

		<?php foreach($data['users'] as $user) { ?>
		<tr>
			<td><?=$user['name']?></td>
			<td><?=$user['email']?></td>
			<td><?=$user['created']?></td>
			<td><?=$user['verified']?></td>
			<td><?=$user['status']?></td>
			<td>
				<br>
				<a href="<?=$data['path']?>/public/users/update/<?=$user['id']?>" class="common-link btn">Изменить</a>
				<br> <br>
				<a href="<?=$data['path']?>/public/users/block/<?=$user['id']?>" class="common-link btn btn-alert">Блокировать</a>
				<br> <br>
				<a href="<?=$data['path']?>/public/users/delete/<?=$user['id']?>" class="common-link btn btn-alert">Удалить</a>
				<br>
				<br>
			</td>
		</tr>
		<?php } ?>
	</table>
</section>