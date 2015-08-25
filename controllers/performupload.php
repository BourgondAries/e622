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
	$link = Http::get('link');
	$autolink = Http::get('autolink');
	$description = Http::get('description');
	$taglist = Http::get('taglist');
	if ($link != '')
	{
		if ($upload->existsId($link) != 1)
		{
			header("Location: /upload/reason=no_such_link&description=$description&taglist=$taglist");
		}
	}
	$result = $upload->uploadFile($user, $description, $taglist, Http::getFile('mediafile')['tmp_name']);
	if (Upload::startsWith($result, 'wrong'))
	{
		$result = 'reason=' . $result;
		$upload->rollback();
	}
	else
	{
		if ($link != '')
		{
			$rows = $upload->linkFromTo($link, $result);
			if ($rows < 1)
			{
				$result = 'reason=already_linked';
				$upload->rollback();
			}
			else
				$result = 'newid=' . $result;
		}
		else
			$result = 'newid=' . $result;
	}

	if ($autolink == 'on')
		$autolink = '&autolink=1';
	else
		$autolink = '';
	header("Location: /upload/$result&description=$description&taglist=$taglist$autolink");
?>
