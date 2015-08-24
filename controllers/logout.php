<?php
	require_once 'models/User.php';
	User::logout();
	header('Location: /');
?>
