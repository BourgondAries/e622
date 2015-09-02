<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Thumbnail.php';
	$media = new Media;
	$tags = explode(' ', Http::get('tags'));
	$result = $media->getPage($tags, 0, 50);
	$html = Thumbnail::generateThumbnails($result['media']);
	echo Standard::render('', $html, User::generateLoginState());
?>
