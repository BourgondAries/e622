<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/phpass/PasswordHash.php";

	$username = $_POST['username'].trim(' ');
	$password = $_POST['password'];

	// Check if username exists in db.
	$pwcheck = new PasswordHash(8, false);

	if ($username == 'root')
	{
		$hash = file_get_contents("$root/../root.hash") ;
	}
	else if ($username == 'anon')
	{
		header('Location: ' . '/login/index.php?reason=cannot_anon');
		die();
	}
	else
	{
		// Get hash from that user.
		$hash = $pwcheck->HashPassword($password); // Placeholder, always succeeds
	}

	if ($pwcheck->CheckPassword($password, $hash))
	{
		session_start();
		$_SESSION['user'] = $username;
		header('Location: ' . '/');
		die();
	}
	else
	{
		header('Location: ' . '/login/index.php?reason=wrong_password');
		die();
	}
?>
