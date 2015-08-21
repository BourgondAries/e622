<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/utils/E621.php";
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
	$fullquery = implode(', ', $tag_ids);
	$tagcount = count($tag_ids);
	$template = "SELECT media_ID FROM MediaTag WHERE tag_ID IN ($fullquery) GROUP BY media_ID HAVING count(distinct tag_ID) >= $tagcount;";
	$prep = $dbc->query($template);
	echo $dbc->error;
	echo '<br>' . $template . '<br>';
	while ($fetched = $prep->fetch_object())
	{
		var_dump($fetched);
		echo '<br>';
		echo 'ayy';
	}
?>
