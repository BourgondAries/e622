<?php
	require_once 'comment/commentgenerator.php';
	function describeMedia($imglink, $link, $tags, $comments, $description)
	{
		$all_tags = '';
		foreach ($tags as &$tag)
			$all_tags .= $tag . ' ';
		$all_comments = '';
		foreach ($comments as &$comment)
			$all_comments .= generateComment($comment);
		$template = "<div class=\"mediadescriptor\">
			<div id=\"media\">
				<img alt=\"image\" src=\"$imglink\">
			</div>
			<div id=\"infobox\">
				<div id=\"description\"> <strong> &#9735; Description </strong> </div>
				<div id=\"descriptiontext\"> $description </div>
				<div id=\"tagarea\">
					<textarea>$all_tags</textarea>
				</div>
			</div>
			$all_comments
		</div>";

		return $template;
	}
?>
