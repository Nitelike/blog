<span>Читать еще</span>
<hr>
<?php
	$current_article = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = $article_id"));
	$category_id = $current_article['category_id'];
	$category = mysqli_fetch_assoc(mysqli_query($connection, "SELECT `id`, `title` FROM `categories` WHERE `id` = '$category_id'"));
	if ($articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `pubdate` DESC")) {
		if (mysqli_num_rows($articles) !== false) {
			$limit = 0;
			while ($post = mysqli_fetch_assoc($articles)) {	
				if ($post['id'] != $article_id and strpos($post['category_id'], $category_id) !== false and $limit < 6) { ?>
					<div class="read-more-item">
						<div>
							<a href="article.php?id=<?php echo $post['id'] ?><?php echo @$change_info ?>">
								<?php echo $post['title'] ?>
							</a>
						</div>
						<div class="categories">
							<small>
								<a href="category.php?cat=<?php echo $category['id'] ?>"><?php echo $category['title'] ?></a>	
							</small>
						</div>
					</div>
					<?php
					$limit++;
				}
			}
		}
	}
