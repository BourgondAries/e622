<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Userpage.php';
	$username = Http::get('name');
	$logged_in_as = User::getCurrentLogin();
	if ($username == $logged_in_as)
		;

	echo Standard::render('Username', Userpage::renderPrivileged($username, 'd'), User::generateLoginState());
?>
