<?php
	require_once 'models/Http.php';
	require_once 'models/PasswordHash.php';
	require_once 'models/User.php';

	$user = new User;
	if (Http::has('password') != null && Http::has('password_retype') != null)
	{

	}
	if (Http::get('password') == Http::get('password_retype')
	{

	}
	$user->register();
?>

