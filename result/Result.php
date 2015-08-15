<?php
	function generateResult($mediaset)
	{
		require_once 'resgen/ResultSet.php';
		$result = generateResultSet($mediaset);

		return $result;
	}
?>
