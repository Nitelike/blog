<span>Поиск</span>
	<hr>
	<form method="get" action="../pages/search-results.php" autocomplete="off">
		<div class="inline-wrapper">
			<input class="search-input" type="text" placeholder="Поиск" name="search_key" value="<?php if (isset($key)) {echo $key;} ?>" maxlength="25">
			<button class="send-button" type="submit">Искать</button>
		</div>
		
	</form>	
	<span>Вывод информации</span>
	<hr>
	<form method="get" action="../pages/home.php">
		<div class="select-options">
			<label for="max-count">Количество</label>
			<select name="max-count">
				<option value="10" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == '10') { echo 'selected'; } ?>>10</option>
				<option value="50" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == '50') { echo 'selected'; } ?>>50</option>
				<option value="100" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == '100') { echo 'selected'; } ?>>100</option>
				<option value="all" <?php if (!empty($_GET['max-count']) and $_GET['max-count'] == 'all') { echo 'selected'; } ?>>Все</option>
			</select>
		</div>
		<div class="select-options">
			<label for="sort_by">Сортировка по</label>
			<select name="sort_by">
				<option value="pubdate" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'pubdate') { echo 'selected'; } ?>>Дате</option>
				<option value="views" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'views') { echo 'selected'; } ?>>Просмотрам</option>
				<option value="likes" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'likes') { echo 'selected'; } ?>>Лайкам</option>
				<option value="dislikes" <?php if (!empty($_GET['sort_by']) and $_GET['sort_by'] == 'dislikes') { echo 'selected'; } ?>>Дизлайкам</option>
			</select>
		</div>
		<div class="select-options">
			<label for="order">Порядок</label>
			<select name="order">
				<option value="DESC" <?php if (!empty($_GET['order']) and $_GET['order'] == 'DESC') { echo 'selected'; } ?>>Убывание</option>
				<option value="ASC" <?php if (!empty($_GET['order']) and $_GET['order'] == 'ASC') { echo 'selected'; } ?>>Возрастание</option>
			</select>
		</div>
		<button class="send-button" type="submit">Показать</button>
	</form>
	<span>Категории</span>
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