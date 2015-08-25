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

		static function logout()
		{
			if (!isset($_SESSION))
				session_start();
			session_destroy();
		}

		static function setCurrentLoginForced($username)
		{
			session_start();
			$_SESSION['username'] = $username;
		}

		static function setCurrentLogin($username)
		{
			if (!isset($_SESSION))
				session_start();
			$_SESSION['username'] = $username;
		}

		static function getCurrentLogin()
		{
			if (!isset($_SESSION))
				session_start();
			if (isset($_SESSION['username']))
				return $_SESSION['username'];
			return false;
		}

		static function getUser($username)
		{
			$dbc = new Database;
			$db = $dbc->get();
			if ($prepare = $db->prepare('SELECT * FROM User WHERE username = ?;'))
			{
				$prepare->bind_param('s', $username);
				$prepare->execute();
				$result = $prepare->get_result();
				if ($rows = $result->num_rows)
					return $result->fetch_assoc();
				else
					return false;
			}
			else
			{
				echo $db->error;
				return false;
			}
		}

		static function generateLoginState()
		{
			$loginstate = ['LOGIN', '/login'];
			if ($username = self::getCurrentLogin())
				$loginstate = [$username, "/user/$username"];
			return $loginstate;
		}

		function loginUsername($username, $password)
		{
			$dbc = new Database;
			$db = $dbc->get();

			if ($prepare = $db->prepare('SELECT password_hash FROM User WHERE username = ?;'))
			{
				$prepare->bind_param('s', $username);
				$prepare->execute();
				$result = $prepare->get_result();
				if ($row = $result->fetch_assoc())
				{
					if ($this->pwhash->CheckPassword($password, $row['password_hash']))
						return 'success';
					else
						return 'wrong_password';
				}
				else
					return 'user_does_not_exist';
			}
			else
				return $db->error;
		}

		function change($oldusername, $username, $email, $password, $oldpassword)
		{
			if (strlen($username) > 26)
				return 'username_too_long';

			if (strlen($username) < 3)
				return 'name_too_short';

			if (strlen($username) != strlen(trim($username)))
				return 'name_trailing_spaces';

			// Check if the email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				return 'invalid_email';

			$dbc = new Database;
			$db = $dbc->get();

			// Check if username is in the db already.
			if ($prepare = $db->prepare('SELECT 1 FROM User WHERE username = ?;'))
			{
				$prepare->bind_param('s', $username);
				$prepare->execute();
				$result = $prepare->get_result();
				$rows = $result->num_rows;
				if ($rows >= 1 && $oldusername != $username)
					return 'username_already_exists';
			}
			else
			{
				return $db->error;
			}

			// Check if the email is already used.
			if ($prepare = $db->prepare('SELECT 1 FROM User WHERE email = ? AND username != ?;'))
			{
				$prepare->bind_param('ss', $email, $oldusername);
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

			// Check if the oldpassword is correct
			if ($prepare = $db->prepare('SELECT password_hash FROM User WHERE username = ?;'))
			{
				$prepare->bind_param('s', $oldusername);
				$prepare->execute();
				$result = $prepare->get_result();
				if ($row = $result->fetch_assoc())
				{
					if ($this->pwhash->CheckPassword($oldpassword, $row['password_hash']))
					{
						;
					}
					else
					{
						return 'old_pass_error';
					}
				}
				else
				{
					return 'no_result';
				}
			}
			else
			{
				return $db->error;
			}

			// Set the correct password
			if ($password == '')
				$password = $oldpassword;

			// Insert it all into the database
			if ($prepare = $db->prepare('UPDATE User SET username = ?, email = ?, password_hash = ? WHERE username = ?;'))
			{
				$prepare->bind_param('ssss', $username, $email, $this->pwhash->HashPassword($password), $oldusername);
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

		function register($username, $email, $password)
		{
			if (strlen($username) > 26)
				return 'username_too_long';

			if (strlen($username) < 3)
				return 'name_too_short';

			if (strlen($username) != strlen(trim($username)))
				return 'name_trailing_spaces';

			if (strlen($password) == 0)
				return 'password_empty';

			// Check if the email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				return 'invalid_email';

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
