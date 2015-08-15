<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	require_once "mediadescriber/Describer.php";

	$result = describeMedia
	(
		"/static/diamond_tiara_rawr.png",
		'',
		'hi',
		[]
	);


	echo generateTemplate($result);
?>
