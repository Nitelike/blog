<?php
include 'connect.php';

$sql = "SELECT `id`, `title`, `text`, `lat`, `lng`, `category_id` FROM `articles`";
$result = mysqli_query($connection, $sql);
if (!$result) {
  die('Invalid query: ' . mysqli_error($connection));
}

$geoObjects = array();
while ($art = mysqli_fetch_assoc($result)) {
	if ($art['lat'] !== null and $art['lng'] !== null) {
		$src = '';
		$index = strpos($art['text'], '<img src="');
		if ($index !== false) {
			$index += 10;
			$last_index = strpos(substr($art['text'], $index), '"');
			if ($last_index !== false) {
				$src = substr($art['text'], $index, $last_index);
			}
		}
		array_push($geoObjects, array("id" => $art['id'], "title" => $art['title'], "lat" => $art['lat'], "lng" => $art['lng'], "image" => $src));
	}
}

echo json_encode($geoObjects);
?>