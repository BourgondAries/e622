<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	require_once 'views/MediaPage.php';
	require_once 'views/Standard.php';
	$media = new Media;
	$media_data = $media->getMedia(Http::get('id'));
	$media_code = MediaPage::render($media_data);
	$control_code = MediaPage::renderControls($media_data['media_ID']);
	echo Standard::render($control_code, $media_code, User::generateLoginState());
?>
