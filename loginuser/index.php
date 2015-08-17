<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/phpass/PasswordHash.php";

	$username = $_POST['username'];
	$password = $_POST['password'];

	// Check if username exists in db.
	$pwcheck = new PasswordHash(8, false);

	// Get hash from that user.
	$hash = $pwcheck->HashPassword($password); // Placeholder, always succeeds

	if ($pwcheck->CheckPassword($password, $hash))
	{
		// Everything is OK!
		echo 'Password hashed OK!';
		session_start();
		$_SESSION['user'] = $username;
	}

	echo $username;
	echo $password;

	// Check the database and hash.
?>
