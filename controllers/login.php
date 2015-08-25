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
	$result = Login::renderReason($reason);
	echo Standard::render($result, Login::render(Http::get('username')));
?>
