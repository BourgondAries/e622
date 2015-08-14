<?php
	var_dump(function_exists('mysqli_connect'));
	$password = file_get_contents("../mysqlkey.txt");
	$password = rtrim($password);
	echo '"'.$password.'"';
	$mysqli = new mysqli("127.0.0.1", "server", $password, "e622", "3306");
	if ($mysqli->connect_errno)
	{
		printf("Connection failed: %s\n", $mysqli->connect_error);
		exit();
	}

	printf("Server version: %s\n", $mysqli->host_info);

?>
