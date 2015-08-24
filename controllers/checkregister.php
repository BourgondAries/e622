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
		echo 'no_passwords';
		die();
	}

	if (Http::get('password') != Http::get('password_retype'))
	{
		echo 'password_not_match';
		die();
	}

	$user = new User;
	$result = $user->register(Http::get('username'), Http::get('email'), Http::get('password'));
	echo $result;
	switch ($result)
	{
		case 'unable_to_insert':
		break;
		case 'success':
		{
			echo 'Success';
		}
		break;
		case 'invalid_email':
		{
		}
		break;
		case 'username_special':
		{
		}
		break;
		case 'email_exists':
		break;
		case 'username_exists':
		{
		}
		break;
		default:
		{}
		break;
	}
?>
