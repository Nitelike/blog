<aside>
	<span>Search</span>
	<hr>
	<form method="get" action="../pages/search-results.php" autocomplete="off">
		<div class="inline-wrapper">
			<input type="text" placeholder="Search" name="search_key" value="<?php if (isset($key)) {echo $key;} ?>">
			<input type="submit" value="Search">
		</div>
		
	</form>	
	<span>Show posts</span>
	<hr>
	<form method="get" action="../pages/home.php">
		<div>
			<label for="max-count">Amount</label>
			<select name="max-count">
				<option value="10" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == '10') { echo 'selected'; } ?>>10</option>
				<option value="50" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == '50') { echo 'selected'; } ?>>50</option>
				<option value="100" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == '100') { echo 'selected'; } ?>>10</option>
				<option value="all" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == 'all') { echo 'selected'; } ?>>All</option>
			</select>
		</div>
		<div>
			<label for="sort_by">Sort by</label>
			<select name="sort_by">
				<option value="pubdate" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'pubdate') { echo 'selected'; } ?>>Date</option>
				<option value="views" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'views') { echo 'selected'; } ?>>Views</option>
				<option value="likes" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'likes') { echo 'selected'; } ?>>Likes</option>
				<option value="dislikes" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'dislikes') { echo 'selected'; } ?>>Dislikes</option>
			</select>
		</div>
		<div>
			<label for="order">Order</label>
			<select name="order">
				<option value="DESC" <?php if (!empty($_GET['order']) and $_GET['order'] == 'DESC') { echo 'selected'; } ?>>Descending</option>
				<option value="ASC" <?php if (!empty($_GET['order']) and $_GET['order'] == 'ASC') { echo 'selected'; } ?>>Ascending</option>
			</select>
		</div>
		<input type="submit" value="Sort">	
	</form>
	<span>Categories</span>
	<hr>
	<?php 
		$categories = mysqli_query($connection, "SELECT * from `categories`");
		if (mysqli_num_rows($categories) > 0) {
			while ($category = mysqli_fetch_assoc($categories)) {
				?>
				<a href="category.php?cat=<?php echo $category['id'] ?>"><?php echo $category['title'] ?></a>					
				<?php
			}
		}
						
	?>
</aside>