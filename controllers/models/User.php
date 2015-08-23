<?php
	class User
	{
		function register($username, $email, $pwhash)
		{
			// Check if the email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				return 'INVALID_EMAIL';
			// Check if uername is in the db already.
			// Check if the email is already used.

			// Insert it all into the database
			// Return an error code if something fails.
		}
	}
?>
