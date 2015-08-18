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
			['date' => '18/08/2015 14:39:33', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'Ozymandis', 'comment' => 'Show me your war face!'],
			['date' => '17/08/2015 13:45:09', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'kekeke', 'comment' => 'Wow i\'m a comment!'],
			['date' => '17/08/2015 00:45:28', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'dumbusername', 'comment' => 'Bro, stahp'],
		],
		'Diamond Tiara saying rawr whilst tearing up.',
		213
	);

	$leftbar = generateSidebarProperties(2, 1, 0, "SFW");

	echo generateTemplate($result, $leftbar);
?>
