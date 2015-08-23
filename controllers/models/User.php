<?php
	require_once 'db/Database.php';
	require_once 'pwhash/PasswordHash.php';
	class User
	{
		function register($username, $email, $password)
		{
			// Check if the email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				return 'invalid_email';

			// Check if the username is special
			if ($username == 'root')
				return 'username_special';

			// Check if username is in the db already.
			$dbc = new Database;
			$db = $dbc->get();
			$result = $db->query('SELECT * FROM User;');
			while ($row = $result->fetch_assoc())
			{
				var_dump($row);
				echo '<br>';
				echo '<br>';
			}

			// Check if the email is already used.

			// Insert it all into the database
			// Return an error code if something fails.
		}
	}
?>
