<?php
	require_once 'db/Database.php';
	require_once 'pwhash/PasswordHash.php';

	class User
	{
		private $pwhash;
		function __construct()
		{
			$this->pwhash = new PasswordHash(8, false);
		}

		function register($username, $email, $password)
		{
			// Check if the email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				return 'invalid_email';

			// Check if the username is special
			if ($username == 'root')
				return 'username_special';

			$dbc = new Database;
			$db = $dbc->get();

			// Check if username is in the db already.
			if ($prepare = $db->prepare('SELECT 1 FROM User WHERE username = ?;'))
			{
				$prepare->bind_param('s', $username);
				$prepare->execute();
				$result = $prepare->get_result();
				$rows = $result->num_rows;
				if ($rows != 0)
					return 'username_exists';
			}
			else
			{
				return $db->error;
			}

			// Check if the email is already used.
			if ($prepare = $db->prepare('SELECT 1 FROM User WHERE email = ?;'))
			{
				$prepare->bind_param('s', $email);
				$prepare->execute();
				$result = $prepare->get_result();
				$rows = $result->num_rows;
				if ($rows != 0)
					return 'email_exists';
			}
			else
			{
				return $db->error;
			}

			// Insert it all into the database
			if ($prepare = $db->prepare('INSERT INTO User (username, email, password_hash) VALUES (?, ?, ?);'))
			{
				$prepare->bind_param('sss', $username, $email, $this->pwhash->HashPassword($password));
				$prepare->execute();
				if ($prepare->affected_rows != 1)
				{
					return 'unable_to_insert';
				}
			}
			else
			{
				return $db->error;
			}
			$db->commit();
			return 'success';
		}
	}
?>
