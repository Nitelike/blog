<?php

class Controller
{
	protected $config;
	
	public function model($model)
	{
		require_once('../app/models/' . $model . 'Model.php');
		return new $model;
	}

	public function view($view, $template_view, $data = [])
	{
		$data['path'] = $this->config->path;
		require_once('../app/views/' . $template_view . 'View.php');
	}

	public function __construct()
	{
		$this->config = new Config;
	}

}