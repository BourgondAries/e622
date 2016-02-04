<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	require_once 'views/SearchError.php';
	require_once 'views/Standard.php';
	require_once 'views/Thumbnail.php';

	$page = Http::getOrOne('page') - 1;

	$media = new Media;
	$tags = explode(' ', Http::get('tags'));
	$result = $media->getPage($tags, $page, 25);

	$html = Thumbnail::generateThumbnails($result['media']);
	$html .= Thumbnail::generatePageCounter
		($result['pagecount'], $page, 'search/', Http::get('tags'));
	$error = SearchError::maybeWriteError($result['unused']);
	echo Standard::render($error, $html, User::generateLoginState(), Http::get('tags'));
?>
