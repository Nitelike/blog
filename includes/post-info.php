<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/rate.js"></script>
<div class="post-info">
	<a class="post-title" href="article.php?id=<?php echo $post['id'] ?><?php echo @$change_info ?>">
		<span><?php echo $post['title'] ?></span>
	</a>
	<small class="categories">
		<?php
			$categories = mysqli_query($connection, 'SELECT * FROM `categories`');
			if (mysqli_num_rows($categories) > 0)
				$post_categories = $post['category_id'];
				$counter = 0;
				while ($cat = mysqli_fetch_assoc($categories)) {
					if (strpos($post_categories, ' ' . $cat['id'] . ',') !== false) {
						if ($counter >= 1) {
							echo ',';
						}
						?>
						<a href="category.php?cat=<?php echo $cat['id'] ?>"><?php echo $cat['title'] ?></a><?php
						$counter++;
					}				
				}
		?>
	</small>
	<div class="post-meta">
		<small class="likes">
			<button id="likes-<?php echo $post['id'] ?>" type="button" onclick="Rating(<?php echo $post['id'] ?>, 1, 'likes-<?php echo $post['id'] ?>')">&#5123; <?php echo $post['likes'] ?></button>
	    </small>
		<small class="dislikes">
			<button id="dislikes-<?php echo $post['id'] ?>" type="button" onclick="Rating(<?php echo $post['id'] ?>, 0, 'dislikes-<?php echo $post['id'] ?>')">&#5121; <?php echo $post['dislikes'] ?></button>
		</small>
		<small class="views">Просмотры: <?php echo $post['views'] ?></small>
		<small class="pubdate">Дата: <?php for($i = 0; $i < 10; $i++) {echo $post['pubdate'][$i];}  ?></small>
	</div>
</div>