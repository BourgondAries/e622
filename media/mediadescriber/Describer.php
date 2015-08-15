<?php
	function describeMedia($imglink, $link, $tags, $comments)
	{
		$template = "<div class=\"mediadescriptor\">
			<div id=\"media\">
				<img alt=\"image\" src=\"$imglink\">
			</div>
			<div id=\"infobox\">
				<div id=\"description\"> Description </div>
			</div>
		</div>";

		return $template;
	}
?>
