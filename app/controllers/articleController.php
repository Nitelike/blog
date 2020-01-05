<?php

class Article_Controller extends Controller
{
	
	public function index()
	{		
		
	}

	public function read($id = 0)
	{
		$article_model = $this->model('Article');
		$article = $article_model->read($id);

		$articles_model = $this->model('Articles');
		$read_more = $articles_model->get_new_articles($id, $article['category_id'], 5);

		$this->view('article', 'generalTemplate', array('article' => $article, 'read_more' => $read_more, 'page' => 'Статья'));
	}

	public function create()
	{
		$article = array('title' => '', 'text' => '', 'category' => '', 'lat' => '', 'lng' => '');
		$categories_model = $this->model('Categories');
		$categories = $categories_model->get_categories();
		$result = array('errors' => array(''), 'success' => array(''));

		if(isset($_POST['title']))
		{
			$article['title'] = $_POST['title'];
			$article['text'] = $_POST['text'];
			$article['category'] = ' ' . $_POST['category'] . ',';
			$article['lat'] = $_POST['lat'];
			$article['lng'] = $_POST['lng'];

			$article_model = $this->model('Article');
			$response = $article_model->create($_POST['title'], $_POST['text'], $_POST['category'], $_POST['lat'], $_POST['lng']);
			if($response)
			{
				$result['success'][0] = 'Статья создана!';
			}
			else
			{
				$result['errors'][0] = 'Статья не создана!';
			}
		}
		
		$this->view(array('user/userMenu', 'articleEditor'), 'generalTemplate', array('page' => 'Написать статью', 'article' => $article, 'categories' => $categories, 'action' => 'create', 'response' => $result));
	}

	public function delete($id)
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			$article_model = $this->model('Article');
			$response = $article_model->delete($id);
			if($response)
			{
				$path = $this->config->path;
				echo("<script>window.location.replace('$path/public/');</script>");
			}
		}
	}

	public function update($id)
	{
		$article = array('title' => '', 'text' => '', 'category' => '', 'lat' => '', 'lng' => '');
		$categories_model = $this->model('Categories');
		$categories = $categories_model->get_categories();
		$result = array('errors' => array(''), 'success' => array(''));

		if(isset($_SESSION['user']) and $_SESSION['user']['status'] !== 'member')
		{
			$article_model = $this->model('Article');

			if(isset($_POST['title']))
			{
				$response = $article_model->update($id, $_POST['title'], $_POST['text'], $_POST['category'], $_POST['lat'], $_POST['lng']);

				if($response)
				{
					$result['success'][0] = 'Статья изменена!';
				}
				else
				{
					$result['errors'][0] = 'Статья не изменена!';
				}
			}

			$article_unprocessed = $article_model->read($id);

			if($article_unprocessed)
			{
				$article['title'] = $article_unprocessed['title'];
				$article['text'] = $article_unprocessed['text'];
				$article['category'] = ' ' . $article_unprocessed['category_id'] . ',';
				$article['lat'] = $article_unprocessed['lat'];
				$article['lng'] = $article_unprocessed['lng'];
			}	
		}

		$this->view(array('user/userMenu', 'articleEditor'), 'generalTemplate', array('page' => 'Изменить статью', 'article' => $article, 'categories' => $categories, 'action' => 'update/' . $id, 'response' => $result));
	}
}