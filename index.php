<?php
	$password = file_get_contents("../mysqlkey.txt");
	$mysqli = new mysqli("localhost", "server", $password, "e622");
	if (mysqli_connect_errno())
	{
		printf("Connection failed: %s\n", mysqli_connect_error());
		exit();
	}

	printf("Server version: %s\n", $mysqli->server_info);
	$mysqli->close();
?>
