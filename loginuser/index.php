<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/phpass/PasswordHash.php";

	$username = $_POST['username'];
	$password = $_POST['password'];

	// Check if username exists in db.

	// Get hash from that user.

	if (PasswordHash::CheckPassword($password, $hash))
	{
		// Everything is OK!
		$_SESSION['user'] = $username;
	}

	echo $username;
	echo $password;

	// Check the database and hash.
?>
