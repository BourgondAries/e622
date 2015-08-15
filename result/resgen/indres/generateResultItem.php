<link rel="stylesheet" type="text/css" href="/style/searchitem.css">
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	function generateResultItem($ups, $favorites, $downs, $safety)
	{
		$total = $ups - $downs;
		return "<div class=\"searchitem\">
	<a href=/post/something>
		<img class=\"thumbnail-searchitem\" alt=\"thumbnail\" height=\"150\" width=\"150\" src=\"/db/0.jpg\">
		<span class=\"thumbnail-score\"> $total | $ups | $favorites | $downs | $safety </span>
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
