<?php

class Home_Controller extends Controller
{
	
	function index()
	{
		$articles_model = $this->model('Articles');
		$articles = $articles_model->articles_for_map();
		$this->view('home', 'generalTemplate', array('articles' => $articles, 'page' => 'Главная'));
	}
}