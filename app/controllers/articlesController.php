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
		$categories_model = $this->model('Categories');
		$category = $categories_model->get_category($category_id);
		$subcategories = $categories_model->get_subcategories($category_id);
		$this->view('articles', 'generalTemplate', array('articles' => $articles, 'subcategories' => $subcategories, 'search' => 'false', 'page' => $category['title']));
	}

	public function subcategory($subcategory_id)
	{
		$articles_model = $this->model('Articles');
		$articles = $articles_model->get_by_subcategory($subcategory_id);
		$categories_model = $this->model('Categories');
		$category_id = $categories_model->get_category_id($subcategory_id);
		$subcategories = $categories_model->get_subcategories($category_id);
		$subcategory = $categories_model->get_subcategory($subcategory_id);
		$this->view('articles', 'generalTemplate', array('articles' => $articles, 'subcategories' => $subcategories, 'search' => 'false', 'page' => $subcategory['title']));
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