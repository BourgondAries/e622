<?php
	require_once 'models/Http.php';
	require_once 'models/Upload.php';
	require_once 'models/User.php';

	$user = User::getUser(User::getCurrentLogin());
	Upload::uploadFile($user, Http::get('description'), Http::get('taglist'), Http::getFile('mediafile')['tmp_name']);
	var_dump($_POST);
	var_dump($_FILES);
?>
