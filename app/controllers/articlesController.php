<?php

class Articles_Controller extends Controller
{
	
	public function index()
	{
		
	}

	public function category($category_id)
	{
		$articles_model = $this->model('Articles');
		$articles = $articles_model->get_by_category($category_id);
		$this->view('articles', 'generalTemplate', array('articles' => $articles, 'page' => 'Категория'));
	}

	public function search()
	{
		$key = $_POST['key'];
        $articles = array();
        
        if(trim($key)) 
        {
            $articles_model = $this->model('Articles');
		    $articles = $articles_model->get_by_key($key);
        }
        $this->view('articles', 'generalTemplate', array('articles' => $articles, 'key' => htmlentities($key, ENT_QUOTES), 'page' => 'Результаты поиска'));
	}
}