<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Userpage.php';
	$username = Http::get('name');
	$logged_in_as = User::getCurrentLogin();
	$userinfo = User::getUser($username);
	if ($userinfo == false)
	{
		$error = Userpage::renderNotExist($username);
		echo Standard::render('', $error);
		die();
	}

	if ($username == $logged_in_as)
	{
		$privilege = Userpage::renderPrivileged($username, $userinfo['email']);
		$sidebar = Userpage::renderPrivilegedStatistics();
		echo Standard::render($sidebar, $privilege, User::generateLoginState());
	}
	else
	{

	}
?>
