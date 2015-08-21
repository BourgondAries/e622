<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/utils/E621.php";
	require_once "$root/template/Template.php";
	require_once "$root/result/Result.php";
	$db = new E621;
	$dbc = $db->get();

	$tags = explode(' ', $_GET['q']);
	$sql_tag = '\'';
	foreach ($tags as &$tag)
		$tag = $dbc->real_escape_string($tag);
	$sql_tag .= implode('\' ,\'', $tags) . '\'';
	$prep = $dbc->query("SELECT tag_ID FROM Tag WHERE description IN ($sql_tag);");
	$tag_ids = [];
	while ($fetched = $prep->fetch_array())
		$tag_ids[] = $fetched[0];
	if (empty($tag_ids))
	{
		header('Location: /');
		die();
	}
	$fullquery = implode(', ', $tag_ids);
	$tagcount = count($tag_ids);
	$template = "SELECT media_ID, filename FROM MediaTag NATURAL JOIN Media WHERE tag_ID IN ($fullquery) GROUP BY media_ID HAVING count(distinct tag_ID) >= $tagcount ORDER BY upload_date DESC LIMIT 50;";
	$prep = $dbc->query($template);
	$item = [];
	while ($fetched = $prep->fetch_array())
	{
		$infoget = $dbc->prepare("SELECT sum(vote = true) as ups, sum(vote = false) as downs, sum(favorite) as favs FROM UserFeedback WHERE media_ID = ?;");
		$id = $fetched[0];
		$infoget->bind_param('i', $id);
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
