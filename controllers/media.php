<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	require_once 'views/MediaPage.php';
	require_once 'views/Standard.php';
	$media = new Media;
	$media_id = Http::get('id');
	$media_data = $media->getMedia($media_id);
	$statistics = $media->getMediaStatistics($media_id);
	$user = User::getUser(User::getCurrentLogin());
	$user_affiliation = $media->getUserVotes($media_id, $user['user_ID']);
	$media_code = MediaPage::render($media_data);
	$control_code = MediaPage::renderControls($media_data['media_ID'], $user_affiliation, $statistics);
	echo Standard::render($control_code, $media_code, User::generateLoginState());
?>
