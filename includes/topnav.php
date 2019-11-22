<nav>
	<?php require '../includes/get-user.php' ?>
	<?php require '../includes/menu-manager.php' ?>
	<ul class="topnav">
		<?php
			$categories = mysqli_query($connection, "SELECT `title`, `id` FROM `categories` ORDER BY `id` ASC");
			while ($cat = mysqli_fetch_assoc($categories)) { 
				$id = $cat['id'];
				?>
				<li><a href="category.php?cat=<?php echo $id ?>" <?php cur_page("category.php?cat=" . $id) ?>><?php echo $cat['title'] ?></a></li>
			<?php }


		?>
		
	</ul>
</nav>