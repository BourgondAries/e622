<?php
	require_once '../models/Http.php';
	echo Http::get('h');
	echo Http::get('t');
	var_dump(Http::get('x'));
?>
