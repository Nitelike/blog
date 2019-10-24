<?php
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$database_name = 'blog';

	$connection = mysqli_connect($servername, $username, $password, $database_name);
	if (!$connection) {
		die('Connection failed: ' . mysqli_connect_error());
	}
	mysqli_set_charset($connection, 'utf8');
	session_start();