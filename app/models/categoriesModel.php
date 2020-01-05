<?php

class Categories extends Model
{
	
	public function get_categories()
	{
		$result = array();

		$sql = "SELECT * FROM `categories` ORDER BY `title`";
		$categories = mysqli_query($this->connection, $sql);

		if($categories)
		{
			while($category = mysqli_fetch_assoc($categories)){
				array_push($result, $category);
			}
		}

		return $result;
	}

	public function create($title, $description)
	{
		$title = mysqli_real_escape_string($this->connection, trim($title));
		$description = mysqli_real_escape_string($this->connection, trim($description));

		$sql = "INSERT INTO `categories` (`title`, `description`) VALUES ('$title', '$description')";
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
		$sql = "DELETE FROM `categories` WHERE `categories`.`id` = '$id'";
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

	public function update($id, $title, $description)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$title = mysqli_real_escape_string($this->connection, trim($title));
		$description = mysqli_real_escape_string($this->connection, trim($description));

		$sql = "UPDATE `categories` SET `title` = '$title', `description` = '$description' WHERE `id` = '$id'";
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

	public function find($key)
	{
		$categories = array();
		$key = mysqli_real_escape_string($this->connection, trim($key));
		$sql = "SELECT * FROM `categories` ORDER BY `title`";
		$all_categories = mysqli_query($this->connection, $sql);

		if($all_categories)
		{
			while($category = mysqli_fetch_assoc($all_categories))
			{
				if(strpos(mb_strtolower($category['title']), mb_strtolower($key)) !== false)
				{
					array_push($categories, $category);
				}
			}
		}

		return $categories;
	}
}