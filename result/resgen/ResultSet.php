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
			$total .= generateResultItem(0, rand(0, 300), rand(0, 25), rand(0, 150), "SFW");
		return $total . '</div>';
	}
?>
