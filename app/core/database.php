<?php

class Database
{
	protected $host;
	protected $username;
	protected $password;
	protected $db_name;
    protected $config;

	public function __construct($host, $username, $password, $db_name)
	{
        $this->config = new Config;
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->db_name = $db_name;
	}

	public function connect()
	{
		$connection = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);

		if (!$connection) {
			die('Database connection failed: ' . mysqli_connect_error());
		}
		mysqli_set_charset($connection, 'utf8');

		return $connection;
	}
}