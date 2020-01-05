<?php

class Article extends Model
{
	public function read($id = 0)
	{
		$sql = "SELECT * FROM `articles` WHERE `id` = $id";
		$article = mysqli_query($this->connection, $sql);

		if($article)
		{
			$article = mysqli_fetch_assoc($article);
			$this->result = $article;
			$views = intval($article['views']) + 1;
			$sql = "UPDATE `articles` SET `views` = '$views' WHERE `id` = '$id'";
			$query = mysqli_query($this->connection, $sql);
		}

		return $this->result;
	}

	public function create($title, $text, $category, $lat, $lng)
	{
		$title = mysqli_real_escape_string($this->connection, trim($title));
		$text = mysqli_real_escape_string($this->connection, trim($text));
		$category = ' ' . mysqli_real_escape_string($this->connection, trim($category)) . ',';
		$lat = floatval(mysqli_real_escape_string($this->connection, trim($lat)));
		$lng = floatval(mysqli_real_escape_string($this->connection, trim($lng)));

		$sql = "INSERT INTO `articles` (`title`, `text`, `category_id`, `lat`, `lng`) VALUES ('$title', '$text', '$category', '$lat', '$lng')";
		$query = mysqli_query($this->connection, $sql);

		if($query)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function delete($id)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$sql = "DELETE FROM `articles` WHERE `articles`.`id` = '$id'";
		$query = mysqli_query($this->connection, $sql);

		if($query)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function update($id, $title, $text, $category, $lat, $lng)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$title = mysqli_real_escape_string($this->connection, trim($title));
		$text = mysqli_real_escape_string($this->connection, trim($text));
		$category = ' ' . mysqli_real_escape_string($this->connection, trim($category)) . ',';
		$lat = floatval(mysqli_real_escape_string($this->connection, trim($lat)));
		$lng = floatval(mysqli_real_escape_string($this->connection, trim($lng)));

		$sql = "UPDATE `articles` SET `title` = '$title', `text` = '$text', `category_id` = '$category', `lat` = '$lat', `lng` = 'lng' WHERE `id` = '$id'";

		$query = mysqli_query($this->connection, $sql);

		if($query)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}