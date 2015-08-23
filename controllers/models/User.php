<?php
	require_once 'pwhash/PasswordHash.php';
	class User
	{
		function register($username, $email, $password)
		{
			// Check if the email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				return 'INVALID_EMAIL';
			// Check if uername is in the db already.
			$password = file_get_contents("${_SERVER['DOCUMENT_ROOT']}/../mysqlkey.txt");
			$db = new mysqli('127.0.0.1', 'server', $password, 'e622', 3306);
			if ($db->connect_errno)
				return 'Failed to connect to database';
			$db->query('SELECT * FROM User;');
			// Check if the email is already used.

			// Insert it all into the database
			// Return an error code if something fails.
		}
	}
?>
