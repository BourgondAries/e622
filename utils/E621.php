<?php
	class E621
	{
		var $connection;
		function __construct()
		{
			$password = file_get_contents("../mysqlkey.txt");
			$password = rtrim($password);
			$this->connection = new mysqli("127.0.0.1", "server", $password, "e622", "3306");
			if ($this->connection->connect_errno)
			{
				printf("Connection failed: %s\n", $this->connection->connect_error);
				exit();
			}


		}

		function version()
		{
			return "Server version: " .  $this->connection->host_info;
		}
	}
?>
