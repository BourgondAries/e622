<?php
	function generateResultItem($id, $ups, $favorites, $downs, $safety)
	{
		$total = $ups - $downs;
		switch ($safety)
		{
			case "SFW":
				$safety = '<span class="ups"> &#9888;S </span>';
				break;
			case "QSFW":
				$safety = '<span class="favorites"> &#9888;Q </span>';
				break;
			case "NSFW":
				$safety = '<span class="downs"> &#9888;N </span>';
				break;
			default:
				break;
		}
		return "<a href=/media/media.php?id=$id>
	<div class=\"singlesearchitem\">
		<img class=\"thumbnail-searchitem\" alt=\"thumbnail\" height=\"150\" width=\"150\" src=\"/db/0.jpg\">
		<span class=\"thumbnail-score\">
			&#9830; $total
			<span class=\"ups\"> &#9652; $ups </span>
			<span class=\"favorites\"> &#9733; $favorites </span>
			<span class=\"downs\"> &#9662; $downs </span>
			$safety
		</span>
	</div>
</a>";
	}
?>
