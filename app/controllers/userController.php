<?php

class User_Controller extends Controller
{
	public function index()
	{
		$this->change();
	}

	public function login()
	{
		$result = array('login' => '', 'error' => '');

		if(isset($_POST['login']) and isset($_POST['password']))
		{
			$user_model = $this->model('User');
			$response = $user_model->login($_POST['login'], $_POST['password']);

			if($response !== 0)
			{
				$result['login'] = $_POST['login'];
				$result['error'] = $response;
			}
			else
			{
				$path = $this->config->path;
				echo("<script>window.location.replace('$path/public/user/change');</script>");
			}
		}

		$result['page'] = 'Вход';

		$this->view('user/login', 'generalTemplate', $result);
	}

	public function change()
	{
		$login = '';
		$response = array('errors' => array(''), 'success' => array(''));

		if(isset($_POST['login']))
		{
			$login = $_POST['login'];
			$password = $_POST['password'];
			$new_password = $_POST['new_password'];
			$confirm_new_password = $_POST['confirm_new_password'];

			$user_model = $this->model('User');
			$response = $user_model->change($login, $password, $new_password, $confirm_new_password);
		}
		
		$this->view(array('user/userMenu', 'user/userSettings'), 'generalTemplate', array('login' => $login, 'page' => 'Настройки аккаунта', 'response' => $response));
	}

	public function logout()
	{
		unset($_SESSION['user']);
		$path = $this->config->path;
		echo("<script>window.location.replace('$path/public/');</script>");
	}

	public function create()
	{
		$login = '';
		$email = '';
		$response = array('errors' => array(''), 'success' => array(''));

		if(isset($_POST['login']))
		{
			$login = $_POST['login'];
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];
			$email = $_POST['email'];

			$user_model = $this->model('User');
			$response = $user_model->create($login, $password, $confirm_password, $email);
		}

		$this->view('user/registration', 'generalTemplate', array('login' => $login, 'email' => $email, 'page' => 'Регистрация', 'response' => $response));
	}

	public function verify()
	{
		$vkey = '';
		if(isset($_GET['vkey']))
		{
			$vkey = $_GET['vkey'];
		}

		$path = $this->config->path;
		$response = array('errors' => array(''), 'success' => array(''));
		$user_model = $this->model('User');
		$response = $user_model->verify($vkey);

		if($response['errors'][0] == '')
		{
			echo("<script>window.location.replace('$path/public/');</script>");
		}
		$this->view('user/confirm', 'generalTemplate', array('page' => 'Подтверждение', 'response' => $response));
	}

	public function recover()
	{
		$email = '';
		$response = array('errors' => array(''), 'success' => array(''));

		if(isset($_POST['email']))
		{
			$email = $_POST['email'];

			$user_model = $this->model('User');
			$response = $user_model->recover($email);
		}

		$this->view('user/recover', 'generalTemplate', array('email' => $email, 'page' => 'Восстановление', 'response' => $response));
	}

	public function selected()
	{
		if(isset($_SESSION['user']))
		{
			$user_model = $this->model('User');
			$articles = $user_model->selected($_SESSION['user']['id']);
			$this->view(array('user/userMenu', 'user/selected'), 'generalTemplate', array('page' => 'Избранные', 'articles' => $articles));
		}
	}

	public function track($article_id)
	{
		if(isset($_SESSION['user']))
		{	
			$user_model = $this->model('User');
			$response = $user_model->track($article_id);
			if($response)
			{
				echo("<script>window.history.back();</script>");
			}		
		}
	}
}