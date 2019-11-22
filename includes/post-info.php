<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/track.js"></script>
<div class="post-info">
	<a class="post-title" href="article.php?id=<?php echo $post['id'] ?><?php echo @$change_info ?>">
		<span><?php echo $post['title'] ?></span>
	</a>
	<div>
		<small class="categories">
			<?php
				$post_category = str_replace(' ', '', $post['category_id']);
				$post_category = str_replace(',', '', $post['category_id']);
				$post_category = intval($post_category);
				$cat = mysqli_query($connection, "SELECT * FROM `categories` WHERE `id` = $post_category");
				if (mysqli_num_rows($cat) > 0) { $cat = mysqli_fetch_assoc($cat); ?>

				<a href="category.php?cat=<?php echo $cat['id'] ?>"><?php echo $cat['title'] ?></a>	
			<?php } ?>
		</small>
		<div class="post-meta">
			<span class="track"><button id="track-<?php echo $post['id'] ?>" type="button" onclick="track(<?php echo $post['id'] ?>)">
				<?php
					if (isset($_SESSION['user'])) {
						if (strpos($user['tracked_articles'], ' ' . $post['id'] . ',') !== false) {
							echo "&starf;";
						}
						else {
							echo "&star;";
						}
					}
					else {
							echo "&star;";
						}
				?>
			</button></span>
			<small class="views">Просмотры: <?php echo $post['views'] ?></small>
			<small class="pubdate">Дата: <?php for($i = 0; $i < 10; $i++) {echo $post['pubdate'][$i];}  ?></small>
		</div>
	</div>
</div>