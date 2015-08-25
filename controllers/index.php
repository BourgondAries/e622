<?php
	require_once "models/Media.php";
	require_once "models/User.php";
	require_once "views/Standard.php";

	$media = new Media;
	var_dump($media->getPage([], 0, 3));
	die();

	echo Standard::render('Hi', 'There!', User::generateLoginState());
?>
