<!DOCTYPE html>
<html>
	<head>
		<title>e622 - World's Most Open Database</title>
		<link rel="stylesheet" type="test/css" href="style/cat.css">
	</head>

	<body>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require_once "utils/E621.php";
	$db = new E621;
	echo $db->version();
	echo $db->query("select * from table");
?>
	</body>
</html>
