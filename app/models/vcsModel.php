<?php

class Vcs extends Model
{
	public function init() {
		if (!file_exists("../repo") or !file_exists("../repo/articles"))
		{
			if (!mkdir("../repo") or !mkdir("../repo/articles"))
			{
				die('Невозможно создать репозиторий');
			}
		}
	}

	public function add($dir) {
		$this->init();

		$sql = "SELECT * FROM `$dir` ORDER BY `id` DESC LIMIT 1";
		$query = mysqli_query($this->connection, $sql);
		$query = mysqli_fetch_assoc($query);
		$id = $query['id'];

		if (!file_exists("../repo/$dir/$id"))
		{
			if (!mkdir("../repo/$dir/$id", 0777))
			{
				return false;
			}
		}

		date_default_timezone_set('Europe/Minsk');
		$file_path = "../repo/$dir/$id/" . date("Y-m-d_H-i-s") . ".txt";
		if (!file_put_contents($file_path, "<?php return " . var_export($query, true) . ";"))
		{
			return false;
		}

		return true;
	}

	public function read($dir, $id, $version)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$version = mysqli_real_escape_string($this->connection, trim($version));
		$filename = "../repo/$dir/$id/$version.txt";
		$article = include $filename;
		return $article;
	}

	public function get_versions($dir, $id)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$filenames = array();
		$dir_name = "../repo/$dir/$id";

		if (file_exists($dir_name))
		{
			$files = array_diff(scandir($dir_name), array('.', '..'));
			foreach ($files as $filename)
			{
				array_push($filenames, str_replace('.txt', '', $filename));
			}
		}
		
		rsort($filenames);

		if(sizeof($filenames) > 1)
		{
			$removed = array_shift($filenames);
		}

		return $filenames;
	}
}