<?php
	function init() {
		if (!file_exists("../repo") or !file_exists("../repo/articles") or !file_exists("../repo/categories")) {
			if (!mkdir("../repo") or !mkdir("../repo/articles") or !mkdir("../repo/categories")) {
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
		else {
			die('Неправильный режим. Можно только article, category');
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
	