<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	require_once "$root/utils/E621.php";
	require_once "mediadescriber/Describer.php";
	require_once 'leftbar/PropertyGenerator.php';

	$db = new E621;
	$mysqli = $db->get();

	$prepst = $mysqli->prepare("SELECT filename, description, source, upload_date FROM Media WHERE media_ID = ?;");
	$prepst->bind_param('i', $_GET['id']);
	$res = $prepst->execute();
	$res2 = $prepst->get_result();
	$fetched = $res2->fetch_array(MYSQLI_NUM);
	$file = $fetched[0];
	$description = $fetched[1];
	$source = $fetched[2];
	$upload_date = $fetched[3];

	$result = describeMedia
	(
		"/media_store/$file",
		'',
		['diamond_tiara_(mlp)', 'shouting', 'rawr', 'crying', 'diamond_tiara', 'pink', 'pony', 'mlp', 'earth_pony', 'fim', 'drawing', 'blue_eyes', 'mane', 'clothes'],
		[
			['date' => '18/08/2015 14:39:33', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'Ozymandis', 'comment' => 'Show me your war face!'],
			['date' => '17/08/2015 13:45:09', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'kekeke', 'comment' => 'Wow i\'m a comment!'],
			['date' => '17/08/2015 00:45:28', 'profilepic' => '/static/diamond_tiara_rawr.png', 'user' => 'dumbusername', 'comment' => 'Bro, stahp'],
		],
		$description,
		213
	);

	$leftbar = generateSidebarProperties(2, 1, 0, "SFW");

	echo generateTemplate($result, $leftbar);
?>
