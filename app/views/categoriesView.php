<section class="left">
	<?php include_once '../app/views/user/titleView.php' ?>

	<form method="post" action="<?=$data['path']?>/public/categories/find">
		<input required="true" placeholder="Название категории" type="text" name="key" value="<?php if(isset($data['key'])) {echo $data['key'];} ?>">
		<button type="submit" class="btn common-link">Найти</button>
	</form>
	<br>

	<table class="table-list">
		<tr>
			<th>id</th>
			<th>Название</th>
			<th>Описание</th>
			<th></th>
		</tr>

		<tr>
			<form method="post" action="<?=$data['path']?>/public/categories/create">
				<td>
					<span>id</span>
				</td>
				<td>
					<textarea class="title-area" name="title" placeholder="Название" required="true" maxlength="150"></textarea>
				</td>
				<td>
					<textarea class="text-area" name="description" placeholder="Описание"  required="true" maxlength="250"></textarea>
				</td>
				<td>
					<button type="submit" class="btn common-link">Создать</button>
				</td>
			</form>
		</tr>

		<?php foreach($data['categories'] as $category) { ?>
		<tr>
			<form method="post" action="<?=$data['path']?>/public/categories/update/<?=$category['id']?>">
				<td>
					<span><?=$category['id']?></span>
				</td>
				<td>
					<textarea class="title-area" name="title_<?=$category['id']?>" required="true" maxlength="150"><?=$category['title']?></textarea>
				</td>
				<td>
					<textarea class="text-area" name="description_<?=$category['id']?>"  required="true" maxlength="250"><?=$category['description']?></textarea>
				</td>
				<td>
					<button type="submit" class="btn common-link">Изменить</button>
					<br>
					<br>
					<a href="<?=$data['path']?>/public/categories/delete/<?=$category['id']?>" class="common-link btn btn-alert">Удалить</a>
				</td>
			</form>
		</tr>
		<?php } ?>
	</table>
</section>