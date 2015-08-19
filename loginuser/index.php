<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/phpass/PasswordHash.php";

	$username = $_POST['username'].trim(' ');
	$password = $_POST['password'];

	// Check if username exists in db.
	$pwcheck = new PasswordHash(8, false);

	require_once "$root/utils/E621.php";

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
		$db = new E621;
		$db_conn = $db->get();
		$db_conn_prep = $db_conn->prepare('SELECT password_hash FROM User WHERE username=?;');
		$db_conn_prep->bind_param('s', $username);
		$does_exist = $db_conn_prep->execute();
		$result = $db_conn_prep->get_result();
		$fetched = $result->fetch_array(MYSQLI_NUM);
		if ($fetched == NULL)
		{
			header('Location: ' . '/login/index.php?reason=no_such_account');
			die();
		}
		$hash = $fetched[0];
	}

	if ($pwcheck->CheckPassword($password, $hash))
	{
		session_start();
		$_SESSION['user'] = $username;
		header('Location: ' . $_GET['redirect']);
		die();
	}
	else
	{
		header('Location: ' . '/login/index.php?reason=wrong_password');
		die();
	}
?>
