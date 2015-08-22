<?php
	require_once 'models/Http.php';
	require_once 'views/Standard.php';
	require_once 'views/Login.php';
	$reason = Http::get('reason');
	$result = '';
	if ($reason)
		$result = Login::renderReason($reason);
	echo Standard::render($result, Login::render());
?>
