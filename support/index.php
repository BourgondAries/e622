<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once 'generator/generator.php';
	require_once 'donatebar/generatedonate.php';
	require_once "$root/template/Template.php";
	$sample_comments =
	[
			['profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'Ozymandis', 'comment' => 'Show me your war face!'],
			['profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'kekeke', 'comment' => 'Wow i\'m a comment!'],
			['profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'dumbusername', 'comment' => 'Bro, stahp'],
	];

	$template = generateSupportPage($sample_comments);
	echo generateTemplate($template, generateDonateBar());
?>
