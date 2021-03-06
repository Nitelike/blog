<?php
$categories_model = $this->model('Categories');
$categories = $categories_model->get_categories();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?=$data['page']?></title>
	<link rel="icon" type="image/png" href="<?=$data['path']?>/uploads/belarus.png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['path']?>/public/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['path']?>/public/css/topnav.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['path']?>/public/css/home.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['path']?>/public/css/article.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['path']?>/public/css/articles.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['path']?>/public/css/user.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['path']?>/public/css/footer.css">
	<script defer src="<?=$data['path']?>/public/js/jquery-3.4.1.min.js"></script>
	<script defer src="<?=$data['path']?>/public/js/topnav.js"></script>
</head>
<body>
	<header>
		<div class="tools-menu">
			<div class="wrapper">
				<a href="javascript:void(0);" class="menu-icon" onclick="myFunction()">
					<i class="fa fa-bars"></i>
				</a>

				<div id="tools-items" style="">
					<div id="left-menu">
						<a class="common-link" href="<?=$data['path']?>/public/">Главная</a>
						<a class="common-link" href="<?=$data['path']?>/public/article/singleread/152">О проекте</a>
					</div>

					<div id="right-menu">
						<div class="search">
							<form method="post" action="<?=$data['path']?>/public/articles/search" autocomplete="off">
								<input type="text" placeholder="Поиск по статьям" name="key" maxlength="25" value="<?php if (isset($data['key'])) echo $data['key']; ?>">
								<button type="submit"><i class="fa fa-search"></i></button>
							</form>
						</div>

						<?php if(isset($_SESSION['user'])) { ?>
						<a class="common-link" href="<?=$data['path']?>/public/user/change"><?=$_SESSION['user']['name']?></a>
						<?php } else { ?>
						<a class="common-link" href="<?=$data['path']?>/public/user/login">Вход</a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<div class="logo"><a href="<?=$data['path']?>/public/"><?=$this->config->title?></a></div>

		<div class="categories-menu">
			<div class="wrapper">
				<ul>
					<?php foreach($categories as $category) { ?>
					<?php if($category['title'] != 'system') { ?>
					<li><a href="<?=$data['path']?>/public/articles/category/<?=$category['id']?>"><?=$category['title']?></a></li>
					<?php }} ?>
				</ul>
			</div>
		</div>
	</header>

	<div class="wrapper">
		<?php
		if(is_array($view))
		{
			foreach ($view as $partial_view)
			{
				require_once '../app/views/' . lcfirst($partial_view) . 'View.php';
			}
		}
		else
		{
			require_once '../app/views/' . lcfirst($view) . 'View.php';
		}
		?>
	</div>

	<div class="wrapper">
		<footer>
			<span class="footer_date_place"><?php echo date("Y"); ?>, Витебск</span>
			<span class="footer_email">ax.2904@gmail.com</span>
		</footer>
	</div>
</body>
</html>