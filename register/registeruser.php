<?php
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

	$root = $_SERVER['DOCUMENT_ROOT'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	// Perform database check.
	require_once "$root/utils/E621.php";
		require_once "$root/phpass/PasswordHash.php";
	$pwcheck = new PasswordHash(8, false);
	$pwhash = $pwcheck->HashPassword($password);

	$db = new E621;
	$db_conn = $db->get();
	$db_conn_prep = $db_conn->prepare('INSERT INTO User (username, email, password_hash) VALUE (?, ?, ?);');
	$db_conn_prep->bind_param('sss', $username, $email, $pwhash);
	if (!$db_conn_prep->execute())
	{
		header('Location: ' . '/register/register.php?reason=user_already_exists');
		die();
	}
	header('Location: ' . '/login/index.php');
?>
