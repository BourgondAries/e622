<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once "$root/template/Template.php";

	$template = "<div class=\"help\">
		<div id=\"helpblock\">
			Welcome to the tag search engine! Here you can search a database of media. The formats jpg, png, gif, and webm are allowed. Webm may contain sound.<br>
			Every entry has a set of 'tag's. Each tag you search for will match items containing all those tags in any order.
		</div>
	</div>";
	echo generateTemplate($template, '');
?>
