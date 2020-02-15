<?php

class Uploads_Controller extends Controller
{
	
	public function index()
	{		
		
	}

	public function upload()
	{
		if(isset($_SESSION['user']) and $_SESSION['user']['status'] !== 'member')
		{
			$response = array('errors' => array(''), 'success' => array(''));

			if(isset($_POST["submit"]))
			{
				$uploads_model = $this->model('Uploads');
				$response = $uploads_model->upload_image();
			}
			$this->view(array('user/userMenu', 'testUpload'), 'generalTemplate', array('page' => 'Загрузить', 'response' => $response));
		}
	}

}