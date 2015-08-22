<?php
	class LoginState
	{
		static function isLoggedIn()
		{
			if (session_status() == PHP_SESSION_NONE)
				session_start();
			return isset($_SESSION['username']);
		}

		static function getUsername()
		{
			return $_SESSION['username'];
		}
	}
?>
