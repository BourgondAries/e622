<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	$username = Http::get('username');
	$password = Http::get('password');

	$user = new User;
	echo $user->loginUsername($username, $password);
?>
