<?php
	function generateSidebarProperties($ups, $favorites, $downs, $safety)
	{
		$total = $ups - $downs;
		switch ($safety)
		{
			case "SFW":
				$safety = '<span id="ups"> &#9888; SFW </span>';
				break;
			case "QSFW":
				$safety = '<span id="favorites"> &#9888; QSFW </span>';
				break;
			case "NSFW":
				$safety = '<span id="downs"> &#9888; NSFW </span>';
				break;
			default:
				break;
		}
		return "<div class=\"sidebarproperties\">
			&#9830; $total
			<div id=\"ups\">&#9652; $ups </div>
			<div id=\"favorites\">&#9733; $favorites </div>
			<div id=\"downs\">&#9662; $downs </div>
			$safety
		</div>";
	}
?>
