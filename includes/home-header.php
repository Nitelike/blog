<?php require '../includes/get-user.php' ?>
<?php require '../includes/menu-manager.php' ?>
<link rel="stylesheet" type="text/css" href="../css/home-header.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="../js/header.js"></script>

<header>
	<div class="tool-section">
		<button title="Дополнительные функции" class="menu-button" type="button" onclick="showToolbar()"><i class="fa fa-bars"></i><span class="menu-title">Дополнительно</span></button>
		<div id="tool-content">
			<div id="left">
				<a href="home.php">Главная</a>
				
				<div class="dropdown">
					<a onclick="showDistricts()">Области</a>

					<div id="districts-menu" style="display: none;">
						<?php
							$sql = "SELECT `id`, `title` FROM `districts` ORDER BY `title` ASC";
							if ($query = mysqli_query($connection, $sql)) {
								if (mysqli_num_rows($query) > 0) {
									while ($district = mysqli_fetch_assoc($query)) {
										echo "<a href='district.php?district_id=$district[id]'>$district[title]</a>";
									}
								}
							}

						?>
					</div>
				</div>
				
				<a href="about.php">О проекте</a>
			</div>
			
			<div id="right">
				<div class="search-section">
					<form method="get" action="../pages/search-results.php" autocomplete="off">
						<input class="search-input" type="text" placeholder="Поиск по сайту" name="search_key" value="<?php if (isset($key)) {echo $key;} ?>" maxlength="25">
						<button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
					</form>
				</div>
				
				<?php
					if (!isset($_SESSION['user'])) { ?>
						<a href="login.php">Вход</a>
					<?php }
					else { ?>
						<a href="user.php"><?php echo $user_name  ?></a>
					<?php } ?>
				
				<button id="complain-button" title="Сообщить о проблеме модераторам" type="button" onclick="fullwindowpopup()"><span id="exclamation-mark">!</span></button>
			</div>
		</div>
	</div>

	<div class="logo">
		<a href="home.php">	
		<?php echo $params['title'] ?></a>
	</div>

	<div class="categories-section">	
		<button title="Категории" class="menu-button" type="button" onclick="showCategories()"><i style="color: white;" class="fa fa-bars"></i><span class="menu-title" style="color: white;">Категории</span></button>
		<ul id="categories-section">
			<?php
				$categories = mysqli_query($connection, "SELECT `title`, `id` FROM `categories` ORDER BY `id` ASC");
				while ($cat = mysqli_fetch_assoc($categories)) { 
					$id = $cat['id'];
					?>
					<li <?php cur_page("category.php?cat=" . $id) ?>><a href="category.php?cat=<?php echo $id ?>"><?php echo $cat['title'] ?> </a></li>
			<?php } ?>
		</ul>
	</div>
</header>