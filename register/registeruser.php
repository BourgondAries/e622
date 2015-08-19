<?php
	var_dump($_POST);
	// Use variables $_POST['name'], $_POST['password'], and $_POST['email'].
	// Perform database check.
	// If already exists:
	if (true)
	{
		header('Location: ' . '/register/register.php?reason=user_already_exists');
		die();
	}
?>
