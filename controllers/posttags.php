<?php
	require_once 'models/Http.php';
	require_once 'models/Media.php';
	require_once 'models/User.php';
	$media = new Media;
	$tags = Http::get('tags');
	$media_id = Http::get('id');
	$username = User::getCurrentLogin();
	if ($username == false)
	{
		header("Location: /media/$media_id&reason=log_in_tags");
		die();
	}
	$user_id = User::getUser($username)['user_ID'];
	$media->updateTags($media_id, $user_id, $tags);
	header("Location: /media/$media_id");
?>
