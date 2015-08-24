<?php
	require_once 'models/Http.php';
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Register.php';

	$register_form = Register::render();
	$reason = Register::renderReason(Http::get('reason'));
	$information = Register::renderInformation();
	echo Standard::render($information . $reason, $register_form, User::generateLoginState());
?>
