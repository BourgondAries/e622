<?php
	class Database
	{
		private $db;
		function __construct()
		{
			$password = rtrim(file_get_contents("${_SERVER['DOCUMENT_ROOT']}/../mysqlkey.txt"));
			$this->db = new mysqli('127.0.0.1', 'server', $password, 'tete', 3306);
			if ($this->db->connect_errno)
			{
				$this->db = $this->db->connect_error;
				return;
			}
			$this->db->autocommit(false);
		}

		function __destruct()
		{
			$this->db->close();
		}

		function get()
		{
			return $this->db;
		}
	}
?>
