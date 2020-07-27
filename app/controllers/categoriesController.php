<?php

class Categories_Controller extends Controller
{
	
	public function index()
	{
		# code...
	}

	public function read()
	{
		$categories = array();
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			$categories_model = $this->model('Categories');
			$categories = $categories_model->get_categories();
		}

		$this->view(array('user/userMenu', 'categories'), 'generalTemplate', array('categories' => $categories, 'page' => 'Категории'));
	}

	public function create()
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			if(isset($_POST['title']))
			{
				$categories_model = $this->model('Categories');
				$response = $categories_model->create($_POST['title'], $_POST['description']);
				if($response)
				{
					$path = $this->config->path;
					echo("<script>window.location.replace('$path/public/categories/read');</script>");
				}
			}
		}
	}

	public function delete($id)
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			$categories_model = $this->model('Categories');
			$response = $categories_model->delete($id);
			if($response)
			{
				$path = $this->config->path;
				echo("<script>window.location.replace('$path/public/categories/read');</script>");
			}
		}
	}

	public function update($id)
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			if(isset($_POST['title_' . $id]))
			{
				$categories_model = $this->model('Categories');
				$response = $categories_model->update($id, $_POST['title_' . $id], $_POST['description_' . $id]);
				if($response)
				{
					$path = $this->config->path;
					echo("<script>window.location.replace('$path/public/categories/read');</script>");
				}
			}
		}
	}

	public function find()
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			if(isset($_POST['key']))
			{
                $categories = array();
                if(trim($_POST['key'])) 
                {
                    $categories_model = $this->model('Categories');
				    $categories = $categories_model->find($_POST['key']);
                }
				$this->view(array('user/userMenu', 'categories'), 'generalTemplate', array('categories' => $categories, 'page' => 'Категории', 'key' => $_POST['key']));
			}
		}
	}
}