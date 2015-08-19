<?php
	class E621
	{
		var $connection;
		function __construct()
		{
			$server_root = $_SERVER['DOCUMENT_ROOT'];
			$password = file_get_contents("$server_root/../mysqlkey.txt");
			$password = rtrim($password);
			$this->connection = new mysqli("127.0.0.1", "server", $password, "e622", "3306");
			if ($this->connection->connect_errno)
			{
				printf("Connection failed: %s\n", $this->connection->connect_error);
				exit();
			}
		}

		function __destruct()
		{
			$this->connection->close();
		}

		function get()
		{
			return $this->connection;
		}

		function version()
		{
			return "Server version: " .  $this->connection->host_info;
		}

		function query($string)
		{
			$this->connection->query($string);
			return $this->connection->commit();
		}

		function queryEdit($string)
		{
			$this->connection->query($string);
		}

		function commit()
		{
			return $this->connection->commit();
		}
	}
?>
