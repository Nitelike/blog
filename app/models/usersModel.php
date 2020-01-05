<?php

class Users extends Model
{
	public function get_users()
	{
		$users = array();

		$sql = "SELECT * FROM `users` ORDER BY `name`";
		$query = mysqli_query($this->connection, $sql);

		while($user = mysqli_fetch_assoc($query))
		{
			array_push($users, $user);
		}

		return $users;
	}

	public function find($key)
	{
		$key = mysqli_real_escape_string($this->connection, trim($key));
		$users = array();

		$sql = "SELECT * FROM `users` ORDER BY `name`";
		$query = mysqli_query($this->connection, $sql);

		while($user = mysqli_fetch_assoc($query))
		{
			if(strpos(mb_strtolower($user['name']), mb_strtolower($key)) !== false)
			{
				array_push($users, $user);
			}
		}

		return $users;
	}

	public function delete($id)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$sql = "DELETE FROM `users` WHERE `users`.`id` = '$id' and `status` <> 'admin'";
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

	public function block($id)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$sql = "SELECT * FROM `users` WHERE `users`.`id` = '$id'";
		$query = mysqli_query($this->connection, $sql);
		if($query)
		{
			$user = mysqli_fetch_assoc($query);
			if($user and $user['status'] !== 'admin')
			{
				$verified = 0;
				if($user['verified'] == 1)
				{
					$verified = -1;
				}
				else if($user['verified'] == -1)
				{
					$verified = 1;
				}
				$sql = "UPDATE `users` SET `verified` = '$verified' WHERE `id` = '$id'";
				$query = mysqli_query($this->connection, $sql);
				if($query)
				{
					return $verified;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}
	}

	public function change_status($id)
	{
		$id = mysqli_real_escape_string($this->connection, trim($id));
		$sql = "SELECT * FROM `users` WHERE `users`.`id` = '$id'";
		$query = mysqli_query($this->connection, $sql);
		if($query)
		{
			$user = mysqli_fetch_assoc($query);
			if($user and $user['status'] !== 'admin')
			{
				$status = 'member';
				if($user['status'] === 'member')
				{
					$status = 'editor';
				}
				else if($user['status'] === 'editor')
				{
					$status = 'member';
				}
				$sql = "UPDATE `users` SET `status` = '$status' WHERE `id` = '$id'";
				$query = mysqli_query($this->connection, $sql);
				return $status;
			}
		}
		else
		{
			return false;
		}
	}
}