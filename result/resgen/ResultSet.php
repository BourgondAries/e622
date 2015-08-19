<?php
	require_once 'indres/generateResultItem.php';
	function generateResultSet($mediaset)
	{
		$total = '<div class="searchitem">';
		foreach ($mediaset as &$media)
			$total .= generateResultItem
			(
				$media['id'],
				$media['up'],
				$media['fav'],
				$media['down'],
				$media['type'],
				$media['thumb']
			);
		return $total . '</div>';
	}
?>
