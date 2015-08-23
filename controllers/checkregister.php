<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';

	if (Http::has('password') != null && Http::has('password_retype') != null)
	{

	}
	if (Http::get('password') != Http::get('password_retype'))
	{
	}

	$user = new User;
	echo $user->register(Http::get('username'), Http::get('email'), Http::get('password'));
?>
