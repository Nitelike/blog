<?php

class Uploads extends Model
{
	public function init()
	{
		if (!file_exists("../uploads/"))
		{
			if (!mkdir("../uploads/"))
			{
				die('Невозможно создать папку загрузок');
			}
		}
	}

	public function upload_image()
	{
		$this->init();

		$errors = array();
		$success = array();

		$target_dir = "../uploads/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		$file_formats = array("jpg", "png", "jpeg", "gif");

		if(isset($_POST["submit"])) 
		{
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) 
		    {
		    	if(file_exists($target_file))
		    	{
				    array_push($errors, "Файл с таким названием уже существует");
					$uploadOk = 0;
				}
				if($_FILES["fileToUpload"]["size"] > 5000000) 
				{
				    array_push($errors, "Размер файла слишком большой (больше 5Мбайт)");
				    $uploadOk = 0;
				}
				if(!in_array($imageFileType, $file_formats)) 
				{
				    array_push($errors, "Нельзя загрузить файл с таким расширением");
				    $uploadOk = 0;
				}
		    } 
		    else 
		    {
		        array_push($errors, "Файл не является изображением");
		        $uploadOk = 0;
		    }

		    if ($uploadOk == 0) 
		    {
			    array_push($errors, "Файл не был загружен");
			} 
			else 
			{
			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
			    {
			        array_push($success, "Файл ". basename( $_FILES["fileToUpload"]["name"]). " был загружен");
			    } 
			    else 
			    {
			        array_push($errors, "Возникла ошибка во время загрузки файла");
			    }
			}
		}

		array_push($success, '');
		array_push($errors, '');

		return array('errors' => $errors, 'success' => $success);

	}

}
