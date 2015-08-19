<?php
	var_dump($_POST);
	// Use variables $_POST['name'], $_POST['password'], and $_POST['email'].
	if (preg_match('/^\s|\s$/', $_POST['username']))
	{
		header('Location: ' . '/register/register.php?reason=trailing_whitespace_username');
		die();
	}

	if (preg_match('/^\s|\s$/', $_POST['email']))
	{
		header('Location: ' .  '/register/register.php?reason=invalid_email');
		die();
	}

	// Perform database check.
	// If already exists:
	if (true)
	{
		header('Location: ' . '/register/register.php?reason=user_already_exists');
		die();
	}
?>
