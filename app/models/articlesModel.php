<?php

class Articles extends Model
{
	public function get_image_url($text)
	{
		$src = '';
		$index = strpos($text, '<img src=');
		if ($index !== false) {
			$index += 10;
			$last_index = strpos(substr($text, $index), '>');
			if ($last_index !== false) {
				$src = substr($text, $index, $last_index - 8);
			}
		}

		return $src;
	}

	public function get_new_articles($id, $category_id, $limit)
	{
		$result = array();
		$sql = "SELECT * FROM `articles` WHERE `id` <> $id AND `category_id` = '$category_id' LIMIT $limit";
		$articles = mysqli_query($this->connection, $sql);

		if($articles)
		{
			while($article = mysqli_fetch_assoc($articles))
			{
				array_push($result, $article);
			}
		}

		return $result;
	}

	public function get_by_category($category_id)
	{
		$category_id = ' ' . $category_id . ',';

		$result = array();
		$sql = "SELECT * FROM `articles` WHERE `category_id` = '$category_id' ORDER BY `title`";
		$articles = mysqli_query($this->connection, $sql);

		if($articles)
		{
			while($article = mysqli_fetch_assoc($articles))
			{
				$src = $this->get_image_url($article['text']);

				array_push($result, array('title' => $article['title'], 'src' => $src, 'id' => $article['id']));
			}
		}

		return $result;
	}

	public function articles_for_map()
	{
		$result = array();
		$sql = "SELECT `id`, `title`, `text`, `lat`, `lng`, `category_id` FROM `articles`";
		$articles = mysqli_query($this->connection, $sql);

		if($articles)
		{
			while($article = mysqli_fetch_assoc($articles))
			{
				if($article['lat'] and $article['lng'])
				{
					$src = $this->get_image_url($article['text']);
					$article['src'] = $src;
					array_push($result, $article);
				}
			}
		}

		return $result;
	}

	public function get_by_key($key)
	{
		$key = mysqli_real_escape_string($this->connection, trim($key));
		$key = mb_strtolower($key);

		$result = array();
		$sql = "SELECT * FROM `articles`";
		$articles = mysqli_query($this->connection, $sql);

		if($articles)
		{
			while($article = mysqli_fetch_assoc($articles))
			{
				if(mb_strpos(mb_strtolower($article['title']), $key) !== false or mb_strpos(mb_strtolower($article['text']), $key) !== false)
				{
					$src = $this->get_image_url($article['text']);
					$article['src'] = $src;
					array_push($result, $article);
				}
			}
		}

		return $result;
	}
}