<?php
	function fileContent($file) {
		$content = '';
		$row = 1;
		while ($file[$row] !== false) {
			$content .= $file[$row];
			$row++;
		}
		return $content;
	}

	function change($file_text, $changes) {
		
		return $file_text;
	}

	function init() {
		if (!mkdir("../repo") or !mkdir("../repo/aricles") or !mkdir("../repo/categories")) {
			echo 'Невозможно создать репозиторий';
			die();
		}
	}

	function create($id, $text, $mode) {
		if ($mode == 'article') {
			$dir = "articles";
		}
		else if ($mode == 'category') {
			$dir = "categories";
		}
		if (!mkdir("../repo/$dir/" . $id)) {
			echo 'Невозможно создать каталог';
			die();
		}
		$text = '***file***\n' . $text;
		$file_path = "../repo/$dir/$id/" . date("Y.m.d_h:m:s") . '.txt';
		file_put_contents($file_path, $text);
		
	}

	function commit($id, $text, $mode) {
		if ($mode == 'article') {
			$dir = "articles";

		}
		else if ($mode == 'category') {
			$dir = "categories";
		}
		$files = count(glob("../repo/$dir/.txt"));
		if ($files % 10 != 0) {
			$search_dir = "../repo/$dir/$id/";
			$dir_files = scandir($search_dir, SCANDIR_SORT_DESCENDING);
			$i = 0;
			while ($file = file($dir_files[$i])[0] != '***file***') {
				$i++;
			}

			$old_text = fileContent($file);
			$i--;
			while ($i >= 0) {
				$changes = $dir_files[$i];
				$old_text = change($old_text, $changes);
				$i--;
			}
		}
		else {
			$text = '***file***\n' . $text;
		}
		$file_path = "../repo/$dir/$id/" . date("Y.m.d_h:m:s") . '.txt';
		file_put_contents($file_path, $text);
	}