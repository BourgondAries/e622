<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once("$root/utils/stylelink.php")
?>

<?php
	function generateResultItem($id, $ups, $favorites, $downs, $safety)
	{
		$total = $ups - $downs;
		switch ($safety)
		{
			case "SFW":
				$safety = '<span class="ups"> SFW </span>';
				break;
			case "QSFW":
				$safety = '<span class="favorites"> QSFW </span>';
				break;
			case "NSFW":
				$safety = '<span class="downs"> NSFW </span>';
				break;
			default:
				break;
		}
		return "<div class=\"searchitem\">
	<a href=/post/something>
		<img class=\"thumbnail-searchitem\" alt=\"thumbnail\" height=\"150\" width=\"150\" src=\"/db/0.jpg\">
		<span class=\"thumbnail-score\">
			&#8645; $total
			<span class=\"ups\"> &#8593; $ups </span>
			<span class=\"favorites\"> &#9733; $favorites </span>
			<span class=\"downs\"> &#8595; $downs </span>
			$safety
		</span>
	</a>
</div>";
	}
?>
