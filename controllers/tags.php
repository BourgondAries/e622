<?php
	require_once 'models/Media.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Tag.php';

	$media = new Media;
	$tags = $media->getAllTagsGloballyByCount();
	$taghtml = Tag::render($tags);
	echo Standard::render('', $taghtml, User::generateLoginState());
?>
