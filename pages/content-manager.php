<!DOCTYPE html>
<html lang="ru">
<head>
	<?php require '../includes/config.php' ?>
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
		include '../includes/topnav.php';
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

			$id = mysqli_real_escape_string($connection, trim($_GET['id']));
			if ($id != '') {
				if (!isset($_GET['version']) or !isset($_GET['mod'])) {
					$sql = "SELECT * FROM `categories` WHERE `id` = $id";
					$query = mysqli_query($connection, $sql);
					if ($query) {
						if (mysqli_num_rows($query) !== false) {
							$query = mysqli_fetch_assoc($query);
							$title = $query['title'];
							$content = $query['description'];
						}
						else {
							echo 'Нет такой категории';
						}
					}
					else {
						echo mysqli_error($connection);
					}
				}
				else if ($_GET['mod'] == 'category') {
					$filename = "../repo/categories/$id/" . $_GET['version'];
					$file = file($filename);
					$title = $file[0];
					$content = '';
					for ($i=1; isset($file[$i]); $i++) { 
						$content .= $file[$i];
					}
				}
			}			
		}
		else if ($mode == 'update_article') {
			$mode_name = 'Изменить статью';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Контент";

			$id = mysqli_real_escape_string($connection, trim($_GET['id']));
			if ($id != '') {
				if (!isset($_GET['version']) or !isset($_GET['mod'])) {
					$sql = "SELECT * FROM `articles` WHERE `id` = $id";
					$query = mysqli_query($connection, $sql);
					if ($query) {
						if (mysqli_num_rows($query) !== false) {
							$query = mysqli_fetch_assoc($query);
							$title = $query['title'];
							$content = $query['text'];
							$category_id = $query['category_id'];
						}
						else {
							echo 'Нет такой статьи';
						}
					}
					else {
						echo mysqli_error($connection);
					}
				}
				else if ($_GET['mod'] == 'article') {
					$filename = "../repo/articles/$id/" . $_GET['version'];
					$file = file($filename);
					$title = $file[0];
					$content = '';
					for ($i=1; isset($file[$i]); $i++) { 
						$content .= $file[$i];
					}

					$sql = "SELECT * FROM `articles` WHERE `id` = $id";
					$query = mysqli_query($connection, $sql);
					if ($query) {
						if (mysqli_num_rows($query) !== false) {
							$query = mysqli_fetch_assoc($query);
							$category_id = $query['category_id'];
						}
						else {
							echo 'Нет такой статьи';
						}
					}
					else {
						echo mysqli_error($connection);
					}
				}
			}	
		}
		?>
		<div class="toptoolmenu container wrapper">
			<?php include '../includes/content-manager-aside-content.php' ?>
		</div>

		<div class="container wrapper">
		<?php
		if ($mode == 'create_article' or $mode == 'update_article') { ?>
			<div class="container wrapper">
				<div class="page_subtitle">
					<span>
						Предпросмотр статьи
					</span>
				</div>
				<article class="post-preview">
					<div class="post-content" id="post-prew"></div>		
				</article>
			</div>
		<?php } ?>

			<div class="container wrapper">
				<div class="page_subtitle">
					<span>
						<?php echo $mode_name ?>
					</span>
				</div>
				<form action="content-manager-handler.php" method="post" autocomplete="off">
					<input name="mode" value="<?php echo $mode ?>" class="disabled">
					<input name="update_id" value="<?php echo @$id ?>"  class="disabled">
					<input id="title" type="text" name="title" placeholder="<?php echo $title_placeholder ?>" required="true" value="<?php echo @$title ?>">
					<?php
						if ($mode == 'create_article' or $mode == 'update_article') {
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
												<input <?php if ($mode == 'update_article' and strpos($category_id, ' ' . $category['id'] . ',') !== false) { echo 'checked'; } else if ($mode != 'update_article') { echo 'checked'; } ?> class="category-box" type="radio" name="category" value="<?php echo $category['id'] ?>">
												<label class="category-title" for="category"><?php echo $category['title'] ?></label>
											</div>					
											<?php
										}
									}
								?>
							</div>
							<?php
						}
						else if ($mode == 'update_category' or $mode == 'add_category') {
							?>
							<textarea id="category-description" name="text" type="text" placeholder="<?php echo $textarea_placeholder ?>" required="true" maxlength="255"><?php echo @$content ?></textarea>
							<?php
						}

						if ($mode == 'add_category' or $mode == 'create_article') {
							?>
							<button class="send-button">Создать</button>
							<?php
						}
						else if ($mode == 'update_article' or $mode == 'update_category') {
							?>
							<button class="send-button">Изменить</button>
							<?php
						}
						else if (($mode == 'find_for_delete' and $user['status'] == 'admin') or $mode == 'update') {
							?>
							<button class="send-button" type="submit">Найти</button>
							<?php
						}
					?>
				</form>

			</div>
			<?php
			if ($mode == 'update_article' or $mode == 'update_category') { ?>
				<br>
				<div class="page_subtitle">
					<span>
						Версии статьи
					</span>
				</div>

				<div class="versions">
					<?php
						if ($mode == 'update_article') {
							$search_dir = "../repo/articles/$id";
							$mod = 'article';
						}
						else if ($mode == 'update_category') {
							$search_dir = "../repo/categories/$id";
							$mod = 'category';
						}

						if (file_exists($search_dir)) {
							$dir_files = scandir($search_dir, SCANDIR_SORT_DESCENDING);
						}
						
						if (isset($dir_files)) {
							$files_count = count($dir_files);
							for ($i=0; $i < $files_count; $i++) { 
								if ($dir_files[$i] != '.' and $dir_files[$i] != '..') {
									echo "<a title='год-месяц-число_час-минута-секунда' href='content-manager.php?version=$dir_files[$i]&mod=$mod&id=$id&mode=$mode'>" . str_replace('.txt', '', $dir_files[$i]) . "</a>";
								}
							}
						}
						else {
							echo 'Других версий этой статьи не существует';
						}
					?>
				</div>
			<?php } ?>
		</div>
	</body>
</html>
<?php mysqli_close($connection) ?>
<?php }?>