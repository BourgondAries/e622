<?php
	require_once 'views/Standard.php';
	$renderer = new Standard;
	echo $renderer->render('Hi', 'There!');
?>
