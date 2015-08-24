<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';

	if (Http::has('username') == false)
	{
		header('Location: /register/no_username');
		die();
	}

	if (Http::has('email') == false)
	{
		header('Location: /register/no_email');
		die();
	}

	if (Http::has('password') == false || Http::has('password_retype') == false)
	{
		header('Location: /register/no_password');
		die();
	}

	if (Http::get('password') != Http::get('password_retype'))
	{
		echo 'password_not_match';
		die();
	}

	$user = new User;
	$result = $user->register(Http::get('username'), Http::get('email'), Http::get('password'));
	switch ($result)
	{
		case 'success':
			header('Location: /login');
		break;
		default:
			header('Location: ' . "/register/$result");
		break;
	}
?>
