<?php
	function cur_page ($current) {
		$url = $_SERVER['REQUEST_URI'];
		if (strpos($url, $current) !== false) {
			echo "class='current_page'";
		}
	}