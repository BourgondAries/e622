<?php
	require_once "models/Media.php";
	require_once "models/User.php";
	require_once "views/Standard.php";

	$media = new Media;
	var_dump($media->getPage(['nsfw'], 0, 50));
	die();

	echo Standard::render('Hi', 'There!', User::generateLoginState());
?>
