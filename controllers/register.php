<?php
	require_once 'models/User.php';
	require_once 'views/Standard.php';
	require_once 'views/Register.php';

	$register_form = Register::render();
	echo Standard::render('', $register_form, User::generateLoginState());
?>
