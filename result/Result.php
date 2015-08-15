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

		$total = "<div class=\"searchblock\">
			<div id=\"searchcontainer\">
				<div id=\"searchbar\">
					$searchbar
				</div>
				<div id=\"result\">
					$result
				</div>
			</div>
		</div>";
		return $total;
	}
	$item = array(array('id' => 1, 'up' => 321, 'down' => 93, 'fav' => 6, 'type' => 'SFW'));
	echo generateResult($item);
?>
