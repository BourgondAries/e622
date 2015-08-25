<?php
	require_once "models/Media.php";
	require_once "models/User.php";
	require_once "views/Standard.php";

	$media = new Media;
	$media->getPage(['nsfw'], 3, 3);

	echo Standard::render('Hi', 'There!', User::generateLoginState());
?>
