<!DOCTYPE html>
<html lang="en">
<head>
	<?php require '../includes/config.php' ?>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Create article</title>	
	<?php include '../includes/get-user.php'; if (isset($_SESSION['user']) and $user_name == 'admin') { ?>
	<link rel="stylesheet" type="text/css" href="../css/main.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/topnav.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/aside.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/article.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/content-manager.css?version=1.0">
	<script src="../js/jquery-3.4.1.min.js"></script>
	<script src="../js/fill-preview.js"></script>
	<script src="../js/add-tag.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		include '../includes/topnav.php';
		$mode = $_GET['mode'];
		if ($mode == 'create_article') {
			$mode_name = 'Add new post';
			$title_placeholder = 'New post title';
			$textarea_placeholder = "New post content";
			?>
			<aside>
				<a href="content-manager.php?mode=add_category">Add category</a>
				<a href="content-manager.php?mode=find_for_delete">Delete</a>
			</aside>
			<?php
		}
		else if ($mode == 'add_category') {
			$mode_name = 'Add new category';
			$title_placeholder = 'New category title';
			$textarea_placeholder = "";
			?>
			<aside>
				<a href="content-manager.php?mode=create_article">Create article</a>
				<a href="content-manager.php?mode=find_for_delete">Delete</a>
			</aside>
			<?php
		}
		else if ($mode == 'find_for_delete') {
			$mode_name = 'Delete content';
			$title_placeholder = 'Enter name for search';
			$textarea_placeholder = "";
			?>
			<aside>
				<a href="content-manager.php?mode=create_article">Create article</a>
				<a href="content-manager.php?mode=add_category">Add category</a>
			</aside>
			<?php
		}
		?>
		<div class="content">
			<div class="page_subtitle">
				<span>
					<?php echo $mode_name ?>
				</span>
			</div>
			<form action="content-manager-handler.php" method="get" autocomplete="off">
				<input name="mode" value="<?php echo $mode ?>" id="mode">
				<input id="title" type="text" name="title" placeholder="<?php echo $title_placeholder ?>" required="true">
				<?php
					if ($mode == 'create_article') {
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

						<textarea id="post-text" name="text" type="text" placeholder="<?php echo $textarea_placeholder ?>" required="true" spellcheck="true"></textarea>
						<div class="page_subtitle">
							<span>
								Post preview
							</span>
						</div>
						<article >
							<div class="post-content" id="post-prew"></div>		
						</article>

						<div class="page_subtitle">
							<span>
								Choose categories for your new article:
							</span>
						</div>
						<div class="categories-variants">
							<?php 
								$categories = mysqli_query($connection, "SELECT * from `categories`");
								if (mysqli_num_rows($categories) > 0) {
									while ($category = mysqli_fetch_assoc($categories)) {
										?>
										<div class="category-variant">
											<input class="category-box" type="checkbox" name="category[]" value="<?php echo $category['id'] ?>">
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
						<input id="create-post-button" type="submit" name="create-post-button" value="Create new">
						<?php
					}
					else if ($mode == 'find_for_delete') {
						?>
						<input id="create-post-button" type="submit" value="Find">
						<?php
					}
				?>
			</form>
		</div>
	</body>
</html>
<?php mysqli_close($connection) ?>
<?php }?>