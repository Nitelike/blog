<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Создать статью</title>	
	<?php include '../includes/get-user.php'; if (isset($_SESSION['user']) and $user['status'] == 'editor' or $user['status'] == 'admin') { ?>
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/article.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/content-manager.css?version=1.0">
	<script src="../js/jquery-3.4.1.min.js"></script>
</head>
<body>
	<?php
	function currentUrl($url)
				{
					if (strpos($_SERVER['REQUEST_URI'], $url) !== false) {
						echo 'current-page';
					}
				}
		include '../includes/header.php';
		include '../includes/vcs.php';
		$mode = $_GET['mode'];
		if ($mode == 'create_article') {
			$mode_name = 'Добавить статью';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Контент";
		}
		else if ($mode == 'add_category') {
			$mode_name = 'Добавить категорию';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Описание категории";
		}
		else if ($mode == 'add_district') {
			$mode_name = 'Добавить область';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Описание области";
		}
		else if ($mode == 'find_for_delete') {
			$mode_name = 'Удалить';
			$title_placeholder = 'Введите название';
		}
		else if ($mode == 'update') {
			$mode_name = 'Изменить';
			$title_placeholder = 'Введите название';
		}
		else if ($mode == 'update_category') {
			$mode_name = 'Изменить категорию';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Описание категории";
			$res = getContent('category');
			$title = $res['title'];
			$author = $res['author'];
			$content =  $res['content'];
		}
		else if ($mode == 'update_article') {
			$mode_name = 'Изменить статью';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Контент";

			$res = getContent('article');
			$title = $res['title'];
			$author = $res['author'];
			$content =  $res['content'];

			$category_id = $res['category_id'];
			$district_id = $res['district_id'];
			$lat = $res['lat'];
			$lng = $res['lng'];
		}
		else if ($mode == 'update_district') {
			$mode_name = 'Изменить область';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Описание";

			$res = getContent('district');
			$title = $res['title'];
			$author = $res['author'];
			$content =  $res['content'];
		}
		?>
		<aside>
			<?php include '../includes/user-page-aside.php'; ?>
		</aside>

		<div class="additional">
			<?php include '../includes/user-page-aside.php'; ?>
		</div>

		<section class="side-section">
		<?php
		if ($mode == 'create_article' or $mode == 'update_article' or $mode == 'add_district' or $mode == 'update_district' or $mode == 'update_category' or $mode == 'add_category') { ?>
			<div>
				<div class="page_subtitle">
					<span>
						Предпросмотр статьи
					</span>
				</div>
				<article class="post-preview">
					<div class="post-content" id="post-prew"></div>		
				</article>
			</div>
			<br>
		<?php } ?>

			<div>
				<?php if (strpos($mode, 'update_') !== false) { ?> 
				<div class="page_subtitle">
					<span>Последний автор статьи</span>
				</div>
				
				<input id="author" type="text" name="author" placeholder="author" readonly="true" value="<?php echo @$author ?>">
				<br>
				<?php } ?>

				<div class="page_subtitle">
					<span>
						<?php echo $mode_name ?>
					</span>
				</div>
				<form action="content-manager-handler.php" method="post" autocomplete="off">
					<input name="mode" value="<?php echo $mode ?>" class="disabled">
					<input name="update_id" value="<?php echo $_GET['id'] ?>"  class="disabled">
					<input id="title" type="text" name="title" placeholder="<?php echo $title_placeholder ?>" required="true" value="<?php echo @$title ?>">
					<?php
						if ($mode == 'create_article' or $mode == 'update_article' or $mode == 'add_district' or $mode == 'update_district' or $mode == 'update_category' or $mode == 'add_category') {
							?>
							<script src="../js/fill-preview.js"></script>
							<script src="../js/add-tag.js"></script>			
							<div class="toolbar">
								<button type="button" onclick="add('<b></b>', 3)"><b>B</b></button>
								<button type="button" onclick="add('<i></i>', 3)"><i>I</i></button>
								<button type="button" onclick="add('<u></u>', 3)"><u>U</u></button>
								<button type="button" onclick="add('<s></s>', 3)"><s>S</s></button>
								<button type="button" onclick="add('<small></small>', 7)"><small>small</small></button>
								<button type="button" onclick="add('<big></big>', 5)"><big>BIG</big></button>
								<button type="button" onclick="add('<h2></h2>', 4)">h2</button>
								<button type="button" onclick="add('<p></p>', 3)">p</button>
								<button type="button" onclick='add("<img src=\"\" alt=\"\">", 10)'>img</button>
								<button type="button" onclick='add("<a href=\"\"></a>", 9)'>link</button>
							</div>

							<textarea id="post-text" name="text" type="text" placeholder="<?php echo $textarea_placeholder ?>" required="true" spellcheck="true"><?php echo @$content ?></textarea>

							<?php if (strpos($mode, 'article') !== false) { ?>
							<div class="page_subtitle">
								<span>
									Введите координаты объекта:
								</span>
							</div>

							<span>Для поиска координат можно воспользоваться <a target="blank" href="https://www.gpsies.com/coordinate.do?language=ru">сервисом по нахождению координат</a></span> <br> <br>

							<input type="text" name="lat" placeholder="Ширина" value="<?php echo @$lat; ?>">
							<input type="text" name="lng" placeholder="Долгота" value="<?php echo @$lng; ?>">
							
							<br> <br>

							<div class="page_subtitle">
								<span>
									Выберите категории для статьи:
								</span>
							</div>
							
							<div class="categories-variants">
								<?php 
									$categories = mysqli_query($connection, "SELECT * from `categories`");
									if (mysqli_num_rows($categories) > 0) {
										while ($category = mysqli_fetch_assoc($categories)) {
											?>
											<div class="category-variant">
												<input <?php if ($mode == 'update_article' and strpos($category_id, $category['id']) !== false) { echo 'checked'; } else if ($mode != 'update_article') { echo 'checked'; } ?> class="category-box" type="radio" name="category" value="<?php echo $category['id'] ?>">
												<label class="category-title" for="category"><?php echo $category['title'] ?></label>
											</div>					
											<?php
										}
									}
								?>
							</div>
								
							<br>

							<div class="page_subtitle">
								<span>
									Выберите область для статьи:
								</span>
							</div>
							
							<div class="categories-variants">
								<?php 
									$districts = mysqli_query($connection, "SELECT * from `districts`");
									if (mysqli_num_rows($districts) > 0) {
										while ($district = mysqli_fetch_assoc($districts)) {
											?>
											<div class="category-variant">
												<input <?php if ($mode == 'update_article' and strpos($district_id, $district['id']) !== false) { echo 'checked'; } ?> class="category-box" type="radio" name="district" value="<?php echo $district['id'] ?>">
												<label class="category-title" for="district"><?php echo $district['title'] ?></label>
											</div>					
											<?php
										}
									}
								?>
							</div>

							<?php } ?>
							<?php
						}

						if ($mode == 'add_category' or $mode == 'create_article' or $mode == 'add_district') {
							?>
							<br>
							<button class="send-button">Создать</button>
							<?php
						}
						else if ($mode == 'update_article' or $mode == 'update_category' or $mode == 'update_district') {
							?>
							<br>
							<button class="send-button">Изменить</button>
							<?php
						}
						else if (($mode == 'find_for_delete' and $user['status'] == 'admin') or $mode == 'update') {
							?>
							<br>
							<button class="send-button" type="submit">Найти</button>
							<?php
						}
					?>
				</form>

			</div>
			<?php
			if ($mode == 'update_article' or $mode == 'update_category' or $mode == 'update_district') { ?>
				<br>
				<div class="page_subtitle">
					<span>
						Версии
					</span>
				</div>

				<div class="versions">
					<?php
						$id = $_GET['id'];
						if ($mode == 'update_article') {
							$search_dir = "../repo/articles/$id";
							$mod = 'article';
						}
						else if ($mode == 'update_category') {
							$search_dir = "../repo/categories/$id";
							$mod = 'category';
						}
						else if ($mode == 'update_district') {
							$search_dir = "../repo/districts/$id";
							$mod = 'district';
						}

						if (file_exists($search_dir)) {

							$dir_files = scandir($search_dir, SCANDIR_SORT_DESCENDING);

						}
						
						if (isset($dir_files)) {
							$files_count = count($dir_files);
							$class = '';
							for ($i=0; $i < $files_count; $i++) { 
								if ($dir_files[$i] != '.' and $dir_files[$i] != '..') {
									if (strpos($_SERVER['REQUEST_URI'], $dir_files[$i]) !== false) {
										$class = 'current_link';
									}
									echo "<a class='$class' title='год-месяц-число_час-минута-секунда' href='content-manager.php?version=$dir_files[$i]&mod=$mod&id=$id&mode=$mode'>" . str_replace('.txt', '', $dir_files[$i]) . "</a>";
									$class = '';
								}
							}
						}
						else {
							echo 'Других версий не существует';
						}
					?>
				</div>
			<?php } ?>
		</section>
	</body>
</html>
<?php mysqli_close($connection) ?>
<?php }?>