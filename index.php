<?php
	require_once 'template/Template.php';
	require_once 'result/Result.php';
	$item = array(
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW'),
		array('id' => 1, 'up' => 1, 'down' => 3, 'fav' => 6, 'type' => 'SFW')
	);
	$result = generateResult($item);
	echo generateTemplate($result);
?>
