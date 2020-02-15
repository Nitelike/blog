<section class="left">
	<?php require_once '../app/views/user/titleView.php'; ?>

	<div class="msg-success"><?=$data['response']['success'][0]?></div>
	<div class="msg-alert"><?=$data['response']['errors'][0]?></div>

	<form action="" method="post" enctype="multipart/form-data">
	    <span>Выберите изображение для загрузки:</span>
	    <br> <br>
	    <input type="file" name="fileToUpload" id="fileToUpload">
	    <br> <br>
	    <input class="btn" type="submit" value="Загрузить" name="submit">
	</form>
</section>