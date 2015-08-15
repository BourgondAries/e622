<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	require_once "mediadescriber/Describer.php";

	$result = describeMedia
	(
		"/static/diamond_tiara_rawr.png",
		'',
		['diamond_tiara_(mlp)', 'shouting', 'rawr', 'crying', 'diamond_tiara', 'pink', 'pony', 'mlp', 'earth_pony', 'fim', 'drawing', 'blue_eyes', 'mane', 'clothes'],
		[['profilepic' => '', 'user' => 'Ozymandis', 'comment' => 'Show me your war face!']],
		'Diamond Tiara saying rawr whilst tearing up.'
	);


	echo generateTemplate($result);
?>
