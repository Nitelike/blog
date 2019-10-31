<span>Читать еще</span>
<hr>
<?php
	if ($articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate` DESC LIMIT 6")) {
		if (mysqli_num_rows($articles) !== false) {
			while ($post = mysqli_fetch_assoc($articles)) {
				if ($post['id'] != $article_id) { ?>
					<div class="read-more-item">
						<?php include '../includes/post-info.php'; ?>
					</div>
					<?php
				}
			}
		}
	}
