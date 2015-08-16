<?php
	function generateSidebarProperties($ups, $favorites, $downs, $safety)
	{
		$total = $ups - $downs;
		switch ($safety)
		{
			case "SFW":
				$safety = '<span id="ups"> SFW </span>';
				break;
			case "QSFW":
				$safety = '<span id="favorites"> QSFW </span>';
				break;
			case "NSFW":
				$safety = '<span id="downs"> NSFW </span>';
				break;
			default:
				break;
		}
		return "<div class=\"sidebarproperties\">
			&#8645; $total
			<div id=\"ups\"> &#8593; $ups </div>
			<div id=\"favorites\"> &#9733; $favorites </div>
			<div id=\"downs\"> &#8595; $downs </div>
			$safety
		</div>";
	}
?>
