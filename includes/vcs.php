<?php
	function init() {
		if (!file_exists("../repo") or !file_exists("../repo/articles") or !file_exists("../repo/categories") or !file_exists("../repo/districts")) {
			if (!mkdir("../repo") or !mkdir("../repo/articles") or !mkdir("../repo/categories") or !mkdir("../repo/districts")) {
				die('Невозможно создать репозиторий');
			}
		}
	}

	function setMode($mode) {
		if ($mode == 'article') {
			$dir = "articles";
		}
		else if ($mode == 'category') {
			$dir = "categories";
		}
		else if ($mode == 'district') {
			$dir = "districts";
		}
		else {
			die('Неправильный режим. Можно только article, category, district');
		}

		return $dir;
	}

	function commit($id, $title, $author, $text, $mode) {
		date_default_timezone_set('Europe/Minsk');
		$dir = setMode($mode);
		$new_text = "$title\r\n$author\r\n$text";
		$file_path = "../repo/$dir/$id/" . date("Y-m-d_H-i-s") . '.txt';
		if (!file_put_contents($file_path, $new_text)) {
			echo 'Невозможно создать резервный файл';
		}
	}

	function create($id, $title, $author, $text, $mode) {
		init();
		$dir = setMode($mode);	
		if (!file_exists("../repo/$dir/$id")) {
			if (!mkdir("../repo/$dir/$id", 0777)) {
				echo 'Невозможно создать каталог';
			}
		}
		commit($id, $title, $author, $text, $mode);	
	}

	function getContent($mode)
	{
		require 'connect.php';
		$dir = setMode($mode);
		$id = mysqli_real_escape_string($connection, trim($_GET['id']));
		if ($id != '') {
			$sql = "SELECT * FROM `$dir` WHERE `id` = $id";
			$query = mysqli_query($connection, $sql);
			if ($query) {
				$query = mysqli_fetch_assoc($query);
			}
			else {
				echo mysqli_error($connection);
			}

			if ($mode == 'article') {
				$category_id = $query['category_id'];
				$district_id = $query['district_id'];
				$lat = $query['lat'];
				$lng = $query['lng'];
			}

			if (!isset($_GET['version']) or !isset($_GET['mod'])) {
				$title = $query['title'];
				$author = $query['last_author'];
				if ($query) {
					if ($mode == 'category' or $mode == 'district') {
						$content = $query['description'];
						
					}
					else if ($mode == 'article') {
						$content = $query['text'];
					}
				}
				else {
					echo 'Нет такой информации';
				}				
			}
			else {
				$filename = "../repo/$dir/$id/" . $_GET['version'];
				$file = file($filename);
				$title = $file[0];
				$content = '';
				$author = $file[1];
				for ($i=2; isset($file[$i]); $i++) { 
					$content .= $file[$i];
				}
				$title =  str_replace('\"', '\'', $title);
			$title =  str_replace('\r\n', '', $title);
			$content =  str_replace('\r\n', '', $content);
			$content =  str_replace('\"', '\'', $content);
			}

		}
		return array('title' => $title, 'author' => $author, 'content' => $content, 'category_id' => @$category_id, 'district_id' => @$district_id, 'lat' => @$lat, 'lng' => @$lng);		
	}