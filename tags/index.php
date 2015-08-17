<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";
	// Get tag data from the database, count the most popular tags.

	// Algorithm for creating the text:
	$tags = ['class', 293913, 'modulo', 253924, 'something', 230194, 'diamond', 183123];
	$all = '';
	$length = count($tags);
	for ($index = 0; $index < $length; $index += 2)
		$all .= $tags[$index] . ", (${tags[$index+1]}) -- ";

	// End of algorith
	$template = "<div class=\"tags\">
		$all
	</div>";

	echo generateTemplate($template);
?>
