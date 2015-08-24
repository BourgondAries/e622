<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	if (Http::has('username') && Http::has('email') && Http::has('old_password') && Http::has('password') && Http::has('password_retype'))
	{
		if ($username = User::getCurrentLogin())
		{
			$user = new User;
			$result = $user->change($username, Http::get('username'), Http::get('email'), Http::get('password'), Http::get('old_password'));
			if ($result == 'success')
			{
				$working_password = Http::get('password') != '' ? Http::get('password') : Http::get('old_password');
				if ($user->loginUsername(Http::get('username'), $working_password) == 'success')
				{
					User::logout();
					User::setCurrentLoginForced(Http::get('username'));
				}
				else
				{
					header('Location: /');
					die();
				}
				$newusername = Http::get('username');
				 header("Location: /user/$newusername");
			}
			else
			{
				$username = User::getCurrentLogin();
				header("Location: /user/$username/$result");
			}
		}
		else
		{
			header('Location: /');
		}
	}
	else
	{
		if ($username = User::getCurrentLogin())
		{
			header("Location: /user/$username");
		}
		else
		{
			header('Location: /');
		}
	}
