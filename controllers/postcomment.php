<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	$media = new Media;
	$media_id = Http::get('id');
	$username = User::getCurrentLogin();
	if ($username == false)
	{
		header("Location: /media/$media_id&reason=log_in");
		die();
	}
	$user_id = User::getUser($username)['user_ID'];
	$media->postComment($media_id, $user_id, Http::get('comment'));
	header('Location: /media/' . $media_id);
	die();
?>
