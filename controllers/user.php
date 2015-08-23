<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	$username = Http::get('name');

	echo Standard::render('Username', 'Wow!', User::generateLoginState());
?>
