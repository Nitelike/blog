<?php

class Users_Controller extends Controller
{
	
	public function index()
	{
		# code...
	}

	public function read()
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			$users_model = $this->model('Users');
			$users = $users_model->get_users();
			$this->view(array('user/userMenu', 'users'), 'generalTemplate', array('page' => 'Пользователи', 'users' => $users));
		}
	}

	public function find()
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{
			if(isset($_POST['key']))
			{
                $users = array();
                if(trim($_POST['key'])) 
                {
                    $users_model = $this->model('Users');
                    $users = $users_model->find($_POST['key']);
                }
				$this->view(array('user/userMenu', 'users'), 'generalTemplate', array('page' => 'Пользователи', 'users' => $users, 'ukey' => $_POST['key']));
			}
		}
	}

	public function delete($id)
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{	
			$users_model = $this->model('Users');
			$response = $users_model->delete($id);
			$users = $users_model->get_users();
			$path = $this->config->path;
			echo("<script>window.location.replace('$path/public/users/read');</script>");
		}
	}

	public function update($id)
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{	
			$users_model = $this->model('Users');
			$response = $users_model->change_status($id);
			$users = $users_model->get_users();
			$path = $this->config->path;
			echo("<script>window.location.replace('$path/public/users/read');</script>");
		}
	}

	public function block($id)
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] === 'admin')
		{	
			$users_model = $this->model('Users');
			$response = $users_model->block($id);
			$users = $users_model->get_users();
			$path = $this->config->path;
			echo("<script>window.location.replace('$path/public/users/read');</script>");
		}
	}
}