<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Создать статью</title>	
	<?php include '../includes/get-user.php'; if (isset($_SESSION['user']) and $user_name == 'admin') { ?>
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/article.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/content-manager.css?version=1.0">
	<script src="../js/jquery-3.4.1.min.js"></script>
	<script src="../js/fill-preview.js"></script>
	<script src="../js/add-tag.js"></script>
</head>
<body>
	<?php
		include '../includes/topnav.php';
		$mode = $_GET['mode'];
		if ($mode == 'create_article') {
			$mode_name = 'Добавить статью';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Контент";
			?>
			<aside>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
				<a href="content-manager.php?mode=update">Изменить</a>
			</aside>
			<div class="toptoolmenu wrapper-100 content">
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
				<a href="content-manager.php?mode=update">Изменить</a>
			</div>
			<?php
		}
		else if ($mode == 'add_category') {
			$mode_name = 'Добавить категорию';
			$title_placeholder = 'Название';
			$textarea_placeholder = "";
			?>
			<aside>
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
				<a href="content-manager.php?mode=update">Изменить</a>
			</aside>
			<div class="toptoolmenu wrapper-100 content">
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
				<a href="content-manager.php?mode=update">Изменить</a>
			</div>
			<?php
		}
		else if ($mode == 'find_for_delete') {
			$mode_name = 'Удалить';
			$title_placeholder = 'Введите название';
			$textarea_placeholder = "";
			?>
			<aside>
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=update">Изменить</a>
			</aside>
			<div class="toptoolmenu wrapper-100 content">
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=update">Изменить</a>
			</div>
			<?php
		}
		else if ($mode == 'update') {
			$mode_name = 'Изменить';
			$title_placeholder = 'Введите название';
			$textarea_placeholder = "";
			?>
			<aside>
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
			</aside>
			<div class="toptoolmenu wrapper-100 content">
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
			</div>
			<?php
		}
		else if ($mode == 'update_category') {
			$id = mysqli_real_escape_string($connection, trim($_GET['id']));
			if ($id != '') {
				$sql = "SELECT * FROM `categories` WHERE `id` = $id";
				$query = mysqli_query($connection, $sql);
				if ($query) {
					if (mysqli_num_rows($query) !== false) {
						$query = mysqli_fetch_assoc($query);
						$title = $query['title'];
					}
					else {
						echo 'Нет такой категории';
					}
				}
				else {
					echo mysqli_error($connection);
				}
			}
			
			$mode_name = 'Изменить категорию';
			$title_placeholder = 'Название';
			$textarea_placeholder = "";
			?>
			<aside>
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
			</aside>
			<div class="toptoolmenu wrapper-100 content">
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
			</div>
			<?php
		}
		else if ($mode == 'update_article') {
			$id = mysqli_real_escape_string($connection, trim($_GET['id']));
			if ($id != '') {
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
			$mode_name = 'Изменить статью';
			$title_placeholder = 'Название';
			$textarea_placeholder = "Контент";
			?>
			<aside>
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
			</aside>
			<div class="toptoolmenu wrapper-100 content">
				<a href="content-manager.php?mode=create_article">Добавить статью</a>
				<a href="content-manager.php?mode=add_category">Добавить категорию</a>
				<a href="content-manager.php?mode=find_for_delete">Удалить</a>
			</div>
			<?php
		}
		?>
		<?php 
		?>
		<div class="content">
		<?php
		if ($mode == 'create_article' or $mode == 'update_article') { ?>
			<div class="wrapper-100">
				<div class="page_subtitle">
					<span>
						Предпросмотр статьи
					</span>
				</div>
				<article >
					<div class="post-content" id="post-prew"></div>		
				</article>
			</div>
			<?php } ?>
			<div class="wrapper-100">
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
												<input <?php if ($mode == 'update_article' and strpos($category_id, ' ' . $category['id'] . ',') !== false) { echo 'checked'; } ?> class="category-box" type="checkbox" name="category[]" value="<?php echo $category['id'] ?>">
												<label class="category-title" for="category[]"><?php echo $category['title'] ?></label>
											</div>					
											<?php
										}
									}
								?>
							</div>
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
						else if ($mode == 'find_for_delete' or $mode == 'update') {
							?>
							<button class="send-button" type="submit">Найти</button>
							<?php
						}
					?>
				</form>
			</div>
		</div>
	</body>
</html>
<?php mysqli_close($connection) ?>
<?php }?>