<script defer src="https://api-maps.yandex.ru/2.1/?apikey=510578c1-b38f-432c-a73c-fb2cc14ae5a2&lang=ru_RU" type="text/javascript"></script>

<section>
	<div id="map" style="width: 100%; height: 90vh;"></div>
</section>

<script type="module">
	    ymaps.ready(init);
	    function init(){
	        var myMap = new ymaps.Map("map", {
		    center: [53.89911389, 28.13402537],
		    zoom: 6
		});
	    var geoObjects = <?php echo json_encode($data['articles']); ?>;

        for (var i = 0; i < geoObjects.length; i++) {
        	geoObjects[i] = new ymaps.GeoObject({
			    geometry: {
			      type: "Point",
			      coordinates: [parseFloat(geoObjects[i].lat), parseFloat(geoObjects[i].lng)]
			    },
			    properties: {
			      clusterCaption: geoObjects[i].title,
			      balloonContentBody: "<a style='word-wrap: break-word;' href='<?=$data['path']?>/public/article/read/" + parseInt(geoObjects[i].id) + "'><div class='point-image' style='background-image: url(" + geoObjects[i].src + ");'></div></a>" + "<a class='common-link' href='<?=$data['path']?>/public/article/read/" + parseInt(geoObjects[i].id) + "'>" + geoObjects[i].title + "</a>"
			    }
			});
        }
        var myClusterer = new ymaps.Clusterer({clusterDisableClickZoom: true});
		myClusterer.add(geoObjects);
		myMap.geoObjects.add(myClusterer);
    }

	</script>