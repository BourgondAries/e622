<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Login.php';

	if ($username = User::getCurrentLogin())
	{
		if (!User::getUser($username))
			User::logout();
		header("Location: /user/$username");
		die();
	}

	$reason = Http::get('reason');
	switch ($reason)
	{
		case 'wrong_password':
			$reason = 'The password you entered was wrong, please try again.';
		break;
		case 'user_does_not_exist':
			$reason = 'No user exists by that username, maybe you want to register a new user?';
		break;
		case null:
		break;
		default:
			$reason = 'An error occurred, please contact support.';
		break;
	}
	$result = Login::renderReason($reason);
	echo Standard::render($result, Login::render(Http::get('username')));
?>
