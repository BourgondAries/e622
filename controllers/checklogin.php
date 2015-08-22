<?php
	require_once 'models/Http.php';
	echo Http::get('username');
	echo Http::get('password');
?>
