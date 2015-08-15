<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once("$root/utils/stylelink.php")
?>

<?php
	function generateResult($mediaset)
	{
		require_once 'search/SearchBar.php';
		require_once 'resgen/ResultSet.php';
		$searchbar = generateSearchBar();
		$result = generateResultSet($mediaset);

		return [$result, $searchbar];
	}
?>
