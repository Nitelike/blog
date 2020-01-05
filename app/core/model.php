<?php

class Model
{
	protected $connection;
	protected $config;
	protected $db;

	public function __construct()
	{
		$this->config = new Config;
		$this->db = new Database($this->config->host, $this->config->username, $this->config->password, $this->config->db_name);
		$this->connection = $this->db->connect();
	}

	public function model($model)
	{
		require_once('../app/models/' . lcfirst($model) . 'Model.php');
		return new $model;
	}
}