<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once 'template/Template.php';
	require_once 'result/Result.php';
	require_once "$root/utils/E621.php";

	// Get shit from the db
	$db = new E621;
	$db_conn = $db->get();
	$prepst = $db_conn->prepare("SELECT media_ID, filename FROM Media ORDER BY upload_date DESC LIMIT 50;");
	$prepst->execute();
	$result = $prepst->get_result();
	$item = array();
	while ($fetched = $result->fetch_array(MYSQLI_NUM))
	{
		$infoget = $db_conn->prepare("SELECT sum(vote = true) as ups, sum(vote = false) as downs, sum(favorite) as favs FROM UserFeedback WHERE media_ID = ?;");
		$infoget->bind_param('i', $fetched[0]);
		$infoget->execute();
		$final_info = $infoget->get_result();
		$partial_result = $final_info->fetch_array(MYSQLI_NUM);
		for ($i = 0; $i < 3; ++$i)
			$partial_result[$i] = $partial_result[$i] == null ? 0 : $partial_result[$i];
		array_push($item, array
		(
			'id' => $fetched[0],
			'up' => $partial_result[0],
			'fav' => $partial_result[2],
			'down' => $partial_result[1],
			'type' => 'NSFW',
			'thumb' => $fetched[1]
		));
	}

	$result = generateResult($item);
	echo generateTemplate($result);
?>
