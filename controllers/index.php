<?php
	require_once "models/Media.php";
	require_once "models/User.php";
	require_once "views/Thumbnail.php";
	require_once "views/Standard.php";

	$media = new Media;
	$results = $media->getPage([], 0, 50);
	$html = Thumbnail::generateThumbnails($results['media']);

	echo Standard::render('', $html, User::generateLoginState());
?>
