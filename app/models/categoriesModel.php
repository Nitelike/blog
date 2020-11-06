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

	public function get_category($id = 0)
	{
		$sql = "SELECT * FROM `categories` WHERE `id` = '$id'";
		$category = mysqli_query($this->connection, $sql);

		$category = mysqli_fetch_assoc($category);

		return $category;
	}

	public function get_subcategories($category_id)
	{
		$result = array();

		$sql = "SELECT * FROM `subcategories` WHERE `category` = '$category_id' ORDER BY `title`";
		$subcategories = mysqli_query($this->connection, $sql);

		if($subcategories)
		{
			while($subcategory = mysqli_fetch_assoc($subcategories)){
				array_push($result, $subcategory);
			}
		}

		return $result; 
	}

	public function get_all_subcategories()
	{
		$result = array();

		$sql = "SELECT * FROM `subcategories` ORDER BY `title`";
		$subcategories = mysqli_query($this->connection, $sql);

		if($subcategories)
		{
			while($subcategory = mysqli_fetch_assoc($subcategories)){
				array_push($result, $subcategory);
			}
		}

		return $result; 
	}

	public function get_subcategory($subcategory_id)
	{

		$sql = "SELECT * FROM `subcategories` WHERE `id` = '$subcategory_id'";
		$subcategory = mysqli_query($this->connection, $sql);

		$subcategory = mysqli_fetch_assoc($subcategory);
		return $subcategory; 
	}

	public function get_category_id($subcategory_id)
	{
		$category_id = 0;

		$sql = "SELECT * FROM `subcategories` WHERE `id` = '$subcategory_id'";
		$subcategory = mysqli_query($this->connection, $sql);

		if($subcategory)
		{
			$subcategory = mysqli_fetch_assoc($subcategory);
			$category_id = $subcategory['category'];
		}

		return $category_id; 
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

	public function subcreate($title, $category_id)
	{
		$title = mysqli_real_escape_string($this->connection, trim($title));
		$description = mysqli_real_escape_string($this->connection, trim($category_id));

		$sql = "INSERT INTO `subcategories` (`title`, `category`) VALUES ('$title', '$category_id')";
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

	public function subdelete($id)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$sql = "DELETE FROM `subcategories` WHERE `subcategories`.`id` = '$id'";
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

	public function subupdate($id, $title, $category_id)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$title = mysqli_real_escape_string($this->connection, trim($title));
		$category_id = mysqli_real_escape_string($this->connection, trim($category_id));

		$sql = "UPDATE `subcategories` SET `title` = '$title', `category` = '$category_id' WHERE `id` = '$id'";
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

	public function subfind($key)
	{
		$subcategories = array();
		$key = mysqli_real_escape_string($this->connection, trim($key));
		$sql = "SELECT * FROM `subcategories` ORDER BY `title`";
		$all_subcategories = mysqli_query($this->connection, $sql);

		if($all_subcategories)
		{
			while($subcategory = mysqli_fetch_assoc($all_subcategories))
			{
				if(strpos(mb_strtolower($subcategory['title']), mb_strtolower($key)) !== false)
				{
					array_push($subcategories, $subcategory);
				}
			}
		}

		return $subcategories;
	}
}