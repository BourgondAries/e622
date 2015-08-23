<?php
	require_once "models/User.php";
	require_once "views/Standard.php";

	echo Standard::render('Hi', 'There!', User::generateLoginState());
?>
