<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	if (Http::has('user') && Http::has('username') && Http::has('email') && Http::has('password') && Http::has('password_retype') && Http::has('privilege'))
	{
		if ($username = User::getCurrentLogin())
		{
			$user = new User;
			$result = $user->change(Http::get('user'), Http::get('username'), Http::get('email'), Http::get('password'), Http::get('old_password'), Http::get('privilege'), $username);
			echo $result;
			if (Http::get('user') == $username && $result == 'success')
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
				$time = date('H:i:s');
				header("Location: /user/$newusername/reason=success&time=$time");
			}
			else if ($result == 'nothing_changed')
			{
				$newusername = Http::get('username');
				header("Location: /user/$newusername/reason=$result");
			}
			else
			{
				$username = User::getCurrentLogin();
				header("Location: /user/$username/reason=$result");
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
			header("Location: /user/$username/reason=");
		}
		else
		{
			header('Location: /');
		}
	}
