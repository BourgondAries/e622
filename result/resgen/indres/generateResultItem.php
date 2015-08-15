<link rel="stylesheet" type="text/css" href="/style/searchitem.css">
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	function generateResultItem($ups, $favorites, $downs, $safety)
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

	$amount = 50;
	for ($iterator = 0; $iterator < $amount; ++$iterator)
	{
		echo generateResultItem($iterator, 0, 0, "SFW");
	}
?>
<div class="searchitem">
	<a href=/post/something>
		<img class="thumbnail-searchitem" alt="thumbnail" height="150" width="150" src="/db/0.jpg">
	<span class="thumbnail-score"> 4 | 1 | 3 | SFW </span>
	</a>
</div>
