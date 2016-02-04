<?php
	require_once 'models/Http.php';
	require_once 'models/Privilege.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Userpage.php';
	$privileges = Privilege::getPrivileges();
	$username = Http::get('name');
	$logged_in_as = User::getCurrentLogin();
	$viewerinfo = User::getUser($logged_in_as);
	$userinfo = User::getUser($username);

	if ($viewerinfo == false)
	{
		$error = Userpage::renderNoPrivilege($username);
		echo Standard::render('', $error);
		die();
	}
	if ($userinfo == false)
	{
		$error = Userpage::renderNotExist($username);
		echo Standard::render('', $error);
		die();
	}

	if ($username == $logged_in_as || $userinfo['privilege'] > $viewerinfo['privilege'] && $viewerinfo['privilege'] <= 4)
	{
		$privilege = Userpage::renderPrivileged($username, $userinfo['email'], $privileges, $userinfo['privilege'], $viewerinfo['privilege'], $viewerinfo['username']);
		$sidebar = Userpage::renderPrivilegedStatistics();
		$sidebar .= Userpage::renderReason(Http::get('reason'));
		if (Http::get('reason') == 'success')
			$sidebar .= Userpage::renderSuccessTime(Http::get('time'));
		else if (Http::get('reason') == 'nothing_changed')
			$sidebar .= Userpage::renderNothingChanged();
		echo Standard::render($sidebar, $privilege, User::generateLoginState());
	}
	else
	{
		$error = Userpage::renderNoPrivilege($username);
		echo Standard::render('', $error);
		die();
	}
?>
