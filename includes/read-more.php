<span>Читать еще</span>
<hr>
<?php
	$current_article = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = $article_id"));
	if ($articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate` DESC")) {
		if (mysqli_num_rows($articles) !== false) {
			$limit = 0;
			while ($post = mysqli_fetch_assoc($articles)) {	
				if ($post['id'] != $article_id and strpos($post['category_id'], $current_article['category_id']) !== false and $limit < 6) { ?>
					<div class="read-more-item">
						<?php include '../includes/post-info.php'; ?>
					</div>
					<?php
					$limit++;
				}
			}
		}
	}
