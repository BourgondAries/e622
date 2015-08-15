<?php
	function describeMedia($imglink, $link, $tags, $comments)
	{
		$template = "<div class=\"mediadescriptor\">
			<div id=\"media\">
				<img alt=\"hey\" src=\"$imglink\">
			</div>
		</div>";

		return $template;
	}
?>
