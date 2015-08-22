<?php
	require_once 'models/Http.php';
	require_once 'views/Standard.php';
	require_once 'views/Login.php';
	$reason = Http::get('reason');
	echo Standard::render('Please log in!', 'Welcome');
?>
