<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';

	$parameters = '&username=' . Http::get('username') . '&email=' . Http::get('email');

	if (Http::has('username') == false)
	{
		header("Location: /register/reason=no_username$parameters");
		die();
	}

	if (Http::has('email') == false)
	{
		header("Location: /register/reason=no_email$parameters");
		die();
	}

	if (Http::has('password') == false || Http::has('password_retype') == false)
	{
		header("Location: /register/reason=no_password$parameters");
		die();
	}

	if (Http::get('password') != Http::get('password_retype'))
	{
		header("Location: /register/reason=password_not_match$parameters");
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
			header('Location: ' . "/register/reason=$result$parameters");
		break;
	}
?>
