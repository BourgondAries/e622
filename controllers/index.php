<?php
	require_once 'models/Http.php';
	require_once "models/Media.php";
	require_once "models/User.php";
	require_once "views/Thumbnail.php";
	require_once "views/Standard.php";

	$page = Http::getOrOne('page');
	$page -= 1;

	$media = new Media;
	$results = $media->getPage([], $page, 25);
	$html = Thumbnail::generateThumbnails($results['media']);
	$html .= Thumbnail::generatePageCounter($results['pagecount'], $page);

	echo Standard::render('', $html, User::generateLoginState());
?>
