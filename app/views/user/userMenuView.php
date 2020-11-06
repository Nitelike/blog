<?php if(isset($_SESSION['user'])) { ?>
<section class="right">
	<a class="common-link line-link" href="<?=$data['path']?>/public/user/change">Настройки аккаунта</a>
	<a class="common-link line-link" href="<?=$data['path']?>/public/user/selected">Избранные</a>
	<?php if($_SESSION['user']['status'] === 'editor' or $_SESSION['user']['status'] === 'admin') { ?>
	<a class="common-link line-link" href="<?=$data['path']?>/public/article/create">Написать статью</a>
	<a class="common-link line-link" href="<?=$data['path']?>/public/categories/subread">Подкатегории</a>
	<a class="common-link line-link" href="<?=$data['path']?>/public/uploads/upload">Загрузить</a>
	<?php } ?>
	<?php if($_SESSION['user']['status'] === 'admin') { ?>
	<a class="common-link line-link" href="<?=$data['path']?>/public/categories/read">Категории</a>
	<a class="common-link line-link" href="<?=$data['path']?>/public/users/read">Пользователи</a>
	<?php } ?>
	<a class="common-link line-link" href="<?=$data['path']?>/public/user/logout">Выйти</a>
</section>
<?php } ?>