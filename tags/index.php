<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	require_once "$root/utils/E621.php";
	// Get tag data from the database, count the most popular tags.
	$db = new E621;
	$con = $db->get();
	$prep = $con->prepare('SELECT description, COUNT(MediaTag.tag_ID) FROM MediaTag JOIN Tag ON MediaTag.tag_ID = Tag.tag_ID GROUP BY MediaTag.tag_ID;');
	$prep->execute();
	$res = $prep->get_result();
	$tags = [];
	while ($result = $res->fetch_array())
	{
		$tags[] = $result[0];
		$tags[] = $result[1];
	}

	// Algorithm for creating the text:

	$all = '';
	$length = count($tags);
	for ($index = 0; $index < $length; $index += 2)
		$all .= "<a href=/search/search.php?q=${tags[$index]}>  ${tags[$index]} , (${tags[$index+1]}) </a>  -- ";

	// End of algorith

	$template = "<div class=\"tags\">
		$all
	</div>"; 

	echo generateTemplate($template);
?>
