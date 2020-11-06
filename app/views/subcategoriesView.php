<section class="left">
	<?php include_once '../app/views/user/titleView.php' ?>

	<form method="post" action="<?=$data['path']?>/public/categories/subfind">
		<input required="true" placeholder="Название подкатегории" type="text" name="key" value="<?php if(isset($data['key'])) {echo $data['key'];} ?>">
		<button type="submit" class="btn common-link">Найти</button>
	</form>
	<br>

	<table class="table-list">
		<tr>
			<th>Название</th>
			<th>id категории</th>
			<th></th>
		</tr>

		<tr>
			<form method="post" action="<?=$data['path']?>/public/categories/subcreate">
				<td>
					<textarea class="title-area" name="title" placeholder="Название" required="true" maxlength="150"></textarea>
				</td>
				<td>
					<textarea class="text-area" name="category_id" placeholder="id категории"  required="true" maxlength="15"></textarea>
				</td>
				<td>
					<button type="submit" class="btn common-link">Создать</button>
				</td>
			</form>
		</tr>

		<?php foreach($data['subcategories'] as $subcategory) { ?>
		<tr>
			<form method="post" action="<?=$data['path']?>/public/categories/subupdate/<?=$subcategory['id']?>">
				<td>
					<textarea class="title-area" name="title_<?=$subcategory['id']?>" required="true" maxlength="150"><?=$subcategory['title']?></textarea>
				</td>
				<td>
					<textarea class="text-area" name="category_id_<?=$subcategory['id']?>"  required="true" maxlength="250"><?=$subcategory['category']?></textarea>
				</td>
				<td>
					<button type="submit" class="btn common-link">Изменить</button>
					<br>
					<br>
					<a href="<?=$data['path']?>/public/categories/subdelete/<?=$subcategory['id']?>" class="common-link btn btn-alert">Удалить</a>
				</td>
			</form>
		</tr>
		<?php } ?>
	</table>
</section>