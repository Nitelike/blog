<section>
	<?php require_once '../app/views/user/titleView.php'; ?>
	<div class="msg-success"><?=$data['response']['success'][0]?></div>
	<div class="msg-alert"><?=$data['response']['errors'][0]?></div>
</section>