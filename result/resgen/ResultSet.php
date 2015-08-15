<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once("$root/utils/stylelink.php")
?>

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
				$media['type']
			);
		return $total . '</div>';
	}
?>
