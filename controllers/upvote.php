<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	$user = User::getUser(User::getCurrentLogin());
	$media = new Media;
	$media->upvote(Http::get('id'), $user['user_ID']);
	header('Location: /media/' . Http::get('id'));
?>
