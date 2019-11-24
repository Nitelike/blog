<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $params['title'] ?> - Статья</title>
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/article.css?version=1.0">
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
</head>
<body>
	<?php include '../includes/header.php'; $article_id = $_GET['id']; ?>

	<aside>
		<?php include '../includes/read-more.php' ?>
	</aside>

	<section class="side-section">
		<article>


			<?php 		
				$result = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = $article_id");
				if (mysqli_num_rows($result) !== false) {
					$post = mysqli_fetch_assoc($result);
					$post_category = str_replace(' ', '', $post['category_id']);
					$post_category = str_replace(',', '', $post['category_id']);
					$post_category = intval($post_category);
					$cat = mysqli_query($connection, "SELECT * FROM `categories` WHERE `id` = $post_category");
				if (mysqli_num_rows($cat) > 0) { $cat = mysqli_fetch_assoc($cat); } ?>
				
					<div class="path">
				<small><a href="home.php">Главная</a> > <a href="category.php?cat=<?php echo $cat['id'] ?>#track-<?php echo $post['id'] ?>"><?php echo $cat['title'] ?></a> > <a><?php echo $post['title'] ?></a></small>
			</div> <br>

				<?php include '../includes/post-info.php';
			?>

			<br>

			<hr>
						
			<div class="post-content">
				<?php 
					echo $post['text'];
					$id = $post['id'];
					$views = $post['views'] + 1;
					mysqli_query($connection, "UPDATE `articles` SET `views` = $views WHERE `articles`.`id` = $id;");
				}
				?>
			</div>	
		</article>
	</section>

	<?php if ($post['lat'] !== null and $post['lng'] !== null and $post['lat'] != 0 and $post['lng'] != 0) { ?>
	<section class="side-section">
		<div class="page_subtitle"><span><?php echo $post['title'] ?> на карте</span></div>
		<script defer src="../js/jquery-3.4.1.min.js"></script>
		<script defer src="https://api-maps.yandex.ru/2.1/?apikey=510578c1-b38f-432c-a73c-fb2cc14ae5a2&lang=ru_RU" type="text/javascript"></script>
		<div id="map" style="width: 100%; height: 90vh;"></div>
		<script type="module">
			ymaps.ready(init);
			    function init(){
			    	var post = <?php echo json_encode($post); ?>;
			        var myMap = new ymaps.Map("map", {
				    center: [53.89911389, 28.13402537],
				    zoom: 6
				});
				var myPlacemark = new ymaps.Placemark([parseFloat(post.lat), parseFloat(post.lng)]);
				myMap.geoObjects.add(myPlacemark);
			}
		</script>
	</section>
	<?php } ?>
	<div class="additional">
		<?php include '../includes/read-more.php' ?>
	</div>
	<?php include '../includes/footer.php' ?>
</body>
</html>
<?php mysqli_close($connection) ?>