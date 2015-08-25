<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	$username = Http::get('username');
	$password = Http::get('password');

	$user = new User;
	switch ($result = $user->loginUsername($username, $password))
	{
		case 'success':
			User::setCurrentLogin($username);
			header('Location: ' . "/user/$username");
		break;
		default: header('Location: ' . "login/$result");
	}
?>
