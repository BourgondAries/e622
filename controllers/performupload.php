<?php
	require_once 'models/Http.php';
	require_once 'models/Upload.php';
	require_once 'models/User.php';

	$username = User::getCurrentLogin();
	if ($username == false)
	{
		header('Location: /login/reason=uploading_redirect');
		die();
	}
	$user = User::getUser($username);
	$upload = new Upload;
	$description = Http::get('description');
	$taglist = Http::get('taglist');
	$result = $upload->uploadFile($user, $description, $taglist, Http::getFile('mediafile')['tmp_name']);
	if (Upload::startsWith($result, 'wrong'))
		$result = 'reason=' . $result;
	else
		$result = 'newid=' . $result;
	header("Location: /upload/$result&description=$description&taglist=$taglist");
?>
