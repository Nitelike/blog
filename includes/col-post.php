<?php
	$src = -1;
	$index = strpos($post['text'], '<img src="');
	if ($index !== false) {
		$index += 10;
		$last_index = strpos(substr($post['text'], $index), '"');
		if ($last_index !== false) {
			$src = substr($post['text'], $index, $last_index);
		}
	}
	?>
	<div class="content-col">
		<?php
			if ($src != -1) { ?>
				<div class="image-wrapper">
					<a href="article.php?id=<?php echo $post['id'] ?>">
						<img class="article-icon" src="<?php echo $src ?>" alt="article-icon">
					</a>	
				</div>
			<?php } ?>
		
		<?php 
			include '../includes/post.php';	
			$counter++;	
		?>
		<a class="button-link" href="article.php?id=<?php echo $post['id'] ?>">Читать дальше</a>
	</div>