<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once 'generator/generator.php';
	require_once 'donatebar/generatedonate.php';
	require_once "$root/template/Template.php";
	$sample_comments =
	[
			['date' => '18/08/2015 14:39:33', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'Ozymandis', 'comment' => 'Show me your war face!'],
			['date' => '17/08/2015 13:45:09', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'kekeke', 'comment' => 'Wow i\'m a comment!'],
			['date' => '17/08/2015 00:45:28', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'dumbusername', 'comment' => 'Bro, stahp'],
	];

	$template = generateSupportPage($sample_comments);
	echo generateTemplate($template, generateDonateBar());
?>
