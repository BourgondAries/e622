<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	require_once "mediadescriber/Describer.php";
	require_once 'leftbar/PropertyGenerator.php';

	$result = describeMedia
	(
		"/static/diamond_tiara_rawr.png",
		'',
		['diamond_tiara_(mlp)', 'shouting', 'rawr', 'crying', 'diamond_tiara', 'pink', 'pony', 'mlp', 'earth_pony', 'fim', 'drawing', 'blue_eyes', 'mane', 'clothes'],
		[
			['profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'Ozymandis', 'comment' => 'Show me your war face!'],
			['profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'kekeke', 'comment' => 'Wow i\'m a comment!'],
			['profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'dumbusername', 'comment' => 'Bro, stahp'],
		],
		'Diamond Tiara saying rawr whilst tearing up.'
	);

	$leftbar = generateSidebarProperties(2, 1, 0, "SFW");

	echo generateTemplate($result, $leftbar);
?>
