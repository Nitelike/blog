<?php require '../includes/config.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Главная - <?php echo $params['title'] ?></title>	
	<?php include '../includes/common-header.php' ?>
	<link rel="stylesheet" type="text/css" href="../css/post-info.css?version=1.0">	
	<link rel="stylesheet" type="text/css" href="../css/post.css?version=1.0">
	<script src="../js/menu-button.js"></script>
	<script defer src="../js/jquery-3.4.1.min.js"></script>
	<script defer src="https://api-maps.yandex.ru/2.1/?apikey=510578c1-b38f-432c-a73c-fb2cc14ae5a2&lang=ru_RU" type="text/javascript">
    </script>
</head>
<body>
	<?php include '../includes/home-header.php' ?>
	<section>
	<div id="map" style="width: 100%; height: 90vh;"></div>
	</section>
	<script type="module">
	    // Функция ymaps.ready() будет вызвана, когда
	    // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
	    ymaps.ready(init);
	    function init(){
	        var myMap = new ymaps.Map("map", {
		    center: [53.89911389, 28.13402537],
		    zoom: 6
		});

	    var myGeoObjects = [];

	    $.ajax({
	        type:'POST',
	        url:'../includes/get-art-data.php',
	        success:function(msg, jsg){
	            if(msg == 'err'){
	                alert('Some problem occured, please try again.');
	            }else{
	                var geoObjects = JSON.parse(msg);
	                for (var i = 0; i < geoObjects.length; i++) {
	                	myGeoObjects[i] = new ymaps.GeoObject({
						    geometry: {
						      type: "Point",
						      coordinates: [parseFloat(geoObjects[i].lat), parseFloat(geoObjects[i].lng)]
						    },
						    properties: {
						      clusterCaption: geoObjects[i].title,
						      balloonContentBody: "<div class='point-image' style='background-image: url(" + geoObjects[i].image + ");'></div>" + "<a style='word-wrap: break-word;' href='article.php?id=" + parseInt(geoObjects[i].id) + "'>" + geoObjects[i].title + "</a>"
						    }
						});
	                }
	                var myClusterer = new ymaps.Clusterer({clusterDisableClickZoom: true});
					myClusterer.add(myGeoObjects);
					myMap.geoObjects.add(myClusterer);
	            }
	        }
	    });

	  }
	</script>
</body>
</html>
<?php mysqli_close($connection) ?>