<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	require_once 'views/MediaPage.php';
	require_once 'views/Standard.php';
	$media = new Media;
	$media_id = Http::get('id');
	$comments = $media->getComments($media_id, 0, 50);
	$media_tags = $media->getAllTags($media_id);
	$media_data = $media->getMedia($media_id);
	$statistics = $media->getMediaStatistics($media_id);
	$user = User::getUser(User::getCurrentLogin());
	$user_affiliation = $media->getUserVotes($media_id, $user['user_ID']);
	$media_code = MediaPage::render($media_data, $media_tags, $comments);
	$control_code = MediaPage::renderControls($media_data['media_ID'], $user_affiliation, $statistics);
	$error_code = MediaPage::renderWarning(Http::get('reason'));
	echo Standard::render($control_code . $error_code, $media_code, User::generateLoginState());
?>
