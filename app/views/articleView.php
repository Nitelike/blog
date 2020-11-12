<section class="article <?php if(!isset($data['mode']) || $data['mode'] != 'single') { echo 'left'; } ?>">
	<?php if(isset($_SESSION['user']) and $_SESSION['user']['status'] !== 'member') { ?>
	<div class="article-editor-buttons-row">
		<a class="btn" href="<?=$data['path']?>/public/article/update/<?=$data['article']['id']?>">Изменить</a>
		<?php if($_SESSION['user']['status'] === 'admin') { ?>
		<a class="btn btn-alert" href="<?=$data['path']?>/public/article/delete/<?=$data['article']['id']?>">Удалить</a>
		<?php } ?>
	</div>
	<?php } ?>

	<h1 class="title"><?=$data['article']['title']?></h1>
	<hr>
	<div class="content">
		<?=$data['article']['text']?>
	</div>

	<div class="info">
		<hr>
		<span><i class="fa fa-eye"></i> <?=$data['article']['views']?></span>
		<a class="common-link" href="<?=$data['path']?>/public/user/track/<?=$data['article']['id']?>">
			<?php
			if(isset($_SESSION['user'])) {
				if(strpos($_SESSION['user']['tracked_articles'], ' ' . $data['article']['id'] . ',') !== false)
				{
					echo "<i class=\"fa fa-star\" aria-hidden=\"true\"></i>";
				}
				else
				{
					echo "<i class=\"fa fa-star-o\" aria-hidden=\"true\"></i>";
				}
			}
			?>
		</a>
	</div>
</section>

<?php if(!isset($data['mode']) || $data['mode'] != 'single') { ?>

<section class="right">
	<span class="title">Статьи по теме</span>
	<hr>

	<?php foreach ($data['read_more'] as $new_article) { ?>
		<a class="line-link common-link" href="<?=$new_article['id']?>"><?=$new_article['title']?></a>
	<?php } ?>
</section>

<?php } ?>

<?php if ($data['article']['lat'] and $data['article']['lng']) { ?>
<section class="map left">
	<span class="title"><?=$data['article']['title']?> на карте</span>

	<script defer src="https://api-maps.yandex.ru/2.1/?apikey=510578c1-b38f-432c-a73c-fb2cc14ae5a2&lang=ru_RU" type="text/javascript"></script>

	<div id="map" style="width: 100%; height: 90vh;"></div>

	<script type="module">
		ymaps.ready(init);
		    function init(){
		    	var post = <?php echo json_encode($data['article']); ?>;
		        var myMap = new ymaps.Map("map", {
			    center: [53.89911389, 28.13402537],
			    zoom: 6
			});

		    var isMobile = {
	            Android: function() {return navigator.userAgent.match(/Android/i);},
	            BlackBerry: function() {return navigator.userAgent.match(/BlackBerry/i);},
	            iOS: function() {return navigator.userAgent.match(/iPhone|iPad|iPod/i);},
	            Opera: function() {return navigator.userAgent.match(/Opera Mini/i);},
	            Windows: function() {return navigator.userAgent.match(/IEMobile/i);},
	            any: function() {
	                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	            }
	        };

	        // после вызова карты
	        if(isMobile.any()){
	                myMap.behaviors.disable('scrollZoom');
	                myMap.behaviors.disable('drag');
	        }

			var myPlacemark = new ymaps.Placemark([parseFloat(post.lat), parseFloat(post.lng)]);
			myMap.geoObjects.add(myPlacemark);

			var location = ymaps.geolocation.get();

			location.then(
			  function(result) {
			    myMap.geoObjects.add(result.geoObjects)
			  },
			  function(err) {
			    console.log('Ошибка: ' + err)
			  }
			);
		}
	</script>
</section>
<?php } ?>